<?php

namespace App\Policies;

use App\Domain\Course\Models\Teacher;
use App\Models\User;
use App\Domain\Course\Enums\Permission;

class TeacherPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasPermission(Permission::SHOW_ADMINS->value);
    }

    public function view(User $user, Teacher $teacher): bool
    {
        return $user->hasPermission(Permission::SHOW_ADMINS->value)
            || $user->id === $teacher->user_id;
    }

    public function create(User $user): bool
    {
        return $user->hasPermission(Permission::SHOW_ADMINS->value);
    }

    public function update(User $user, Teacher $teacher): bool
    {
        return $user->hasPermission(Permission::SHOW_ADMINS->value)
            || $user->id === $teacher->user_id;
    }

    public function delete(User $user, Teacher $teacher): bool
    {
        return $user->hasPermission(Permission::SHOW_ADMINS->value);
    }

    public function manageRequests(User $user): bool
    {
        return $user->hasPermission(Permission::SHOW_JOIN_AS_TEACHER_REQUESTS->value);
    }

    public function manageCertificates(User $user): bool
    {
        return $user->hasPermission(Permission::SHOW_JOINING_CERTIFICATES->value);
    }

    public function viewStatistics(User $user, Teacher $teacher): bool
    {
        return $user->hasPermission(Permission::SHOW_STATISTICS->value)
            || $user->id === $teacher->user_id;
    }
}
