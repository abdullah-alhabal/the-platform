<?php

declare(strict_types=1);

namespace App\DataTransferObjects\OurService;

use App\Contracts\Requests\OurService\CreateOurServiceRequestInterface;
use Illuminate\Http\UploadedFile;

final class CreateOurServiceDto
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

    public static function fromRequest(CreateOurServiceRequestInterface $request): self
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
