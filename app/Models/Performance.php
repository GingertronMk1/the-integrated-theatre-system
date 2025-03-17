<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Performance extends Model
{
    //
    use SoftDeletes;

    protected $with = [
        'show',
        'venue',
    ];

    protected $casts = [
        'show_date' => 'date',
    ];

    public function show(): BelongsTo
    {
        return $this->belongsTo(Show::class);
    }

    public function venue(): BelongsTo
    {
        return $this->belongsTo(Venue::class);
    }
}
