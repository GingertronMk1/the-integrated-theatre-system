<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class CastMember extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'show_id',
        'person_id',
        'role_name',
        'notes',
        'legacy_link',
    ];

    protected $with = [
        'show',
        'person',
    ];

    public function show(): BelongsTo
    {
        return $this->belongsTo(Show::class);
    }

    public function person(): BelongsTo
    {
        return $this->belongsTo(Person::class);
    }
}
