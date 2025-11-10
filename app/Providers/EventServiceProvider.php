<?php

namespace App\Providers;

use App\Events\BusinessCreated;
use App\Events\UserRegistered;
use App\Listeners\SendBusinessOwnerWelcomeEmail;
use App\Listeners\SendWelcomeEmail;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as BaseEventServiceProvider;

class EventServiceProvider extends BaseEventServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        UserRegistered::class => [
            SendWelcomeEmail::class,
        ],
        BusinessCreated::class => [
            SendBusinessOwnerWelcomeEmail::class,
        ],
    ];
}
