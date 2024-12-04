<?php

declare(strict_types=1);

namespace App\Services\Setting;

use App\Contracts\Repositories\Setting\SettingRepositoryInterface;

final class SettingService
{
    public function __construct(
        private readonly SettingRepositoryInterface $repository
    ) {}

    public function listSettings()
    {
        return $this->repository->getAll();
    }

    public function saveSettings(array $data): void
    {
        $this->repository->createOrUpdate($data);
    }

    public function deleteSetting(string $key): void
    {
        $this->repository->deleteByKey($key);
    }
}
