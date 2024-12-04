<?php

declare(strict_types=1);

namespace App\DataTransferObjects\OurService;

use App\Contracts\Requests\OurService\UpdateOurServiceRequestInterface;

final class UpdateOurServiceDto
{
    public function __construct(
        public ?string $image,
        public ?string $title,
        public ?string $text
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            $data['image'] ?? null,
            $data['title'] ?? null,
            $data['text'] ?? null
        );
    }

    public static function fromRequest(UpdateOurServiceRequestInterface $request): self
    {
        return self::fromArray($request->validated());
    }

    public function toArray(): array
    {
        return array_filter([
            'image' => $this->image,
            'title' => $this->title,
            'text' => $this->text,
        ]);
    }
}
