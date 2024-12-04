<?php

declare(strict_types=1);

namespace App\Contracts\Repositories\OurPartner;

use App\Models\OurPartner;
use Illuminate\Database\Eloquent\Collection;

interface OurPartnerRepositoryInterface
{
    public function all(): Collection;

    public function find(int $id): ?OurPartner;

    public function create(array $data): OurPartner;

    public function update(int $id, array $data): bool;

    public function delete(int $id): bool;
}
