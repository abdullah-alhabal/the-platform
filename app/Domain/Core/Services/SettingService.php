<?php

namespace App\Domain\Core\Services;

use App\Domain\Core\Interfaces\SettingRepositoryInterface;
use App\Domain\Core\Models\Setting;
use Illuminate\Database\Eloquent\Collection;

class SettingService
{
    public function __construct(
        private readonly SettingRepositoryInterface $settingRepository
    ) {}

    public function get(string $key, $default = null)
    {
        return $this->settingRepository->get($key, $default);
    }

    public function set(string $key, $value, string $group = 'general'): Setting
    {
        return $this->settingRepository->set($key, $value, $group);
    }

    public function getByGroup(string $group): Collection
    {
        return $this->settingRepository->getByGroup($group);
    }

    public function getPublic(): Collection
    {
        return $this->settingRepository->getPublic();
    }

    public function delete(string $key): bool
    {
        return $this->settingRepository->delete($key);
    }

    public function deleteByGroup(string $group): bool
    {
        return $this->settingRepository->deleteByGroup($group);
    }

    public function updateOrCreate(array $data): Setting
    {
        return $this->settingRepository->updateOrCreate($data);
    }

    public function getAppSettings(): array
    {
        $settings = $this->getByGroup('app');
        return $settings->pluck('value', 'key')->toArray();
    }

    public function getMailSettings(): array
    {
        $settings = $this->getByGroup('mail');
        return $settings->pluck('value', 'key')->toArray();
    }

    public function getSocialSettings(): array
    {
        $settings = $this->getByGroup('social');
        return $settings->pluck('value', 'key')->toArray();
    }

    public function getPaymentSettings(): array
    {
        $settings = $this->getByGroup('payment');
        return $settings->pluck('value', 'key')->toArray();
    }
} 