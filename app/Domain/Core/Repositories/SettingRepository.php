<?php

namespace App\Domain\Core\Repositories;

use App\Domain\Core\Interfaces\SettingRepositoryInterface;
use App\Domain\Core\Models\Setting;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;

class SettingRepository implements SettingRepositoryInterface
{
    private const CACHE_PREFIX = 'settings:';
    private const CACHE_TTL = 3600; // 1 hour

    public function __construct(
        private readonly Setting $model
    ) {}

    public function get(string $key, $default = null)
    {
        return Cache::remember(
            self::CACHE_PREFIX . $key,
            self::CACHE_TTL,
            fn() => $this->model->where('key', $key)->first()?->value ?? $default
        );
    }

    public function set(string $key, $value, string $group = 'general'): Setting
    {
        $setting = $this->model->updateOrCreate(
            ['key' => $key],
            [
                'value' => $value,
                'group' => $group,
                'type' => gettype($value),
            ]
        );

        Cache::forget(self::CACHE_PREFIX . $key);
        Cache::forget(self::CACHE_PREFIX . 'group:' . $group);
        Cache::forget(self::CACHE_PREFIX . 'public');

        return $setting;
    }

    public function getByGroup(string $group): Collection
    {
        return Cache::remember(
            self::CACHE_PREFIX . 'group:' . $group,
            self::CACHE_TTL,
            fn() => $this->model->where('group', $group)->get()
        );
    }

    public function getPublic(): Collection
    {
        return Cache::remember(
            self::CACHE_PREFIX . 'public',
            self::CACHE_TTL,
            fn() => $this->model->where('is_public', true)
                ->where('autoload', true)
                ->get()
        );
    }

    public function delete(string $key): bool
    {
        $deleted = $this->model->where('key', $key)->delete();

        if ($deleted) {
            Cache::forget(self::CACHE_PREFIX . $key);
        }

        return (bool) $deleted;
    }

    public function deleteByGroup(string $group): bool
    {
        $settings = $this->model->where('group', $group)->get();
        $deleted = $this->model->where('group', $group)->delete();

        if ($deleted) {
            foreach ($settings as $setting) {
                Cache::forget(self::CACHE_PREFIX . $setting->key);
            }
            Cache::forget(self::CACHE_PREFIX . 'group:' . $group);
        }

        return (bool) $deleted;
    }

    public function updateOrCreate(array $data): Setting
    {
        return $this->set($data['key'], $data['value'], $data['group'] ?? 'general');
    }
}
