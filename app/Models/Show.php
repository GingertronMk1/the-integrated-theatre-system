<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Show extends Model
{
    //
    use SoftDeletes;

    public function playwright(): BelongsTo
    {
        return $this->belongsTo(Playwright::class);
    }

    public function season(): BelongsTo
    {
        return $this->belongsTo(Season::class);
    }

    public function castMembers(): HasMany
    {
        return $this->hasMany(CastMember::class);
    }

    public function crewMembers(): HasMany
    {
        return $this->hasMany(CrewMember::class);
    }
}
