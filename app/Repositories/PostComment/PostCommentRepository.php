<?php

declare(strict_types=1);

namespace App\Repositories\PostComment;

use App\Contracts\Repositories\PostComment\PostCommentRepositoryInterface;
use App\Models\PostComment;
use Illuminate\Support\Collection;

final class PostCommentRepository implements PostCommentRepositoryInterface
{
    public function all(): Collection
    {
        return PostComment::select(['id', 'text', 'is_published', 'post_id', 'user_id', 'created_at', 'updated_at'])
            ->with(['post:id,title', 'user:id,name'])
            ->get();
    }

    public function findById(int $id): ?PostComment
    {
        return PostComment::select(['id', 'text', 'is_published', 'post_id', 'user_id', 'created_at', 'updated_at'])
            ->with(['post:id,title', 'user:id,name'])
            ->find($id);
    }

    public function create(array $data): PostComment
    {
        return PostComment::create($data);
    }

    public function update(int $id, array $data): bool
    {
        $postComment = PostComment::findOrFail($id);

        return $postComment->update($data);
    }

    public function delete(int $id): bool
    {
        $postComment = PostComment::findOrFail($id);

        return $postComment->delete();
    }
}
