<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class TrainingItem extends Model
{
    use HasFactory;
    use HasUuids;
    use SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'dangerous',
        'training_category_id',
    ];

    protected $casts = [
        'dangerous' => 'boolean',
    ];

    protected $with = [
        'trainingCategory',
    ];

    public function trainingCategory(): BelongsTo
    {
        return $this->belongsTo(TrainingCategory::class);
    }
}
