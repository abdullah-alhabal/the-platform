<?php

declare(strict_types=1);

namespace App\Contracts\Repositories\Setting;

interface SettingRepositoryInterface
{
    public function getAll();

    public function findByKey(string $key);

    public function createOrUpdate(array $data);

    public function deleteByKey(string $key);
}
