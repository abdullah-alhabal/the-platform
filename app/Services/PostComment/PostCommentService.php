<?php

declare(strict_types=1);

namespace App\Services\PostComment;

use App\Contracts\Repositories\PostComment\PostCommentRepositoryInterface;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

final class PostCommentService
{
    public function __construct(
        private readonly PostCommentRepositoryInterface $repository
    ) {}

    public function listAll(): Collection
    {
        return $this->repository->all();
    }

    public function find(int $id): ?\App\Models\PostComment
    {
        return $this->repository->findById($id);
    }

    public function create(array $data): \App\Models\PostComment
    {
        return DB::transaction(fn () => $this->repository->create($data));
    }

    public function update(int $id, array $data): bool
    {
        return DB::transaction(fn () => $this->repository->update($id, $data));
    }

    public function delete(int $id): bool
    {
        return DB::transaction(fn () => $this->repository->delete($id));
    }
}
