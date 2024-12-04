<?php

declare(strict_types=1);

namespace App\DataTransferObjects\OurService\OurService\User;

use App\Contracts\Requests\User\StoreUserRequestInterface;
use App\Http\Requests\Api\V1\Admin\Users\StoreUserRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

/**
 * Class CreateUserDto.
 */
final class CreateUserDto
{
    public function __construct(
        public string $name,
        public string $email,
        public string $password,
        public string $role,
        public ?bool $isBlocked = null,
        public ?bool $isValidated = null,
        public ?bool $isAccredited = null,
        public ?string $idCardImage = null,
        public ?string $employmentProofImage = null,
        public ?string $resumeFile = null
    ) {}

    /**
     * Create a new instance from an array of data.
     *
     * @param array<string, mixed> $data
     *
     * @throws ValidationException
     */
    public static function fromArray(array $data): self
    {
        $validator = Validator::make(
            data: $data,
            rules: (new StoreUserRequest())->rules(),
            messages: (new StoreUserRequest())->messages(),
            attributes: (new StoreUserRequest())->attributes(),
        );

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        return new self(
            name: $data['name'],
            email: $data['email'],
            password: $data['password'],
            role: $data['role'],
            isBlocked: $data['is_blocked'] ?? null,
            isValidated: $data['is_validated'] ?? null,
            isAccredited: $data['is_accredited'] ?? null,
            idCardImage: $data['id_card_image'] ?? null,
            employmentProofImage: $data['employment_proof_image'] ?? null,
            resumeFile: $data['resume_file'] ?? null,
        );
    }

    /**
     * Create a new instance from a StoreUserRequest.
     */
    public static function fromRequest(StoreUserRequestInterface $request): static
    {
        return self::fromArray($request->validated());
    }

    /**
     * Convert the DTO to an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'email' => $this->email,
            'password' => $this->password,
            'role' => $this->role,
            'is_blocked' => $this->isBlocked,
            'is_validated' => $this->isValidated,
            'is_accredited' => $this->isAccredited,
            'id_card_image' => $this->idCardImage,
            'employment_proof_image' => $this->employmentProofImage,
            'resume_file' => $this->resumeFile,
        ];
    }
}
