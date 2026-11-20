<?php

namespace App\Models;

use Carbon\CarbonImmutable;
use Database\Factories\TrainingItemFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property string $id
 * @property string $name
 * @property string $training_category_id
 * @property bool $dangerous
 * @property CarbonImmutable|null $created_at
 * @property CarbonImmutable|null $updated_at
 * @property CarbonImmutable|null $deleted_at
 */
class TrainingItem extends Model
{
    /** @use HasFactory<TrainingItemFactory> */
    use HasFactory;

    use HasUuids;
    use SoftDeletes;

    protected $with = ['trainingCategory'];

    protected $fillable = ['name', 'training_category_id', 'dangerous'];

    protected function casts(): array
    {
        return ['dangerous' => 'boolean'];
    }

    /** @return BelongsTo<TrainingCategory, $this> */
    public function trainingCategory(): BelongsTo
    {
        return $this->belongsTo(TrainingCategory::class);
    }

    /** @return HasMany<TrainingSession, $this> */
    public function sessions(): HasMany
    {
        return $this->hasMany(TrainingSession::class);
    }
}
