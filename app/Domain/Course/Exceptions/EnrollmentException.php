<?php

namespace App\Domain\Course\Exceptions;

use Exception;

class EnrollmentException extends Exception
{
    public static function alreadyEnrolled(): self
    {
        return new self('Student is already enrolled in this course');
    }

    public static function courseNotAvailable(): self
    {
        return new self('Course is not available for enrollment');
    }

    public static function expired(): self
    {
        return new self('Cannot resume expired enrollment');
    }

    public static function invalidPaymentStatus(): self
    {
        return new self('Cannot enroll with invalid payment status');
    }

    public static function enrollmentNotFound(): self
    {
        return new self('Enrollment not found');
    }

    public static function invalidProgress(): self
    {
        return new self('Invalid progress value');
    }
} 