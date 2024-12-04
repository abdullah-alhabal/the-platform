<?php

namespace App\OpenApi;

/**
 * @OA\Info(
 *     version="1.0.0",
 *     title="Course Platform API",
 *     description="API documentation for the Course Platform",
 *     @OA\Contact(
 *         email="support@example.com",
 *         name="API Support"
 *     ),
 *     @OA\License(
 *         name="MIT",
 *         url="https://opensource.org/licenses/MIT"
 *     )
 * )
 *
 * @OA\Server(
 *     url=L5_SWAGGER_CONST_HOST,
 *     description="API Server"
 * )
 *
 * @OA\SecurityScheme(
 *     securityScheme="sanctum",
 *     type="http",
 *     scheme="bearer",
 *     bearerFormat="JWT"
 * )
 *
 * @OA\Tag(
 *     name="Authentication",
 *     description="API Endpoints for user authentication"
 * )
 *
 * @OA\Tag(
 *     name="Teachers",
 *     description="API Endpoints for teacher management"
 * )
 *
 * @OA\Tag(
 *     name="Enrollments",
 *     description="API Endpoints for course enrollments"
 * )
 *
 * @OA\Tag(
 *     name="Courses",
 *     description="API Endpoints for course management"
 * )
 *
 * @OA\Response(
 *     response="Unauthorized",
 *     description="Unauthorized",
 *     @OA\JsonContent(
 *         @OA\Property(property="success", type="boolean", example=false),
 *         @OA\Property(property="message", type="string", example="Unauthenticated.")
 *     )
 * )
 *
 * @OA\Response(
 *     response="Forbidden",
 *     description="Forbidden",
 *     @OA\JsonContent(
 *         @OA\Property(property="success", type="boolean", example=false),
 *         @OA\Property(property="message", type="string", example="Unauthorized. Missing permission.")
 *     )
 * )
 *
 * @OA\Response(
 *     response="ValidationError",
 *     description="Validation Error",
 *     @OA\JsonContent(
 *         @OA\Property(property="success", type="boolean", example=false),
 *         @OA\Property(property="message", type="string", example="The given data was invalid."),
 *         @OA\Property(
 *             property="errors",
 *             type="object",
 *             @OA\AdditionalProperties(
 *                 type="array",
 *                 @OA\Items(type="string")
 *             )
 *         )
 *     )
 * )
 */
class OpenApiConfig
{
} 