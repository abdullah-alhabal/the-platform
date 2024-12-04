<?php

declare(strict_types=1);

namespace App\Services\Faq;

use App\Contracts\Repositories\Faq\FaqRepositoryInterface;
use App\Models\Faq;
use Illuminate\Database\Eloquent\Collection;

final class FaqService
{
    public function __construct(
        private readonly FaqRepositoryInterface $repository
    ) {}

    public function list(string $locale, ?string $search = null): Collection
    {
        return $this->repository->list($locale, $search);
    }

    public function create(array $data): Faq
    {
        return $this->repository->create($data);
    }

    public function update(int $id, array $data): Faq
    {
        return $this->repository->update($id, $data);
    }

    public function delete(int $id): bool
    {
        return $this->repository->delete($id);
    }
}
