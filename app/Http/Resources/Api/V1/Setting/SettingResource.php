<?php

declare(strict_types=1);

namespace App\Http\Resources\Api\V1\Setting;

use Illuminate\Http\Resources\Json\JsonResource;

final class SettingResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'key' => $this->key,
            'value' => $this->value,
        ];
    }
}
