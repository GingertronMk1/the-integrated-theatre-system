<?php

namespace App\Models;

use Database\Factories\ShowFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Show extends Model
{
    /** @use HasFactory<ShowFactory> */
    use HasFactory;

    use HasUuids;

    protected $fillable = ['name', 'description', 'year', 'playwright_id', 'season_id'];

    /** @return BelongsTo<Playwright, $this> */
    public function playwright(): BelongsTo
    {
        return $this->belongsTo(Playwright::class);
    }

    /** @return BelongsTo<Season, $this> */
    public function season(): BelongsTo
    {
        return $this->belongsTo(Season::class);
    }

    /** @return HasMany<ShowCast, $this> */
    public function cast(): HasMany
    {
        return $this->hasMany(ShowCast::class);
    }

    /** @return HasMany<ShowCrew, $this> */
    public function crew(): HasMany
    {
        return $this->hasMany(ShowCrew::class);
    }

    /** @return HasMany<Performance, $this> */
    public function performances(): HasMany
    {
        return $this->hasMany(Performance::class);
    }
}
