<?php

namespace App\Domain\Identity\Enums;

enum UserType: string
{
    case ADMIN = 'admin';
    case TEACHER = 'teacher';
    case STUDENT = 'student';
    case MARKETER = 'marketer';

    public function label(): string
    {
        return match($this) {
            self::ADMIN => 'Administrator',
            self::TEACHER => 'Teacher',
            self::STUDENT => 'Student',
            self::MARKETER => 'Marketer',
        };
    }

    public function permissions(): array
    {
        return match($this) {
            self::ADMIN => [
                'view_dashboard',
                'manage_users',
                'manage_courses',
                'manage_enrollments',
                'manage_settings',
            ],
            self::TEACHER => [
                'create_courses',
                'edit_courses',
                'delete_courses',
                'view_students',
                'manage_course_content',
            ],
            self::STUDENT => [
                'view_courses',
                'enroll_courses',
                'view_course_content',
                'submit_assignments',
                'rate_courses',
            ],
            self::MARKETER => [
                'view_courses',
                'view_analytics',
                'manage_promotions',
                'view_commissions',
            ],
        };
    }
} 