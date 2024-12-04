<?php

namespace App\OpenApi\Schemas;

/**
 * @OA\Schema(
 *     schema="Teacher",
 *     type="object",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="user_id", type="integer", example=1),
 *     @OA\Property(property="name", type="string", example="John Doe"),
 *     @OA\Property(property="email", type="string", format="email", example="john@example.com"),
 *     @OA\Property(property="phone", type="string", example="+1234567890"),
 *     @OA\Property(property="bio", type="string", example="Experienced teacher with 10 years of practice"),
 *     @OA\Property(property="avatar", type="string", format="uri", example="https://example.com/avatar.jpg"),
 *     @OA\Property(property="expertise", type="array", @OA\Items(type="string"), example={"Mathematics", "Physics"}),
 *     @OA\Property(property="qualification", type="array", @OA\Items(type="string"), example={"PhD", "Masters"}),
 *     @OA\Property(property="is_active", type="boolean", example=true),
 *     @OA\Property(property="created_at", type="string", format="date-time"),
 *     @OA\Property(property="updated_at", type="string", format="date-time")
 * )
 *
 * @OA\Schema(
 *     schema="TeacherDetails",
 *     allOf={
 *         @OA\Schema(ref="#/components/schemas/Teacher"),
 *         @OA\Schema(
 *             @OA\Property(
 *                 property="stats",
 *                 type="object",
 *                 @OA\Property(property="total_courses", type="integer", example=10),
 *                 @OA\Property(property="total_students", type="integer", example=500),
 *                 @OA\Property(property="average_rating", type="number", format="float", example=4.5),
 *                 @OA\Property(property="total_reviews", type="integer", example=150),
 *                 @OA\Property(property="revenue", type="number", format="float", example=5000.00)
 *             )
 *         )
 *     }
 * )
 *
 * @OA\Schema(
 *     schema="CreateTeacherRequest",
 *     type="object",
 *     required={"user_id", "name", "email", "phone", "bio", "expertise", "qualification"},
 *     @OA\Property(property="user_id", type="integer", example=1),
 *     @OA\Property(property="name", type="string", example="John Doe"),
 *     @OA\Property(property="email", type="string", format="email", example="john@example.com"),
 *     @OA\Property(property="phone", type="string", example="+1234567890"),
 *     @OA\Property(property="bio", type="string", example="Experienced teacher with 10 years of practice"),
 *     @OA\Property(property="avatar", type="string", format="binary"),
 *     @OA\Property(
 *         property="expertise",
 *         type="array",
 *         @OA\Items(type="string"),
 *         example={"Mathematics", "Physics"}
 *     ),
 *     @OA\Property(
 *         property="qualification",
 *         type="array",
 *         @OA\Items(type="string"),
 *         example={"PhD", "Masters"}
 *     ),
 *     @OA\Property(property="is_active", type="boolean", example=true)
 * )
 *
 * @OA\Schema(
 *     schema="PaginationMeta",
 *     type="object",
 *     @OA\Property(property="current_page", type="integer", example=1),
 *     @OA\Property(property="last_page", type="integer", example=10),
 *     @OA\Property(property="per_page", type="integer", example=15),
 *     @OA\Property(property="total", type="integer", example=150)
 * )
 */
class TeacherSchema
{
} 