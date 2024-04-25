<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Notifications\ProfileUpdate;
use App\Notifications\ProfileUnderCheck;
use App\Notifications\RequestingForProfileApproval;



class EventServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    protected $listen = [
        // ProfileUpdate::class,
        ProfileUnderCheck::class,
        RequestingForProfileApproval::class
    ];

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}

