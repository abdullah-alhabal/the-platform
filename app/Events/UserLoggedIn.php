<?php

declare(strict_types=1);

namespace App\Events;

use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

final class UserLoggedIn
{
    use Dispatchable;
    use SerializesModels;

    /** @var Authenticatable */
    public User $user;

    public string $deviceName;

    /**
     * Create a new event instance.
     */
    public function __construct(User $user, string $deviceName)
    {
        $this->user = $user;
        $this->deviceName = $deviceName;
    }
}
