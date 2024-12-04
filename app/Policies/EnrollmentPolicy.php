<?php

namespace App\Policies;

use App\Domain\Course\Models\CourseEnrollment;
use App\Models\User;
use App\Domain\Course\Enums\Permission;

class EnrollmentPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasPermission(Permission::SHOW_COURSE_STUDENTS->value);
    }

    public function view(User $user, CourseEnrollment $enrollment): bool
    {
        return $user->hasPermission(Permission::SHOW_COURSE_STUDENTS->value)
            || $user->id === $enrollment->student_id
            || $user->id === $enrollment->course->teacher->user_id;
    }

    public function create(User $user): bool
    {
        return true; // Any authenticated user can enroll
    }

    public function update(User $user, CourseEnrollment $enrollment): bool
    {
        return $user->hasPermission(Permission::SHOW_COURSE_STUDENTS->value)
            || $user->id === $enrollment->student_id;
    }

    public function delete(User $user, CourseEnrollment $enrollment): bool
    {
        return $user->hasPermission(Permission::SHOW_COURSE_STUDENTS->value);
    }

    public function completeLesson(User $user, CourseEnrollment $enrollment): bool
    {
        return $user->id === $enrollment->student_id
            && $enrollment->isActive();
    }

    public function viewProgress(User $user, CourseEnrollment $enrollment): bool
    {
        return $user->hasPermission(Permission::SHOW_COURSE_STUDENTS->value)
            || $user->id === $enrollment->student_id
            || $user->id === $enrollment->course->teacher->user_id;
    }

    public function manageStatus(User $user, CourseEnrollment $enrollment): bool
    {
        return $user->hasPermission(Permission::SHOW_COURSE_STUDENTS->value)
            || $user->id === $enrollment->student_id;
    }

    public function extend(User $user, CourseEnrollment $enrollment): bool
    {
        return $user->hasPermission(Permission::SHOW_COURSE_STUDENTS->value)
            || $user->id === $enrollment->student_id;
    }
} 