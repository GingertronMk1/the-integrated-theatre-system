<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Performance extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $fillable = [
        'location',
        'show_id',
        'show_start',
        'doors',
        'capacity'
    ];

    protected $casts = [
        'show_start' => 'datetime',
        'doors' => 'datetime',
    ];

    public function show(): BelongsTo
    {
        return $this->belongsTo(Show::class);
    }
}