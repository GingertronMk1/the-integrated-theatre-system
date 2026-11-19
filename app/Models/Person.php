<?php

namespace App\Models;

use Database\Factories\PersonFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Person extends Model
{
    /** @use HasFactory<PersonFactory> */
    use HasFactory;

    use HasUuids;

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
