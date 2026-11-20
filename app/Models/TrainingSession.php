<?php

namespace App\Models;

use Carbon\CarbonImmutable;
use Database\Factories\TrainingSessionFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property string $id
 * @property string $training_item_id
 * @property CarbonImmutable $occurred_at
 * @property CarbonImmutable|null $created_at
 * @property CarbonImmutable|null $updated_at
 * @property CarbonImmutable|null $deleted_at
 */
class TrainingSession extends Model
{
    /** @use HasFactory<TrainingSessionFactory> */
    use HasFactory;

    use HasUuids;
    use SoftDeletes;

    protected $with = ['trainingItem'];

    protected $fillable = ['training_item_id', 'occurred_at'];

    protected $table = 'training_session';

    protected function casts(): array
    {
        return ['occurred_at' => 'datetime'];
    }

    /** @return BelongsTo<TrainingItem, $this> */
    public function trainingItem(): BelongsTo
    {
        return $this->belongsTo(TrainingItem::class);
    }

    /** @return HasMany<TrainingSessionPerson, $this> */
    public function people(): HasMany
    {
        return $this->hasMany(TrainingSessionPerson::class);
    }
}
