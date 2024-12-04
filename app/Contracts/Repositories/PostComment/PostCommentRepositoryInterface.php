<?php

declare(strict_types=1);

namespace App\Contracts\Repositories\PostComment;

use App\Models\PostComment;
use Illuminate\Support\Collection;

interface PostCommentRepositoryInterface
{
    public function all(): Collection;

    public function findById(int $id): ?PostComment;

    public function create(array $data): PostComment;

    public function update(int $id, array $data): bool;

    public function delete(int $id): bool;
}
