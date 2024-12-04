<?php

declare(strict_types=1);


namespace App\DataTransferObjects\WorkStep;

use App\Contracts\Requests\WorkStep\CreateWorkStepRequestInterface;
use Illuminate\Http\UploadedFile;

class UpdateWorkStepDto
{
    public function __construct(
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
        );
    }

    public static function fromRequest(CreateWorkStepRequestInterface $request): self
    {
        $data = $request->validated();

        return self::fromArray($data);
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
        ];
    }
}
