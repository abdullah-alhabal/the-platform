<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Domain\Identity\DTOs\Auth\LoginDto;
use App\Domain\Identity\DTOs\Auth\RegisterDto;
use App\Domain\Identity\Services\AuthService;
use App\Http\Controllers\Api\V1\BaseApiV1Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

abstract class BaseAuthController extends BaseApiV1Controller
{
    public function __construct(
        protected readonly AuthService $authService
    ) {}

    abstract protected function getUserType(): string;

    public function login(Request $request): JsonResponse
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
            'device_name' => 'nullable|string',
        ]);

        $dto = LoginDto::fromArray($request->all());
        $result = $this->authService->login($dto);

        return $this->successResponse($result, 'Logged in successfully');
    }

    public function register(Request $request): JsonResponse
    {
        $this->validateRegistration($request);

        $data = $request->all();
        $data['type'] = $this->getUserType();
        
        $dto = RegisterDto::fromArray($data);
        $user = $this->authService->register($dto);

        return $this->createdResponse(
            $user->load($this->getProfileRelationship()),
            'Registration successful. Please verify your email.'
        );
    }

    public function logout(Request $request): JsonResponse
    {
        $this->authService->logout(
            $request->user(),
            $request->input('device_id')
        );

        return $this->successResponse(null, 'Logged out successfully');
    }

    public function verifyEmail(Request $request): JsonResponse
    {
        $request->validate([
            'email' => 'required|email',
            'code' => 'required|string|size:6',
        ]);

        $verified = $this->authService->verifyEmail(
            $request->input('email'),
            $request->input('code')
        );

        if (!$verified) {
            return $this->errorResponse('Invalid or expired verification code');
        }

        return $this->successResponse(null, 'Email verified successfully');
    }

    public function verifyPhone(Request $request): JsonResponse
    {
        $request->validate([
            'phone' => 'required|string',
            'code' => 'required|string|size:6',
        ]);

        $verified = $this->authService->verifyPhone(
            $request->input('phone'),
            $request->input('code')
        );

        if (!$verified) {
            return $this->errorResponse('Invalid or expired verification code');
        }

        return $this->successResponse(null, 'Phone number verified successfully');
    }

    public function resendVerification(Request $request): JsonResponse
    {
        $request->validate([
            'type' => 'required|in:email,phone',
        ]);

        if ($request->input('type') === 'email') {
            $this->authService->sendEmailVerification($request->user());
            $message = 'Email verification code sent successfully';
        } else {
            $this->authService->sendPhoneVerification($request->user());
            $message = 'Phone verification code sent successfully';
        }

        return $this->successResponse(null, $message);
    }

    protected function validateRegistration(Request $request): void
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'phone' => 'nullable|string|unique:users,phone',
        ]);
    }

    protected function getProfileRelationship(): string
    {
        return strtolower($this->getUserType());
    }
} 