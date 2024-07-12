<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Show extends Model
{
    use HasFactory;
    use HasUuids;
    use SoftDeletes;

    protected $fillable = [
        'title',
        'description',
        'year',
        'season_id',
        'venue_id',
    ];

    protected $casts = [];

    protected $with = [
        'season',
        'venue',
        'performances',
    ];

    protected $attributes = [
        'year' => 2000,
    ];

    public function season(): BelongsTo
    {
        return $this->belongsTo(Season::class);
    }

    public function performances(): HasMany
    {
        return $this->hasMany(Performance::class)->orderBy('show_start');
    }

    public function venue(): BelongsTo
    {
        return $this->belongsTo(Venue::class);
    }
}
