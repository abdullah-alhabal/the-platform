<?php

namespace App\Domain\Identity\DTOs\Auth;

class LoginDto
{
    public function __construct(
        public readonly string $email,
        public readonly string $password,
        public readonly ?string $device_name = null
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            email: $data['email'],
            password: $data['password'],
            device_name: $data['device_name'] ?? null
        );
    }
} 