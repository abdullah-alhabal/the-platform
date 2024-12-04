<?php

declare(strict_types=1);

namespace App\Services\OurMessage;

use App\Contracts\Repositories\OurMessage\OurMessageRepositoryInterface;
use App\DataTransferObjects\OurMessage\CreateOurMessageDto;
use App\DataTransferObjects\OurMessage\UpdateOurMessageDto;
use App\Models\OurMessage;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

final class OurMessageService
{
    public function __construct(
        private readonly OurMessageRepositoryInterface $ourMessageRepository
    ) {}

    /**
     * Get all our messages.
     *
     * @return Collection
     */
    public function getAllMessages(): Collection
    {
        return $this->ourMessageRepository->all();
    }

    /**
     * Find an OurMessage by id.
     *
     * @param  int             $id
     * @return OurMessage|null
     */
    public function find(int $id): ?OurMessage
    {
        return $this->ourMessageRepository->find($id);
    }

    /**
     * Create a new OurMessage.
     *
     * @param  CreateOurMessageDto $dto
     * @return OurMessage
     */
    public function create(CreateOurMessageDto $dto): OurMessage
    {
        if ($dto->image instanceof UploadedFile) {
            $dto->image = $dto->image->store('images/our_messages', 'public');
        }

        return $this->ourMessageRepository->create($dto);
    }

    /**
     * Update an existing OurMessage.
     *
     * @param  int                 $id
     * @param  UpdateOurMessageDto $dto
     * @return bool
     */
    public function update(int $id, UpdateOurMessageDto $dto): bool
    {
        $ourMessage = $this->ourMessageRepository->findOrFail($id);

        if ($dto->image && $ourMessage->image) {
            Storage::disk('public')->delete($ourMessage->image);
        }

        if ($dto->image instanceof UploadedFile) {
            $dto->image = $dto->image->store('images/our_messages', 'public');
        }

        return $this->ourMessageRepository->update($id, $dto);
    }

    /**
     * Delete an OurMessage.
     *
     * @param  int  $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        $ourMessage = $this->ourMessageRepository->findOrFail($id);

        if ($ourMessage->image) {
            Storage::disk('public')->delete($ourMessage->image);
        }

        return $this->ourMessageRepository->delete($id);
    }
}
