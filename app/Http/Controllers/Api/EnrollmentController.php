<?php

namespace App\Http\Controllers\Api;

use App\Domain\Course\Models\Course;
use App\Domain\Course\Models\CourseEnrollment;
use App\Domain\Course\Services\EnrollmentService;
use App\Domain\Course\Exceptions\EnrollmentException;
use App\Http\Requests\Enrollment\CreateEnrollmentRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class EnrollmentController extends ApiController
{
    protected EnrollmentService $enrollmentService;

    public function __construct(EnrollmentService $enrollmentService)
    {
        $this->enrollmentService = $enrollmentService;
    }

    public function enroll(CreateEnrollmentRequest $request, Course $course): JsonResponse
    {
        try {
            $enrollment = $this->enrollmentService->enrollStudent(
                $course,
                $request->user()->id,
                $request->validated()
            );

            return $this->createdResponse(
                $this->enrollmentService->getEnrollmentDetails($enrollment)->toArray(),
                'Enrolled successfully'
            );
        } catch (EnrollmentException $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    public function completeLesson(Request $request, CourseEnrollment $enrollment): JsonResponse
    {
        try {
            $request->validate(['lesson_id' => 'required|exists:lessons,id']);

            $completed = $this->enrollmentService->completeLesson(
                $enrollment,
                $request->lesson_id
            );

            return $completed
                ? $this->successResponse(null, 'Lesson marked as completed')
                : $this->errorResponse('Failed to mark lesson as completed');
        } catch (EnrollmentException $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    public function show(CourseEnrollment $enrollment): JsonResponse
    {
        $enrollmentDTO = $this->enrollmentService->getEnrollmentDetails($enrollment);
        return $this->successResponse($enrollmentDTO->toArray());
    }

    public function extend(Request $request, CourseEnrollment $enrollment): JsonResponse
    {
        try {
            $request->validate(['days' => 'required|integer|min:1']);

            $extended = $this->enrollmentService->extendEnrollment(
                $enrollment,
                $request->days
            );

            return $extended
                ? $this->successResponse(['expires_at' => $enrollment->fresh()->expires_at])
                : $this->errorResponse('Failed to extend enrollment');
        } catch (EnrollmentException $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    public function pause(CourseEnrollment $enrollment): JsonResponse
    {
        try {
            $paused = $this->enrollmentService->pauseEnrollment($enrollment);
            return $paused
                ? $this->successResponse(null, 'Enrollment paused successfully')
                : $this->errorResponse('Failed to pause enrollment');
        } catch (EnrollmentException $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    public function resume(CourseEnrollment $enrollment): JsonResponse
    {
        try {
            $resumed = $this->enrollmentService->resumeEnrollment($enrollment);
            return $resumed
                ? $this->successResponse(null, 'Enrollment resumed successfully')
                : $this->errorResponse('Failed to resume enrollment');
        } catch (EnrollmentException $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    public function cancel(CourseEnrollment $enrollment): JsonResponse
    {
        try {
            $cancelled = $this->enrollmentService->cancelEnrollment($enrollment);
            return $cancelled
                ? $this->successResponse(null, 'Enrollment cancelled successfully')
                : $this->errorResponse('Failed to cancel enrollment');
        } catch (EnrollmentException $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    public function studentProgress(Request $request): JsonResponse
    {
        $progress = $this->enrollmentService->getStudentProgress(
            $request->user()->id,
            $request->input('course_id')
        );

        return $this->successResponse($progress);
    }

    public function studentEnrollments(Request $request): JsonResponse
    {
        $filters = $request->only(['status', 'course_id', 'is_expired']);
        $enrollments = $this->enrollmentService->getEnrollmentRepository()
            ->getStudentEnrollments($request->user()->id, $filters);

        return $this->successResponse($enrollments->map(function ($enrollment) {
            return $this->enrollmentService->getEnrollmentDetails($enrollment)->toArray();
        }));
    }

    public function courseEnrollments(Course $course): JsonResponse
    {
        $enrollments = $this->enrollmentService->getEnrollmentRepository()
            ->getCourseEnrollments($course->id);

        return $this->successResponse($enrollments->map(function ($enrollment) {
            return $this->enrollmentService->getEnrollmentDetails($enrollment)->toArray();
        }));
    }
} 