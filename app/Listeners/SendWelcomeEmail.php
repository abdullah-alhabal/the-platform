<?php

declare(strict_types=1);

namespace App\Listeners;

use App\Mail\WelcomeEmail;
use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

/**
 * SendWelcomeEmail listener.
 *
 * This listener is responsible for sending a welcome email to a newly registered user.
 */
final class SendWelcomeEmail implements ShouldQueue
{
    /**
     * Handle the event.
     *
     * This method is triggered when a user registers. It sends a welcome email to the user.
     *
     * @param Registered $event The registered event.
     */
    public function handle(Registered $event): void
    {
        Mail::to($event->user->email)->send(new WelcomeEmail($event->user));
    }
}
