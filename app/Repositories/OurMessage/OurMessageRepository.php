<?php

declare(strict_types=1);

namespace App\Repositories\OurMessage;

use App\Contracts\Repositories\OurMessage\OurMessageRepositoryInterface;
use App\DataTransferObjects\OurMessage\CreateOurMessageDto;
use App\DataTransferObjects\OurMessage\UpdateOurMessageDto;
use App\Models\OurMessage;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

final class OurMessageRepository implements OurMessageRepositoryInterface
{
    public function __construct(
        private readonly Application $application
    ) {}

    /**
     * @return Collection
     */
    public function all(): Collection
    {
        return OurMessage::select(['id', 'image', 'created_at', 'updated_at'])
            ->with('translations:id,our_message_id,locale,title,description')
            ->latest()
            ->get();
    }

    /**
     * @param  int             $id
     * @return OurMessage|null
     */
    public function find(int $id): ?OurMessage
    {
        return OurMessage::select(['id', 'image', 'created_at', 'updated_at'])
            ->with('translations:id,our_message_id,locale,title,description')
            ->find($id);
    }

    /**
     * @param  int        $id
     * @return OurMessage
     */
    public function findOrFail(int $id): OurMessage
    {
        return OurMessage::select(['id', 'image', 'created_at', 'updated_at'])
            ->with('translations:id,our_message_id,locale,title,description')
            ->findOrFail($id);
    }

    /**
     * @param  CreateOurMessageDto $dto
     * @return OurMessage
     */
    public function create(CreateOurMessageDto $dto): OurMessage
    {
        return DB::transaction(function () use ($dto) {
            $ourMessage = OurMessage::create($dto->toArray());
            $this->saveTranslations($ourMessage, $dto->toArray());

            return $ourMessage;
        });
    }

    /**
     * @param  int                 $id
     * @param  UpdateOurMessageDto $dto
     * @return bool
     */
    public function update(int $id, UpdateOurMessageDto $dto): bool
    {
        return DB::transaction(function () use ($id, $dto) {
            $ourMessage = $this->findOrFail($id);
            $updated = $ourMessage->updateOrFail($dto->toArray());
            $this->saveTranslations($ourMessage, $dto->toArray());

            return $updated;
        });
    }

    /**
     * Delete (our message).
     *
     * @param  int  $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        return DB::transaction(function () use ($id) {
            $ourMessage = $this->findOrFail($id);

            return $ourMessage->deleteOrFail();
        });
    }

    private function saveTranslations(OurMessage $ourMessage, array $data): void
    {
        $locale = $this->application->getLocale();

        if ( ! empty($data["title_{$locale}"])) {
            $ourMessage->translations()->updateOrCreate(
                ['locale' => $locale],
                ['title' => $data["title_{$locale}"], 'description' => $data["description_{$locale}"] ?? '']
            );
        }
    }
}
