<?php

namespace App\Domain\Course\Services;

use App\Domain\Course\Models\CourseEnrollment;
use App\Domain\Course\Models\Course;
use App\Domain\Course\Interfaces\EnrollmentRepositoryInterface;
use App\Domain\Course\DTOs\EnrollmentDTO;
use App\Domain\Course\Events\CourseEnrolled;
use App\Domain\Course\Events\CourseCompleted;
use App\Domain\Course\Exceptions\EnrollmentException;
use Illuminate\Support\Facades\DB;
use Exception;

class EnrollmentService
{
    protected EnrollmentRepositoryInterface $enrollmentRepository;

    public function __construct(EnrollmentRepositoryInterface $enrollmentRepository)
    {
        $this->enrollmentRepository = $enrollmentRepository;
    }

    public function enrollStudent(Course $course, int $studentId, array $data): CourseEnrollment
    {
        try {
            // Check if student is already enrolled
            if ($this->isStudentEnrolled($course->id, $studentId)) {
                throw new EnrollmentException('Student is already enrolled in this course');
            }

            // Validate course availability
            if (!$course->is_published) {
                throw new EnrollmentException('Course is not available for enrollment');
            }

            DB::beginTransaction();

            $enrollmentData = array_merge($data, [
                'course_id' => $course->id,
                'student_id' => $studentId,
                'status' => 'active',
                'progress_percentage' => 0,
                'enrolled_at' => now(),
            ]);

            // Set expiry date if course has duration limit
            if ($course->duration_limit) {
                $enrollmentData['expires_at'] = now()->addDays($course->duration_limit);
            }

            $enrollment = $this->enrollmentRepository->create($enrollmentData);

            // Fire enrollment event
            event(new CourseEnrolled($enrollment));

            DB::commit();

            return $enrollment;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function completeLesson(CourseEnrollment $enrollment, int $lessonId): bool
    {
        try {
            DB::beginTransaction();

            // Create lesson completion record
            $enrollment->lessonCompletions()->create([
                'lesson_id' => $lessonId,
                'completed_at' => now(),
            ]);

            // Update enrollment progress
            $this->enrollmentRepository->updateProgress($enrollment);

            // Check if course is completed
            if ($enrollment->progress_percentage === 100) {
                $this->enrollmentRepository->markAsCompleted($enrollment);
                event(new CourseCompleted($enrollment));
            }

            DB::commit();

            return true;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function getEnrollmentDetails(CourseEnrollment $enrollment): EnrollmentDTO
    {
        $stats = $this->enrollmentRepository->getEnrollmentStats($enrollment);
        return new EnrollmentDTO($enrollment, $stats);
    }

    public function extendEnrollment(CourseEnrollment $enrollment, int $days): bool
    {
        try {
            DB::beginTransaction();

            $currentExpiry = $enrollment->expires_at ?? now();
            $newExpiry = $currentExpiry->addDays($days);

            $updated = $this->enrollmentRepository->update($enrollment, [
                'expires_at' => $newExpiry,
                'status' => 'active', // Reactivate if it was expired
            ]);

            DB::commit();

            return $updated;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function pauseEnrollment(CourseEnrollment $enrollment): bool
    {
        return $this->enrollmentRepository->update($enrollment, [
            'status' => 'paused',
        ]);
    }

    public function resumeEnrollment(CourseEnrollment $enrollment): bool
    {
        if ($enrollment->isExpired()) {
            throw new EnrollmentException('Cannot resume expired enrollment');
        }

        return $this->enrollmentRepository->update($enrollment, [
            'status' => 'active',
        ]);
    }

    public function cancelEnrollment(CourseEnrollment $enrollment): bool
    {
        return $this->enrollmentRepository->update($enrollment, [
            'status' => 'cancelled',
        ]);
    }

    public function getStudentProgress(int $studentId, ?int $courseId = null): array
    {
        $filters = $courseId ? ['course_id' => $courseId] : [];
        $enrollments = $this->enrollmentRepository->getStudentEnrollments($studentId, $filters);

        return [
            'total_courses' => $enrollments->count(),
            'completed_courses' => $enrollments->where('status', 'completed')->count(),
            'active_courses' => $enrollments->where('status', 'active')->count(),
            'average_progress' => $enrollments->avg('progress_percentage'),
            'total_completed_lessons' => $enrollments->sum(function ($enrollment) {
                return $enrollment->lessonCompletions->count();
            }),
            'enrollments' => $enrollments->map(function ($enrollment) {
                return new EnrollmentDTO($enrollment);
            })->toArray(),
        ];
    }

    protected function isStudentEnrolled(int $courseId, int $studentId): bool
    {
        return CourseEnrollment::where('course_id', $courseId)
            ->where('student_id', $studentId)
            ->whereIn('status', ['active', 'paused'])
            ->exists();
    }

    public function handleExpiredEnrollments(): void
    {
        $expiredEnrollments = $this->enrollmentRepository->getExpiredEnrollments();

        foreach ($expiredEnrollments as $enrollment) {
            $this->enrollmentRepository->update($enrollment, [
                'status' => 'expired',
            ]);
        }
    }
} 