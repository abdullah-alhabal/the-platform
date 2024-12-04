<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WorkStepTranslation extends Model
{
    /** @var array<int, string> */
    protected $fillable = [
        'text'
    ];

    public function workStep(): BelongsTo
    {
        return $this->belongsTo(WorkStep::class);
    }
}
