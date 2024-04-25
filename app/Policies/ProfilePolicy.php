<?php

namespace App\Policies;

use App\Models\Profile;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Gate;

class ProfilePolicy
{
    use HandlesAuthorization;

    public function update(User $user, Profile $profile)
    {
        // return Gate::allows('is_admin', $user) || $user->Administrator();
        $user = User::find(1);
        if ($user && $user->is_admin) {
           
        } else {
            echo "User is not authorized for admin tasks";
        }
    }

}

