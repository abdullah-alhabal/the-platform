<?php

declare(strict_types=1);

namespace App\Contracts\Repositories\SocialMedia;

interface SocialMediaRepositoryInterface
{
    public function listAll(): array;

    public function create(array $data): void;

    public function update(int $id, array $data): void;

    public function delete(int $id): void;
}
