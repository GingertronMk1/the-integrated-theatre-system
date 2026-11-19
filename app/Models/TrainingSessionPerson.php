<?php

namespace App\Models;

use App\TrainingSessionPersonType;
use Database\Factories\TrainingSessionPersonFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TrainingSessionPerson extends Model
{
    /** @use HasFactory<TrainingSessionPersonFactory> */
    use HasFactory;

    use HasUuids;

    protected $with = ['trainingSession', 'person'];

    protected $fillable = ['training_session_id', 'person_id', 'type'];

    public $timestamps = false;

    protected function casts(): array
    {
        return ['type' => TrainingSessionPersonType::class];
    }

    /** @return BelongsTo<TrainingSession, $this> */
    public function trainingSession(): BelongsTo
    {
        return $this->belongsTo(TrainingSession::class);
    }

    /** @return BelongsTo<Person, $this> */
    public function person(): BelongsTo
    {
        return $this->belongsTo(Person::class);
    }
}
