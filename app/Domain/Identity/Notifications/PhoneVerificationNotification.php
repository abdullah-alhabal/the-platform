<?php

namespace App\Domain\Identity\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\VonageMessage;
use Illuminate\Notifications\Notification;

class PhoneVerificationNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        private readonly string $code
    ) {}

    public function via($notifiable): array
    {
        return ['vonage'];
    }

    public function toVonage($notifiable): VonageMessage
    {
        return (new VonageMessage)
            ->content("Your verification code is: {$this->code}. This code will expire in 15 minutes.");
    }
} 