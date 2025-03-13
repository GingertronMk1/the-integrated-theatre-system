<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class CrewMember extends Model
{
    //
    use SoftDeletes;

    public function role(): BelongsTo
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
