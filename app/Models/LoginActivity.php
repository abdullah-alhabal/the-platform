<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\LoginActivity\LoginActivityType;
use App\Enums\User\UserType;
use Carbon\Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $user_id
 * @property string $user_agent
 * @property string $ip_address
 * @property LoginActivityType $type
 * @property UserType $user_type
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @method static Builder|LoginActivity newModelQuery()
 * @method static Builder|LoginActivity newQuery()
 * @method static Builder|LoginActivity query()
 *
 * @property-read User|null $user
 *
 * @mixin Eloquent
 */
final class LoginActivity extends Model
{
    use HasFactory;

    /** @var array<int, string> */
    protected $fillable = [
        'user_id',
        'user_agent',
        'ip_address',
        'type',
        'user_type',
    ];

    /**
     * Get the user that owns the login activity.
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the type attribute.
     *
     * @return LoginActivityType
     */
    public function getTypeAttribute(): LoginActivityType
    {
        return LoginActivityType::from($this->attributes['type']);
    }

    /**
     * Set the type attribute.
     *
     * @param LoginActivityType $value
     */
    public function setTypeAttribute(LoginActivityType $value): void
    {
        $this->attributes['type'] = $value->value;
    }

    /**
     * Get the user_type attribute.
     *
     * @return UserType
     */
    public function getUserTypeAttribute(): UserType
    {
        return UserType::from($this->attributes['user_type']);
    }

    /**
     * Set the user_type attribute.
     *
     * @param UserType $value
     */
    public function setUserTypeAttribute(UserType $value): void
    {
        $this->attributes['user_type'] = $value->value;
    }

    /**
     * Get the created_at attribute.
     *
     * @return Carbon
     */
    public function getCreatedAtAttribute(): Carbon
    {
        return new Carbon($this->attributes['created_at']);
    }

    /**
     * Get the updated_at attribute.
     *
     * @return Carbon
     */
    public function getUpdatedAtAttribute(): Carbon
    {
        return new Carbon($this->attributes['updated_at']);
    }
}
