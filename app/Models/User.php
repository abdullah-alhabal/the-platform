<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\User\Gender;
use App\Services\File\FileService;
use Barryvdh\LaravelIdeHelper\Eloquent;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Notifications\DatabaseNotificationCollection;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasRoles;

/**
 * Class User.
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property string $role
 * @property bool $is_blocked
 * @property bool $is_validated
 * @property bool $is_accredited
 * @property string|null $id_card_image
 * @property string|null $employment_proof_image
 * @property string|null $resume_file
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property Carbon|null $email_verified_at
 * @property string $mobile
 * @property string $validation_code
 * @property Carbon|null $validation_at
 * @property Carbon|null $last_send_validation_code
 * @property Gender $gender
 * @property Carbon|null $date_of_birth
 * @property string $country_code
 * @property string $country_slug
 * @property int|null $country_id
 * @property string $city
 * @property string $device_token
 * @property bool $belongs_to_awael
 * @property int|null $mother_lang_id
 * @property float $system_commission
 * @property string|null $system_commission_reason
 * @property bool $can_add_half_hour
 * @property float $half_hour_price
 * @property float $hour_price
 * @property int $min_student_no
 * @property int $max_student_no
 * @property Carbon|null $last_login_at
 * @property int|null $market_id
 * @property int|null $coupon_id
 * @property string|null $remember_token
 * @property-read DatabaseNotificationCollection<int, DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read Collection<int, Permission> $permissions
 * @property-read int|null $permissions_count
 * @property-read Collection<int, Role> $roles
 * @property-read int|null $roles_count
 * @property-read Collection<int, PersonalAccessToken> $tokens
 * @property-read int|null $tokens_count
 *
 * @method static UserFactory factory($count = null, $state = [])
 * @method static Builder<static>|User newModelQuery()
 * @method static Builder<static>|User newQuery()
 * @method static Builder<static>|User onlyTrashed()
 * @method static Builder<static>|User permission($permissions, $without = false)
 * @method static Builder<static>|User query()
 * @method static Builder<static>|User role($roles, $guard = null, $without = false)
 * @method static Builder<static>|User whereCreatedAt($value)
 * @method static Builder<static>|User whereEmail($value)
 * @method static Builder<static>|User whereEmailVerifiedAt($value)
 * @method static Builder<static>|User whereId($value)
 * @method static Builder<static>|User whereName($value)
 * @method static Builder<static>|User wherePassword($value)
 * @method static Builder<static>|User whereRememberToken($value)
 * @method static Builder<static>|User whereUpdatedAt($value)
 * @method static Builder<static>|User withTrashed()
 * @method static Builder<static>|User withoutPermission($permissions)
 * @method static Builder<static>|User withoutRole($roles, $guard = null)
 * @method static Builder<static>|User withoutTrashed()
 *
 * @mixin Eloquent
 */
final class User extends Authenticatable
{
    use HasApiTokens, HasFactory, HasRoles, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    /** @var array<int, string> */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'is_blocked',
        'is_validated',
        'is_accredited',
        'id_card_image',
        'mobile',
        'validation_code',
        'validation_at',
        'last_send_validation_code',
        'gender',
        'date_of_birth',
        'country_code',
        'country_slug',
        'country_id',
        'city',
        'device_token',
        'belongs_to_awael',
        'mother_lang_id',
        'min_student_no',
        'max_student_no',
        'last_login_at',
        'market_id',
        'coupon_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Accessor for the "name" attribute.
     *
     * @return string
     */
    public function getNameAttribute(): string
    {
        return ucfirst($this->attributes['name']);
    }

    /**
     * Mutator for the "name" attribute.
     *
     * @param string $value
     */
    public function setNameAttribute(string $value): void
    {
        $this->attributes['name'] = mb_strtolower($value);
    }

    /**
     * Accessor for the "email" attribute.
     *
     * @return string
     */
    public function getEmailAttribute(): string
    {
        return mb_strtolower($this->attributes['email']);
    }

    /**
     * Mutator for the "email" attribute.
     *
     * @param string $value
     */
    public function setEmailAttribute(string $value): void
    {
        $this->attributes['email'] = mb_strtolower($value);
    }

    /**
     * Accessor for the "id_card_image" attribute.
     *
     * @return string|null
     */
    public function getIdCardImageAttribute(): ?string
    {
        return app(FileService::class)->getFullUrl($this->attributes['id_card_image']);
    }

    /**
     * Accessor for the "employment_proof_image" attribute.
     *
     * @return string|null
     */
    public function getEmploymentProofImageAttribute(): ?string
    {
        return app(FileService::class)->getFullUrl($this->attributes['employment_proof_image']);
    }

    /**
     * Accessor for the "resume_file" attribute.
     *
     * @return string|null
     */
    public function getResumeFileAttribute(): ?string
    {
        return app(FileService::class)->getFullUrl($this->attributes['resume_file']);
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_blocked' => 'boolean',
            'is_validated' => 'boolean',
            'is_accredited' => 'boolean',
            'validation_at' => 'datetime',
            'last_send_validation_code' => 'datetime',
            'date_of_birth' => 'date',
            'belongs_to_awael' => 'boolean',
            'can_add_half_hour' => 'boolean',
            'last_login_at' => 'datetime',
            'gender' => Gender::class, // Using the enum
        ];
    }
}
