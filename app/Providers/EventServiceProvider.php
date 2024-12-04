<?php

declare(strict_types=1);

namespace App\Providers;

use App\Listeners\SendWelcomeEmail;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

/**
 * EventServiceProvider class.
 *
 * This class handles the event listener mappings for the application.
 */
final class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array<int, array<int, string>>
     */
    protected $listen = [
        Registered::class => [
            SendWelcomeEmail::class,
        ],
    ];
}
