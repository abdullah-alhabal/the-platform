<?php

namespace App\Domain\Course\DTOs\Teacher;

class CreateTeacherDto
{
    public function __construct(
        public readonly int $user_id,
        public readonly string $name,
        public readonly string $email,
        public readonly string $phone,
        public readonly string $bio,
        public readonly ?string $avatar,
        public readonly array $expertise,
        public readonly array $qualification,
        public readonly bool $is_active = true,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            user_id: $data['user_id'],
            name: $data['name'],
            email: $data['email'],
            phone: $data['phone'],
            bio: $data['bio'],
            avatar: $data['avatar'] ?? null,
            expertise: $data['expertise'],
            qualification: $data['qualification'],
            is_active: $data['is_active'] ?? true,
        );
    }

    public function toArray(): array
    {
        return [
            'user_id' => $this->user_id,
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'bio' => $this->bio,
            'avatar' => $this->avatar,
            'expertise' => $this->expertise,
            'qualification' => $this->qualification,
            'is_active' => $this->is_active,
        ];
    }
} 