<?php

declare(strict_types=1);

namespace App\Services\VisitorMessage;

use App\Contracts\Repositories\VisitorMessage\VisitorMessageRepositoryInterface;

final class VisitorMessageService
{
    public function __construct(
        private readonly VisitorMessageRepositoryInterface $repository
    ) {}

    public function getAllMessages(): array
    {
        return $this->repository->listMessages();
    }

    public function viewMessage(int $id): array
    {
        return $this->repository->viewMessage($id)->toArray();
    }

    public function deleteMessage(int $id): bool
    {
        return $this->repository->deleteMessage($id);
    }

    public function sendReply(int $id, string $content): bool
    {
        return $this->repository->replyToMessage($id, $content);
    }
}
