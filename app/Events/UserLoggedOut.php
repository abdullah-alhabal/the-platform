<?php

declare(strict_types=1);

namespace App\Events;

use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

final class UserLoggedOut
{
    use Dispatchable;
    use SerializesModels;

    /** @var Authenticatable */
    public User $user;

    /**
     * Create a new event instance.
     *
     * @param Authenticatable $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }
}
