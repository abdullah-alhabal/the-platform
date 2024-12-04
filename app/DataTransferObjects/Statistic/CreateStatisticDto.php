<?php

declare(strict_types=1);

namespace App\DataTransferObjects\Statistic;

use App\Contracts\Requests\Statistic\CreateStatisticRequestInterface;
use Illuminate\Http\UploadedFile;

final class CreateStatisticDto
{
    public function __construct(
        public UploadedFile|string $image,
        public string $title,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            $data['image'],
            $data['title'],
        );
    }

    public static function fromRequest(CreateStatisticRequestInterface $request): self
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
        ];
    }
}
