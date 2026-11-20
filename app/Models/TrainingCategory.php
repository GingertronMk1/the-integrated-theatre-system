<?php

namespace App\Models;

use Carbon\CarbonImmutable;
use Database\Factories\TrainingCategoryFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property string $id
 * @property string $name
 * @property CarbonImmutable|null $created_at
 * @property CarbonImmutable|null $updated_at
 * @property CarbonImmutable|null $deleted_at
 */
class TrainingCategory extends Model
{
    /** @use HasFactory<TrainingCategoryFactory> */
    use HasFactory;

    use HasUuids;
    use SoftDeletes;

    protected $fillable = ['name'];

    /** @return HasMany<TrainingItem, $this> */
    public function items(): HasMany
    {
        return $this->hasMany(TrainingItem::class);
    }
}
