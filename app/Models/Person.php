<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Person extends Model
{
    //
    use SoftDeletes;

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function castShows(): HasMany
    {
        return $this
            ->hasMany(CastMember::class)
            ->with('show');
    }

    public function crewShows(): HasMany
    {
        return $this
            ->hasMany(CrewMember::class)
            ->with(['show', 'crewRole']);
    }
}
