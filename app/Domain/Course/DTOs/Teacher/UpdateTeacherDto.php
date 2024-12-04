<?php

namespace App\Domain\Course\DTOs\Teacher;

class UpdateTeacherDto
{
    public function __construct(
        public readonly ?string $name = null,
        public readonly ?string $email = null,
        public readonly ?string $phone = null,
        public readonly ?string $bio = null,
        public readonly ?string $avatar = null,
        public readonly ?array $expertise = null,
        public readonly ?array $qualification = null,
        public readonly ?bool $is_active = null,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            name: $data['name'] ?? null,
            email: $data['email'] ?? null,
            phone: $data['phone'] ?? null,
            bio: $data['bio'] ?? null,
            avatar: $data['avatar'] ?? null,
            expertise: $data['expertise'] ?? null,
            qualification: $data['qualification'] ?? null,
            is_active: $data['is_active'] ?? null,
        );
    }

    public function toArray(): array
    {
        return array_filter([
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'bio' => $this->bio,
            'avatar' => $this->avatar,
            'expertise' => $this->expertise,
            'qualification' => $this->qualification,
            'is_active' => $this->is_active,
        ], fn($value) => !is_null($value));
    }
} 