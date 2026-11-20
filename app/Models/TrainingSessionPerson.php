<?php

namespace App\Models;

use App\TrainingSessionPersonType;
use Carbon\CarbonImmutable;
use Database\Factories\TrainingSessionPersonFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property string $id
 * @property string $training_session_id
 * @property string $person_id
 * @property TrainingSessionPersonType $type
 * @property CarbonImmutable|null $created_at
 * @property CarbonImmutable|null $updated_at
 * @property CarbonImmutable|null $deleted_at
 */
class TrainingSessionPerson extends Model
{
    /** @use HasFactory<TrainingSessionPersonFactory> */
    use HasFactory;

    use HasUuids;
    use SoftDeletes;

    protected $with = ['trainingSession', 'person'];

    protected $fillable = ['training_session_id', 'person_id', 'type'];

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
