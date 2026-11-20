<?php

namespace App\Models;

use Carbon\CarbonImmutable;
use Database\Factories\PersonFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property string $id
 * @property string|null $user_id
 * @property string|null $name
 * @property string $start_year
 * @property string $end_year
 * @property CarbonImmutable|null $created_at
 * @property CarbonImmutable|null $updated_at
 * @property CarbonImmutable|null $deleted_at
 */
class Person extends Model
{
    /** @use HasFactory<PersonFactory> */
    use HasFactory;

    use HasUuids;
    use SoftDeletes;

    protected $with = ['user'];

    protected $fillable = ['user_id', 'name', 'start_year', 'end_year'];

    /** @return BelongsTo<User, $this> */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /** @return HasMany<ShowCast, $this> */
    public function cast(): HasMany
    {
        return $this->hasMany(ShowCast::class);
    }

    /** @return HasMany<ShowCrew, $this> */
    public function crew(): HasMany
    {
        return $this->hasMany(ShowCrew::class);
    }

    /** @return HasMany<TrainingSessionPerson, $this> */
    public function trainingSessionPeople(): HasMany
    {
        return $this->hasMany(TrainingSessionPerson::class);
    }
}
