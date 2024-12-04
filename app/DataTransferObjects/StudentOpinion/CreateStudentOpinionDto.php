<?php

declare(strict_types=1);

namespace App\DataTransferObjects\StudentsOpinions;

use App\Contracts\Requests\StudentOpinion\CreateStudentOpinionRequestInterface;
use Illuminate\Http\UploadedFile;

final class CreateStudentOpinionDto
{
    public function __construct(
        public UploadedFile|string $image,
        public string $name,
        public string $text,
        public ?int $rate
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            $data['image'],
            $data['name'],
            $data['text'],
            $data['rate'] ?? null
        );
    }

    public static function fromRequest(CreateStudentOpinionRequestInterface $request): self
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
            'image' => $this->image,
            'name' => $this->name,
            'text' => $this->text,
            'rate' => $this->rate,
        ];
    }
}
