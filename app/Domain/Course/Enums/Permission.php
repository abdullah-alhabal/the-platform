<?php

namespace App\Domain\Course\Enums;

enum Permission: string
{
    // Dashboard & General
    case SHOW_HOME = 'show_home';
    case SHOW_INBOX = 'show_inbox';
    case SHOW_SLIDERS = 'show_sliders';
    case SHOW_STATISTICS = 'show_statistics';
    case SHOW_FAQS = 'show_faqs';
    case SHOW_SETTINGS = 'show_settings';
    case SHOW_PAGES = 'show_pages';

    // Users & Authentication
    case SHOW_ADMINS = 'show_admins';
    case SHOW_ROLES = 'show_roles';
    case SHOW_USERS = 'show_users';
    case SHOW_LOGIN_ACTIVITY = 'show_login_activity';

    // Content Management
    case SHOW_LANGUAGES = 'show_languages';
    case SHOW_POSTS = 'show_posts';
    case SHOW_POSTS_COMMENTS = 'show_posts_comments';
    case SHOW_POST_CATEGORY = 'show_post_category';
    case SHOW_HOME_PAGE_SECTIONS = 'show_home_page_sections';
    case SHOW_WORK_STEPS = 'show_work_steps';
    case SHOW_STUDENTS_OPINIONS = 'show_students_opinions';
    case SHOW_OUR_SERVICES = 'show_our_services';
    case SHOW_OUR_PARTNERS = 'show_our_partners';
    case SHOW_OUR_MESSAGES = 'show_our_messages';
    case SHOW_OUR_TEAMS = 'show_our_teams';

    // Course Management
    case SHOW_COURSES = 'show_courses';
    case SHOW_COURSE_LEVELS = 'show_course_levels';
    case SHOW_COURSE_LANGUAGES = 'show_course_languages';
    case SHOW_COURSE_COMMENTS = 'show_course_comments';
    case SHOW_COURSE_CATEGORIES = 'show_course_categories';
    case SHOW_COURSE_STUDENTS = 'show_course_students';
    case SHOW_COURSE_RATINGS = 'show_course_ratings';
    case SHOW_ADD_COURSE_REQUESTS = 'show_add_course_requests';

    // Location & Demographics
    case SHOW_COUNTRIES = 'show_countries';
    case SHOW_AGE_CATEGORIES = 'show_age_categories';
    case SHOW_GRADE_LEVELS = 'show_grade_levels';

    // Teacher Management
    case SHOW_JOIN_AS_TEACHER_REQUESTS = 'show_join_as_teacher_requests';
    case SHOW_JOINING_CERTIFICATES = 'show_joining_certificates';
    case SHOW_JOINING_SECTIONS = 'show_joining_sections';
    case SHOW_JOINING_COURSE = 'show_joining_course';

    // Private Lessons
    case SHOW_PRIVATE_LESSONS = 'show_private_lessons';
    case SHOW_PRIVATE_LESSON_RATINGS = 'show_private_lesson_ratings';

    // Financial Management
    case SHOW_WITHDRAWAL_REQUESTS = 'show_withdrawal_requests';
    case SHOW_TRANSACTIONS = 'show_transactions';
    case SHOW_BANKS = 'show_banks';
    case SHOW_COUPONS = 'show_coupons';

    // Marketing
    case SHOW_MARKETERS_JOINING_REQUESTS = 'show_marketers_joining_requests';
    case SHOW_MARKETERS_TEMPLATES = 'show_marketers_templates';

    // Notifications
    case SHOW_NOTIFICATIONS = 'show_notifications';

    // Admin permissions
    case CREATE_ADMINS = 'create_admins';
    case EDIT_ADMINS = 'edit_admins';
    case DELETE_ADMINS = 'delete_admins';

    // Teacher permissions
    case VIEW_TEACHERS = 'view_teachers';
    case CREATE_TEACHERS = 'create_teachers';
    case EDIT_TEACHERS = 'edit_teachers';
    case DELETE_TEACHERS = 'delete_teachers';

    // Course permissions
    case VIEW_COURSES = 'view_courses';
    case CREATE_COURSES = 'create_courses';
    case EDIT_COURSES = 'edit_courses';
    case DELETE_COURSES = 'delete_courses';
    case PUBLISH_COURSES = 'publish_courses';

    // Enrollment permissions
    case VIEW_ENROLLMENTS = 'view_enrollments';
    case CREATE_ENROLLMENTS = 'create_enrollments';
    case CANCEL_ENROLLMENTS = 'cancel_enrollments';
    case REFUND_ENROLLMENTS = 'refund_enrollments';

    // Rating permissions
    case VIEW_RATINGS = 'view_ratings';
    case CREATE_RATINGS = 'create_ratings';
    case EDIT_RATINGS = 'edit_ratings';
    case DELETE_RATINGS = 'delete_ratings';
    case REPLY_TO_RATINGS = 'reply_to_ratings';

    // Lesson permissions
    case VIEW_LESSONS = 'view_lessons';
    case CREATE_LESSONS = 'create_lessons';
    case EDIT_LESSONS = 'edit_lessons';
    case DELETE_LESSONS = 'delete_lessons';
    case COMPLETE_LESSONS = 'complete_lessons';

    // Report permissions
    case VIEW_REPORTS = 'view_reports';
    case EXPORT_REPORTS = 'export_reports';
    case GENERATE_ANALYTICS = 'generate_analytics';

    public function label(): string
    {
        return str_replace('_', ' ', strtolower($this->name));
    }

    public static function getGroups(): array
    {
        return [
            'Dashboard & General' => [
                self::SHOW_HOME,
                self::SHOW_INBOX,
                self::SHOW_SLIDERS,
                self::SHOW_STATISTICS,
                self::SHOW_FAQS,
                self::SHOW_SETTINGS,
                self::SHOW_PAGES,
            ],
            'Users & Authentication' => [
                self::SHOW_ADMINS,
                self::SHOW_ROLES,
                self::SHOW_USERS,
                self::SHOW_LOGIN_ACTIVITY,
            ],
            // ... add other groups
        ];
    }

    public function description(): string
    {
        return match($this) {
            // Admin descriptions
            self::SHOW_ADMINS => 'View administrator details',
            self::CREATE_ADMINS => 'Create new administrators',
            self::EDIT_ADMINS => 'Edit administrator details',
            self::DELETE_ADMINS => 'Delete administrators',

            // Teacher descriptions
            self::VIEW_TEACHERS => 'View teacher profiles',
            self::CREATE_TEACHERS => 'Create new teacher profiles',
            self::EDIT_TEACHERS => 'Edit teacher profiles',
            self::DELETE_TEACHERS => 'Delete teacher profiles',

            // Course descriptions
            self::VIEW_COURSES => 'View course details',
            self::CREATE_COURSES => 'Create new courses',
            self::EDIT_COURSES => 'Edit course details',
            self::DELETE_COURSES => 'Delete courses',
            self::PUBLISH_COURSES => 'Publish or unpublish courses',

            // Enrollment descriptions
            self::VIEW_ENROLLMENTS => 'View course enrollments',
            self::CREATE_ENROLLMENTS => 'Create course enrollments',
            self::CANCEL_ENROLLMENTS => 'Cancel course enrollments',
            self::REFUND_ENROLLMENTS => 'Process enrollment refunds',

            // Rating descriptions
            self::VIEW_RATINGS => 'View course ratings',
            self::CREATE_RATINGS => 'Create course ratings',
            self::EDIT_RATINGS => 'Edit course ratings',
            self::DELETE_RATINGS => 'Delete course ratings',
            self::REPLY_TO_RATINGS => 'Reply to course ratings',

            // Lesson descriptions
            self::VIEW_LESSONS => 'View course lessons',
            self::CREATE_LESSONS => 'Create course lessons',
            self::EDIT_LESSONS => 'Edit course lessons',
            self::DELETE_LESSONS => 'Delete course lessons',
            self::COMPLETE_LESSONS => 'Mark lessons as completed',

            // Report descriptions
            self::VIEW_REPORTS => 'View system reports',
            self::EXPORT_REPORTS => 'Export system reports',
            self::GENERATE_ANALYTICS => 'Generate system analytics',
        };
    }
} 