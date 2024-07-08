<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Person extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $fillable = [
        'name',
        'start_year',
        'end_year',
        'user_id',
    ];

    protected $with = [
    'user'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
