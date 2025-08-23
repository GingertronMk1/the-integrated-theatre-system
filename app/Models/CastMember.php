<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class CastMember extends Model
{
    /** @use HasFactory<\Database\Factories\CastMemberFactory> */
    use HasFactory;

    use HasUuids;
    use SoftDeletes;

    public function person(): BelongsTo
    {
        return $this->belongsTo(Person::class);
    }

    public function show(): BelongsTo
    {
        return $this->belongsTo(Show::class);
    }
}
