<?php

namespace App\OpenApi\Schemas;

/**
 * @OA\Schema(
 *     schema="Enrollment",
 *     type="object",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="course_id", type="integer", example=1),
 *     @OA\Property(property="student_id", type="integer", example=1),
 *     @OA\Property(property="paid_amount", type="number", format="float", example=99.99),
 *     @OA\Property(property="payment_method", type="string", example="credit_card"),
 *     @OA\Property(property="payment_status", type="string", example="completed"),
 *     @OA\Property(property="enrolled_at", type="string", format="date-time"),
 *     @OA\Property(property="expires_at", type="string", format="date-time", nullable=true),
 *     @OA\Property(property="status", type="string", example="active"),
 *     @OA\Property(property="progress_percentage", type="number", format="float", example=45.5),
 *     @OA\Property(property="last_accessed_at", type="string", format="date-time", nullable=true),
 *     @OA\Property(
 *         property="course",
 *         type="object",
 *         @OA\Property(property="id", type="integer", example=1),
 *         @OA\Property(property="title", type="string", example="Advanced Mathematics"),
 *         @OA\Property(property="thumbnail", type="string", format="uri")
 *     ),
 *     @OA\Property(
 *         property="student",
 *         type="object",
 *         @OA\Property(property="id", type="integer", example=1),
 *         @OA\Property(property="name", type="string", example="John Doe")
 *     )
 * )
 *
 * @OA\Schema(
 *     schema="EnrollmentDetails",
 *     allOf={
 *         @OA\Schema(ref="#/components/schemas/Enrollment"),
 *         @OA\Schema(
 *             @OA\Property(
 *                 property="stats",
 *                 type="object",
 *                 @OA\Property(property="completed_lessons", type="integer", example=10),
 *                 @OA\Property(property="total_lessons", type="integer", example=20),
 *                 @OA\Property(property="study_duration_days", type="integer", example=30),
 *                 @OA\Property(property="last_accessed", type="string", example="2 days ago"),
 *                 @OA\Property(property="days_until_expiry", type="integer", example=60),
 *                 @OA\Property(property="completion_rate", type="number", format="float", example=0.33)
 *             )
 *         )
 *     }
 * )
 *
 * @OA\Schema(
 *     schema="CreateEnrollmentRequest",
 *     type="object",
 *     required={"paid_amount", "payment_method", "payment_status"},
 *     @OA\Property(property="paid_amount", type="number", format="float", example=99.99),
 *     @OA\Property(
 *         property="payment_method",
 *         type="string",
 *         enum={"credit_card", "paypal", "bank_transfer"},
 *         example="credit_card"
 *     ),
 *     @OA\Property(
 *         property="payment_status",
 *         type="string",
 *         enum={"pending", "completed", "failed"},
 *         example="completed"
 *     ),
 *     @OA\Property(property="expires_at", type="string", format="date-time", nullable=true)
 * )
 *
 * @OA\Schema(
 *     schema="LessonCompletion",
 *     type="object",
 *     required={"lesson_id"},
 *     @OA\Property(property="lesson_id", type="integer", example=1)
 * )
 *
 * @OA\Schema(
 *     schema="EnrollmentExtension",
 *     type="object",
 *     required={"days"},
 *     @OA\Property(property="days", type="integer", example=30, minimum=1)
 * )
 */
class EnrollmentSchema
{
} 