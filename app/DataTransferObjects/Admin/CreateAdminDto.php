<?php

declare(strict_types=1);

namespace App\DataTransferObjects\OurService\OurService\Admin;

final class CreateAdminDto
{
    public function __construct() {}

    public static function fromArray(array $data): void {}

    public static function toArray(): array
    {
        return [];
    }

    public static function fromRequest(): self
    {
        return self::class();
    }
}
