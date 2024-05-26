<?php

namespace App\Providers;

use App\Models\Lead;
use App\Models\User;
use App\Observers\LeadObserver;
use App\Observers\UserObserver;
use Illuminate\Support\ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Lead::observe(LeadObserver::class);
        User::observe(UserObserver::class);
    }
}
