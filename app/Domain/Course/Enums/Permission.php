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
} 