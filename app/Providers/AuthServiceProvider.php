<?php

namespace App\Providers;

use App\Http\Middleware\CheckRole;
use Illuminate\Support\Facades\Gate;
use App\Models\User;
use App\Models\Profile;
use App\Policies\ProfilePolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */

    protected $policies = [
        Profile::class => ProfilePolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot()
    {


        $this->registerPolicies();

        Gate::define('is_admin', function ($user) {
            return 'allowed to perform';
        });



        Gate::define('update-profile', function (User $user, Profile $profile) {
            return $user->is($profile->user);
        });

        Gate::before(function ($user, $ability) {
            if ($user->is_admin()) {
                return true;
            }
        });
    }
}
