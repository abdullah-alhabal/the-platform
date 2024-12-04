<?php

declare(strict_types=1);

namespace App\DataTransferObjects\OurMessage;

use App\Contracts\Requests\OurMessage\CreateOurMessageRequestInterface;
use Illuminate\Http\UploadedFile;

final class CreateOurMessageDto
{
    public function __construct(
        public UploadedFile|string $image,
        public string $title,
        public string $description
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            $data['image'],
            $data['title'],
            $data['description']
        );
    }

    public static function fromRequest(CreateOurMessageRequestInterface $request): self
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
            'description' => $this->description,
        ];
    }
}
