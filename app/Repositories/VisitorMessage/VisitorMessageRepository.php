<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Contracts\Repositories\VisitorMessage\VisitorMessageRepositoryInterface;
use App\Models\VisitorMessage;
use Illuminate\Auth\AuthManager;

final class VisitorMessageRepository implements VisitorMessageRepositoryInterface
{
    public function __construct(
        private readonly AuthManager $authManager
    ) {}

    public function listMessages(): array
    {
        return VisitorMessage::with('replies')->latest()->get()->toArray();
    }

    public function viewMessage(int $id): VisitorMessage
    {
        $message = VisitorMessage::findOrFail($id);
        $message->markAsRead();

        return $message;
    }

    public function deleteMessage(int $id): bool
    {
        return VisitorMessage::destroy($id) > 0;
    }

    public function replyToMessage(int $id, string $content): bool
    {
        $message = VisitorMessage::findOrFail($id);

        return (bool) $message->replies()->create([
            'admin_id' => $this->authManager->guard()->id(),
            'content' => $content,
        ]);
    }
}
