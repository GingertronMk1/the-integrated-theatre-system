<?php

namespace App\Models;

use Carbon\CarbonImmutable;
use Database\Factories\PerformanceFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property CarbonImmutable|null $show_start
 */
class Performance extends Model
{
    /** @use HasFactory<PerformanceFactory> */
    use HasFactory;

    use HasUuids;
    use SoftDeletes;

    protected $with = ['show', 'venue'];

    protected $fillable = ['show_id', 'show_start', 'venue_id', 'capacity'];

    protected $casts = ['show_start' => 'datetime'];

    /** @return BelongsTo<Show, $this> */
    public function show(): BelongsTo
    {
        return $this->belongsTo(Show::class);
    }

    /** @return BelongsTo<Venue, $this> */
    public function venue(): BelongsTo
    {
        return $this->belongsTo(Venue::class);
    }

    /** @return HasMany<Ticket, $this> */
    public function tickets(): HasMany
    {
        return $this->hasMany(Ticket::class);
    }
}
