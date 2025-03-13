<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Person extends Model
{
    //
    use SoftDeletes;

    protected $fillable = [
        'name',
        'user_id',
        'start_year',
        'end_year',
        'legacy_link',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function castShows(): BelongsToMany
    {
        return $this->belongsToMany(Show::class, CastMember::class);
    }

    public function crewShows(): BelongsToMany
    {
        return $this->belongsToMany(Show::class, CrewMember::class);
    }
}
