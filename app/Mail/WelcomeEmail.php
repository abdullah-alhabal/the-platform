<?php

declare(strict_types=1);

namespace App\Mail;

use App\Models\User;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

/**
 * WelcomeEmail is a mailable class for sending welcome emails to users.
 */
final class WelcomeEmail extends Mailable
{
    use SerializesModels;

    protected User $user;

    /**
     * Create a new message instance.
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build(): self
    {
        return $this->subject('Welcome to Our Platform')
            ->view('emails.welcome') // Specify the view for the email
            ->with(['user' => $this->user]); // Pass user data to the view
    }
}
