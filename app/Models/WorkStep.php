<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

final class WorkStep extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['id'];

    public array $translatedAttributes = ['text'];

    /**
     * Relationship with WorkStepTranslation.
     *
     * @return HasMany
     */
    public function translations(): HasMany
    {
        return $this->hasMany(WorkStepTranslation::class);
    }

    // Accessors and Mutators

    /**
     * Cast attributes to native types.
     *
     * @return array<string, string>
     */
    public function casts(): array
    {
        return [
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
            'deleted_at' => 'datetime',
        ];
    }
}
