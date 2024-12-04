<?php

declare(strict_types=1);

namespace App\DataTransferObjects\OurService\OurService\Admin;

final class UpdateAdminDto
{
    public function __construct() {}

    public static function fromArray(): void {}

    public static function toArray(): array
    {
        return [];
    }

    public static function fromRequest(): self
    {
        return self::class();
    }
}
