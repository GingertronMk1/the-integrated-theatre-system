<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
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
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
