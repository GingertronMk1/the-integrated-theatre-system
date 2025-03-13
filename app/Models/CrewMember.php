<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class CrewMember extends Model
{
    //
    use SoftDeletes;

    protected $fillable = [
        'show_id',
        'crew_role_id',
        'person_id',
        'notes',
    ];

    protected $with = [
        'crewRole',
        'person',
        'show',
    ];

    public function crewRole(): BelongsTo
    {
        return $this->belongsTo(\App\Models\CrewRole::class);
    }

    public function person(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Person::class);
    }

    public function show(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Show::class);
    }
}
