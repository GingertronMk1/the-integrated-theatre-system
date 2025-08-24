<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class CrewMember extends Model
{
    /** @use HasFactory<\Database\Factories\CrewMemberFactory> */
    use HasFactory;

    use HasUuids;
    use SoftDeletes;

    protected $with = [
        'person',
        'crewRole',
        'show',
    ];

    public function getNameAttribute(): string
    {
        return sprintf('%s, %s for "%s"', $this->person->name, $this->crewRole->name, $this->show->title);
    }

    public function person(): BelongsTo
    {
        return $this->belongsTo(Person::class);
    }

    public function crewRole(): BelongsTo
    {
        return $this->belongsTo(CrewRole::class);
    }

    public function show(): BelongsTo
    {
        return $this->belongsTo(Show::class);
    }
}
