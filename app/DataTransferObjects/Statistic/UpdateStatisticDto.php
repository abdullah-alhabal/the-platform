<?php

declare(strict_types=1);

namespace App\DataTransferObjects\Statistic;

use App\Contracts\Requests\Statistic\UpdateStatisticRequestInterface;
use Illuminate\Http\UploadedFile;

final class UpdateStatisticDto
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

    public static function fromRequest(UpdateStatisticRequestInterface $request): self
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
