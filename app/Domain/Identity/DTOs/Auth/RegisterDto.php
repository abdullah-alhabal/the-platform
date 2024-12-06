<?php

namespace App\Domain\Identity\DTOs\Auth;

use App\Domain\Identity\Enums\UserType;

class RegisterDto
{
    public function __construct(
        public readonly string $name,
        public readonly string $email,
        public readonly string $password,
        public readonly UserType $type,
        public readonly ?string $phone = null,
        public readonly ?string $bio = null,
        public readonly ?array $expertise = null,
        public readonly ?string $education_level = null,
        public readonly ?array $interests = null,
        public readonly ?string $company_name = null,
        public readonly ?string $website = null,
        public readonly ?float $commission_rate = null,
        public readonly ?string $department = null,
        public readonly ?string $position = null
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            name: $data['name'],
            email: $data['email'],
            password: $data['password'],
            type: UserType::from($data['type']),
            phone: $data['phone'] ?? null,
            bio: $data['bio'] ?? null,
            expertise: $data['expertise'] ?? null,
            education_level: $data['education_level'] ?? null,
            interests: $data['interests'] ?? null,
            company_name: $data['company_name'] ?? null,
            website: $data['website'] ?? null,
            commission_rate: isset($data['commission_rate']) ? (float) $data['commission_rate'] : null,
            department: $data['department'] ?? null,
            position: $data['position'] ?? null
        );
    }
} 