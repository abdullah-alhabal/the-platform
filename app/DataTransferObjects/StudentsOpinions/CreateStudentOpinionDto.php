<?php

declare(strict_types=1);

namespace App\DataTransferObjects\StudentOpinion;

use App\Contracts\Requests\StudentOpinion\CreateStudentOpinionRequestInterface;
use Illuminate\Http\UploadedFile;

final class CreateStudentOpinionDto
{
    public function __construct(
        public UploadedFile|string $image,
        public string $title,
        public string $text
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            $data['image'],
            $data['title'],
            $data['text']
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
            'title' => $this->title,
            'text' => $this->text,
        ];
    }
}
