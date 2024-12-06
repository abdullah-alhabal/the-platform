<?php

namespace App\Policies;

use App\Domain\Course\Enums\Permission;
use App\Domain\Course\Models\Course;
use App\Models\User;

class CoursePolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasPermission(Permission::VIEW_COURSES);
    }

    public function view(User $user, Course $course): bool
    {
        if ($user->hasPermission(Permission::VIEW_COURSES)) {
            return true;
        }

        // Students can view courses they're enrolled in
        return $course->enrollments()->where('user_id', $user->id)->exists();
    }

    public function create(User $user): bool
    {
        return $user->hasPermission(Permission::CREATE_COURSES);
    }

    public function update(User $user, Course $course): bool
    {
        if ($user->hasPermission(Permission::EDIT_COURSES)) {
            return true;
        }

        // Teachers can edit their own courses
        return $course->teacher_id === $user->id;
    }

    public function delete(User $user, Course $course): bool
    {
        if ($user->hasPermission(Permission::DELETE_COURSES)) {
            return true;
        }

        // Teachers can delete their own unpublished courses
        return $course->teacher_id === $user->id && !$course->is_published;
    }

    public function publish(User $user, Course $course): bool
    {
        if ($user->hasPermission(Permission::PUBLISH_COURSES)) {
            return true;
        }

        // Teachers can publish their own courses
        return $course->teacher_id === $user->id;
    }

    public function enroll(User $user, Course $course): bool
    {
        // Users can't enroll in their own courses
        if ($course->teacher_id === $user->id) {
            return false;
        }

        // Check if user is already enrolled
        if ($course->enrollments()->where('user_id', $user->id)->exists()) {
            return false;
        }

        return $user->hasPermission(Permission::CREATE_ENROLLMENTS);
    }

    public function rate(User $user, Course $course): bool
    {
        if (!$user->hasPermission(Permission::CREATE_RATINGS)) {
            return false;
        }

        // Users can only rate courses they're enrolled in
        return $course->enrollments()->where('user_id', $user->id)->exists();
    }
} 