<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class TrainingSession extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $fillable = [
        'trainer_id',
        'happened_at'
    ];

    protected $casts = [
        'happened_at' => 'datetime'
    ];

    public function trainer(): BelongsTo
    {
        return $this->belongsTo(Person::class, 'trainer_id');
    }

    public function trainees(): BelongsToMany
    {
        return $this->belongsToMany(Person::class, 'trainee');
    }

    public function trainingItems(): BelongsToMany
    {
        return $this->belongsToMany(TrainingItem::class, 'training_session_item');
    }
}
