<?php

declare(strict_types=1);

namespace App\Contracts\Repositories\VisitorMessage;

use App\Models\VisitorMessage;

interface VisitorMessageRepositoryInterface
{
    public function listMessages(): array;

    public function viewMessage(int $id): VisitorMessage;

    public function deleteMessage(int $id): bool;

    public function replyToMessage(int $id, string $content): bool;
}
