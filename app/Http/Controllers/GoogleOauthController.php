<?php

namespace App\Http\Controllers;

use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\User;

class GoogleOauthController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('google')->stateless()->redirect();
    }

    public function callback()
    {
        try {
            $googleUser = Socialite::driver('google')->stateless()->user();

            $user = User::where('email', $googleUser->email)->first();

            if (!$user) {
                $user = User::create([
                    'name' => $googleUser->name,
                    'email' => $googleUser->email,
                    'password' => Hash::make(Str::random(16)),
                    'google_id' => $googleUser->id,
                ]);
            }

            Auth::login($user);

            $accessToken = $user->createToken('AuthToken')->plainTextToken;

            return response()->json([
                'user' => $user,
                'access_token' => $accessToken,
                'message' => 'User authenticated successfully.'
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to authenticate user.'], 500);
        }
    }
}
