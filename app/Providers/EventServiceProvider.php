<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class EventServiceProvider extends ServiceProvider



{

    protected $listen = [
        'App\Events\VotesUpdated' => [
            'App\Listeners\CheckVotesAndUpdateStatus',
        ],
    ];


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
        //
    }
}
