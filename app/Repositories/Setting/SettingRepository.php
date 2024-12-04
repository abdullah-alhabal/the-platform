<?php

declare(strict_types=1);

namespace App\Repositories\Setting;

use App\Contracts\Repositories\Setting\SettingRepositoryInterface;
use App\Models\Setting;

final class SettingRepository implements SettingRepositoryInterface
{
    public function getAll()
    {
        return Setting::all();
    }

    public function findByKey(string $key)
    {
        return Setting::where('key', $key)->first();
    }

    public function createOrUpdate(array $data): void
    {
        foreach ($data as $key => $value) {
            Setting::updateOrCreate(['key' => $key], ['value' => $value]);
        }
    }

    public function deleteByKey(string $key): void
    {
        $setting = $this->findByKey($key);
        if ($setting) {
            $setting->delete();
        }
    }
}
