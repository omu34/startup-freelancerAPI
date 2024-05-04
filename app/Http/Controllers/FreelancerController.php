<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Notifications\ProfileNotApproved;
use App\Notifications\ProfileDeniedApproval;
use Illuminate\Support\Facades\Notification;
use App\Notifications\ProfileHasBeenApproved;
use App\Notifications\ProfileApprovalRevoked;
use App\Notifications\ProfileCreatedUpdatedSuccess;
use App\Notifications\RequestingForProfileApproval;


class FreelancerController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function userUpdateProfile(Profile $profile, Request $request)
    {
        try {
            $user = $request->user();
            if (!$user->profile) {
                $user->profile()->create([]);
            }

            $profile = $user->profile;

            $validatedData = $request->validate([
                'first_name' => 'required',
                'last_name' => 'required',
            ]);

            $profile->update($validatedData);

            $user->notify(new ProfileCreatedUpdatedSuccess($profile));

            return response()->json(['message' => 'Profile created/updated successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to create/update profile.'], 500);
        }
    }


    /**
     * Show the form for creating a new resource.
     */
    public function userSendApprovalRequest(Request $request)
    {
        try {
            $user = $request->user();
            if (!$user->profile) {
                $user->profile()->create(['status' => 'is_requesting_for_approval']);
            } else {
                $user->profile->update(['status' => 'is_requesting_for_approval']);
            }

            $adminUser = User::where('is_admin', true)->first();

            if ($adminUser) {
                Notification::send($adminUser, new RequestingForProfileApproval($user));
            }

            return response()->json(['message' => 'Profile approval request has been sent to the administrator']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'User Failed to To send Approval.'], 500);
        }
    }


    /**
     * Store a newly created resource in storage.
     */
    public function adminFetchPendingApproval(Profile $profile, Request $request)
    {
        try {
            $user = User::find(1);
            if ($user && $user->is_admin) {
                echo "Allowed to Execute";
            } else {
                echo "User is not authorized for admin tasks";
            }

            $profiles = Profile::where('status', 'is_requesting_for_approval')->get();
            if ($profiles->isNotEmpty()) {
                $requestingProfileCount = $profiles->count();
                $admins = User::where('is_admin', true)->get();
                foreach ($admins as $admin) {
                    $admin->notify(new RequestingForProfileApproval($requestingProfileCount));
                }
                return response()->json([
                    'message' => "Admin, you have {$requestingProfileCount} profile approval request(s)",
                    'profiles' => $profiles->map(function ($profile) {
                        return [
                            'id' => $profile->id,
                            'first_name' => $profile->user->name,
                        ];
                    }),
                ]);
            }
            return response()->json(['message' => 'No pending profile approvals']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Admin Failed to Fetch Profile.'], 500);
        }
    }

    /**
     * Display the specified resource.
     */

    public function adminDecidesApproval(Request $request, Profile $profile)
    {
        try {
            $user = User::find(1);
            if ($user && $user->is_admin) {
                echo "Allowed to Execute";
            } else {
                echo "User is not authorized for admin tasks";
            }

            $validatedData = $request->validate([
                'status' => 'required|in:not_approved,has_been_approved,has_been_denied_approval,is_approval_revoked', 'is_requesting_for_approval',
            ]);

            $profile->update(['status' => $validatedData['status']]);

            $notification = match ($validatedData['status']) {
                'not_approved' => new ProfileNotApproved($profile),
                'has_been_approved' => new ProfileHasBeenApproved($profile),
                'has_been_denied_approval' => new ProfileDeniedApproval($profile),
                'is_approval_revoked' => new ProfileApprovalRevoked($profile),
                default => null,
            };

            if ($notification !== null && $profile->user !== null) {
                $profile->user->notify($notification);
            }

            return response()->json(['message' => 'Profile status updated successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Admin Failed to Approve Profile.'], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */

    public function deleteProfile(Profile $profile)
    {

        // if ($request->user()->type == "is_admin") {
        //     throw new Exception("You are  authorized to perform this action");
        // }
        try {
            $profile->delete();

            return response()->json(['message' => 'Profile deleted successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to Delete Profile.'], 500);
        }
    }
}
