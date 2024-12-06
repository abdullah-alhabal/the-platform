<?php

namespace App\Domain\Identity\Models;

use App\Domain\Course\Models\CourseEnrollment;
use App\Domain\Course\Models\Teacher;
use App\Domain\Identity\Enums\UserType;
use App\Traits\HasPermissions;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes, HasPermissions;

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'type',
        'avatar',
        'is_active',
        'last_login_at',
        'email_verified_at',
        'phone_verified_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'phone_verified_at' => 'datetime',
        'last_login_at' => 'datetime',
        'is_active' => 'boolean',
        'type' => UserType::class,
    ];

    public function teacher(): HasOne
    {
        return $this->hasOne(Teacher::class);
    }

    public function student(): HasOne
    {
        return $this->hasOne(Student::class);
    }

    public function marketer(): HasOne
    {
        return $this->hasOne(Marketer::class);
    }

    public function admin(): HasOne
    {
        return $this->hasOne(Admin::class);
    }

    public function enrollments(): HasMany
    {
        return $this->hasMany(CourseEnrollment::class, 'student_id');
    }

    public function otpCodes(): HasMany
    {
        return $this->hasMany(OtpCode::class);
    }

    public function isTeacher(): bool
    {
        return $this->type === UserType::TEACHER;
    }

    public function isStudent(): bool
    {
        return $this->type === UserType::STUDENT;
    }

    public function isMarketer(): bool
    {
        return $this->type === UserType::MARKETER;
    }

    public function isAdmin(): bool
    {
        return $this->type === UserType::ADMIN;
    }

    public function isSuperAdmin(): bool
    {
        return $this->isAdmin() && $this->admin?->is_super_admin;
    }
} 