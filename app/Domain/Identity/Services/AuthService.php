<?php

namespace App\Domain\Identity\Services;

use App\Domain\Identity\DTOs\Auth\LoginDto;
use App\Domain\Identity\DTOs\Auth\RegisterDto;
use App\Domain\Identity\Events\Auth\UserLoggedIn;
use App\Domain\Identity\Events\Auth\UserRegistered;
use App\Domain\Identity\Models\OtpCode;
use App\Domain\Identity\Models\User;
use App\Domain\Identity\Notifications\EmailVerificationNotification;
use App\Domain\Identity\Notifications\PhoneVerificationNotification;
use App\Domain\Identity\Repositories\UserRepository;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthService
{
    public function __construct(
        private readonly UserRepository $userRepository
    ) {}

    public function login(LoginDto $dto): array
    {
        $user = $this->userRepository->findByEmail($dto->email);

        if (!$user || !Hash::check($dto->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        if (!$user->is_active) {
            throw ValidationException::withMessages([
                'email' => ['Your account has been deactivated.'],
            ]);
        }

        if (!$user->hasVerifiedEmail()) {
            throw ValidationException::withMessages([
                'email' => ['Please verify your email address.'],
            ]);
        }

        $token = $user->createToken($dto->device_name ?? 'default')->plainTextToken;

        $user->update(['last_login_at' => now()]);
        UserLoggedIn::dispatch($user);

        return [
            'user' => $user->load($this->getRelationshipByUserType($user)),
            'token' => $token,
        ];
    }

    public function register(RegisterDto $dto): User
    {
        $user = $this->userRepository->create([
            'name' => $dto->name,
            'email' => $dto->email,
            'password' => Hash::make($dto->password),
            'phone' => $dto->phone,
            'type' => $dto->type,
        ]);

        // Create profile based on user type
        $this->createUserProfile($user, $dto);

        // Send verification notifications
        $this->sendEmailVerification($user);
        if ($dto->phone) {
            $this->sendPhoneVerification($user);
        }

        UserRegistered::dispatch($user);

        return $user;
    }

    public function verifyEmail(string $email, string $code): bool
    {
        $user = $this->userRepository->findByEmail($email);

        if (!$user) {
            return false;
        }

        $otpCode = $user->otpCodes()
            ->where('type', 'email')
            ->where('code', $code)
            ->whereNull('verified_at')
            ->where('expires_at', '>', now())
            ->first();

        if (!$otpCode) {
            return false;
        }

        $otpCode->verify();
        $user->markEmailAsVerified();

        return true;
    }

    public function verifyPhone(string $phone, string $code): bool
    {
        $user = $this->userRepository->findByPhone($phone);

        if (!$user) {
            return false;
        }

        $otpCode = $user->otpCodes()
            ->where('type', 'phone')
            ->where('code', $code)
            ->whereNull('verified_at')
            ->where('expires_at', '>', now())
            ->first();

        if (!$otpCode) {
            return false;
        }

        $otpCode->verify();
        $user->update(['phone_verified_at' => now()]);

        return true;
    }

    public function sendEmailVerification(User $user): void
    {
        $code = OtpCode::generateCode();

        $user->otpCodes()->create([
            'code' => $code,
            'type' => 'email',
            'expires_at' => now()->addMinutes(30),
        ]);

        $user->notify(new EmailVerificationNotification($code));
    }

    public function sendPhoneVerification(User $user): void
    {
        $code = OtpCode::generateCode();

        $user->otpCodes()->create([
            'code' => $code,
            'type' => 'phone',
            'expires_at' => now()->addMinutes(5),
        ]);

        $user->notify(new PhoneVerificationNotification($code));
    }

    public function logout(User $user, ?string $deviceId = null): void
    {
        if ($deviceId) {
            $user->tokens()->where('name', $deviceId)->delete();
        } else {
            $user->tokens()->delete();
        }
    }

    private function getRelationshipByUserType(User $user): string
    {
        return match ($user->type->value) {
            'admin' => 'admin',
            'teacher' => 'teacher',
            'student' => 'student',
            'marketer' => 'marketer',
        };
    }

    private function createUserProfile(User $user, RegisterDto $dto): void
    {
        match ($user->type->value) {
            'admin' => $user->admin()->create([
                'department' => $dto->department ?? 'General',
                'position' => $dto->position ?? 'Staff',
            ]),
            'teacher' => $user->teacher()->create([
                'bio' => $dto->bio ?? '',
                'expertise' => $dto->expertise ?? [],
            ]),
            'student' => $user->student()->create([
                'education_level' => $dto->education_level ?? null,
                'interests' => $dto->interests ?? [],
            ]),
            'marketer' => $user->marketer()->create([
                'company_name' => $dto->company_name ?? null,
                'website' => $dto->website ?? null,
                'commission_rate' => $dto->commission_rate ?? 10,
            ]),
        };
    }
}
