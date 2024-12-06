<?php

namespace App\Domain\Identity\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Admin extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'department',
        'position',
        'is_super_admin',
        'access_level',
        'last_action_at',
    ];

    protected $casts = [
        'is_super_admin' => 'boolean',
        'last_action_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function isSuperAdmin(): bool
    {
        return $this->is_super_admin;
    }

    public function hasAccessLevel(int $level): bool
    {
        return $this->access_level >= $level;
    }

    public function updateLastAction(): void
    {
        $this->update(['last_action_at' => now()]);
    }
} 