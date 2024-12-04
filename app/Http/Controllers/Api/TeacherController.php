<?php

namespace App\Http\Controllers\Api;

use App\Domain\Course\Models\Teacher;
use App\Domain\Course\Services\TeacherService;
use App\Http\Requests\Teacher\CreateTeacherRequest;
use App\Http\Requests\Teacher\UpdateTeacherRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;

/**
 * @OA\Tag(
 *     name="Teachers",
 *     description="API Endpoints for teacher management"
 * )
 */
class TeacherController extends ApiController
{
    protected TeacherService $teacherService;

    public function __construct(TeacherService $teacherService)
    {
        $this->teacherService = $teacherService;
    }

    /**
     * @OA\Get(
     *     path="/api/teachers",
     *     summary="List all teachers",
     *     tags={"Teachers"},
     *     security={{ "sanctum": {} }},
     *     @OA\Parameter(
     *         name="search",
     *         in="query",
     *         description="Search term for filtering teachers",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="expertise",
     *         in="query",
     *         description="Filter by expertise",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="is_active",
     *         in="query",
     *         description="Filter by active status",
     *         required=false,
     *         @OA\Schema(type="boolean")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="List of teachers",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Teachers retrieved successfully"),
     *             @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/Teacher")),
     *             @OA\Property(property="meta", ref="#/components/schemas/PaginationMeta")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthenticated"
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Unauthorized"
     *     )
     * )
     */
    public function index(Request $request): JsonResponse
    {
        $filters = $request->only(['search', 'expertise', 'is_active', 'min_rating']);
        $teachers = $this->teacherService->getTeacherRepository()->getAll($filters);

        return $this->paginatedResponse($teachers, 'Teachers retrieved successfully');
    }

    /**
     * @OA\Post(
     *     path="/api/teachers",
     *     summary="Create a new teacher",
     *     tags={"Teachers"},
     *     security={{ "sanctum": {} }},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/CreateTeacherRequest")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Teacher created successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Teacher created successfully"),
     *             @OA\Property(property="data", ref="#/components/schemas/Teacher")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error"
     *     )
     * )
     */
    public function store(CreateTeacherRequest $request): JsonResponse
    {
        $teacher = $this->teacherService->createTeacher($request->validated());
        return $this->createdResponse($teacher->toArray(), 'Teacher created successfully');
    }

    /**
     * @OA\Get(
     *     path="/api/teachers/{teacher}",
     *     summary="Get teacher details",
     *     tags={"Teachers"},
     *     security={{ "sanctum": {} }},
     *     @OA\Parameter(
     *         name="teacher",
     *         in="path",
     *         description="Teacher ID",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Teacher details",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", ref="#/components/schemas/TeacherDetails")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Teacher not found"
     *     )
     * )
     */
    public function show(Teacher $teacher): JsonResponse
    {
        $teacherDTO = $this->teacherService->getTeacherDetails($teacher);
        return $this->successResponse($teacherDTO->toArray());
    }

    public function update(UpdateTeacherRequest $request, Teacher $teacher): JsonResponse
    {
        $updated = $this->teacherService->updateTeacher($teacher, $request->validated());
        return $updated
            ? $this->successResponse(null, 'Teacher updated successfully')
            : $this->errorResponse('Failed to update teacher');
    }

    public function destroy(Teacher $teacher): JsonResponse
    {
        $deleted = $this->teacherService->deleteTeacher($teacher);
        return $deleted
            ? $this->noContentResponse()
            : $this->errorResponse('Failed to delete teacher');
    }

    public function toggleStatus(Teacher $teacher): JsonResponse
    {
        $updated = $this->teacherService->toggleTeacherStatus($teacher);
        return $updated
            ? $this->successResponse(['is_active' => $teacher->fresh()->is_active])
            : $this->errorResponse('Failed to toggle teacher status');
    }

    public function topRated(): JsonResponse
    {
        $teachers = $this->teacherService->getTeacherRepository()->getTopRated();
        return $this->successResponse($teachers->map(fn($teacher) => $teacher->toArray()));
    }

    public function searchByExpertise(Request $request): JsonResponse
    {
        $request->validate(['expertise' => 'required|string']);
        $teachers = $this->teacherService->findTeachersByExpertise($request->expertise);
        return $this->successResponse($teachers);
    }

    public function stats(Teacher $teacher): JsonResponse
    {
        $stats = $this->teacherService->getTeacherRepository()->getTeacherStats($teacher);
        return $this->successResponse($stats);
    }

    public function level(Teacher $teacher): JsonResponse
    {
        $level = $this->teacherService->calculateTeacherLevel($teacher);
        return $this->successResponse(['level' => $level]);
    }
} 