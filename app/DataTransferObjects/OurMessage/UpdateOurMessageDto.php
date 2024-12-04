<?php

declare(strict_types=1);

namespace App\DataTransferObjects\OurMessage;

use App\Contracts\Requests\OurMessage\UpdateOurMessageRequestInterface;
use Illuminate\Http\UploadedFile;

final class UpdateOurMessageDto
{
    public function __construct(
        public UploadedFile|string|null $image,
        public ?string $title,
        public ?string $description
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            $data['image'] ?? null,
            $data['title'] ?? null,
            $data['description'] ?? null
        );
    }

    public static function fromRequest(UpdateOurMessageRequestInterface $request): self
    {
        $data = $request->validated();

        return self::fromArray($data);
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return array_filter([
            'image' => $this->image,
            'title' => $this->title,
            'description' => $this->description,
        ]);
    }
}
