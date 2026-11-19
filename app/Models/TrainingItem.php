<?php

namespace App\Models;

use Database\Factories\TrainingItemFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TrainingItem extends Model
{
    /** @use HasFactory<TrainingItemFactory> */
    use HasFactory;

    use HasUuids;

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
