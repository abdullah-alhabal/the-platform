<?php

namespace App\Domain\Core\Interfaces;

use App\Domain\Core\Models\Setting;
use Illuminate\Database\Eloquent\Collection;

interface SettingRepositoryInterface
{
    public function get(string $key, $default = null);
    public function set(string $key, $value, string $group = 'general'): Setting;
    public function getByGroup(string $group): Collection;
    public function getPublic(): Collection;
    public function delete(string $key): bool;
    public function deleteByGroup(string $group): bool;
    public function updateOrCreate(array $data): Setting;
}
