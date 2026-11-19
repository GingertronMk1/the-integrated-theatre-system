<?php

namespace App\Models;

use Carbon\CarbonImmutable;
use Database\Factories\ShowFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property-read CarbonImmutable|null $first_performance_start
 * @property-read CarbonImmutable|null $last_performance_start
 * @property-read Collection<int, Performance> $performances
 */
class Show extends Model
{
    /** @use HasFactory<ShowFactory> */
    use HasFactory;

    use HasUuids;

    protected $with = ['playwright', 'season'];

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
        return $this->hasMany(Performance::class)->orderBy('performances.show_start');
    }

    /** @return Attribute<CarbonImmutable|null, never> */
    protected function firstPerformanceStart(): Attribute
    {
        return Attribute::get(fn (): ?CarbonImmutable => $this->relationLoaded('performances')
            ? $this->performances->first()?->show_start
            : $this->performances()->without(['show', 'venue'])->first(['show_start'])?->show_start);
    }

    /** @return Attribute<CarbonImmutable|null, never> */
    protected function lastPerformanceStart(): Attribute
    {
        return Attribute::get(fn (): ?CarbonImmutable => $this->relationLoaded('performances')
            ? $this->performances->last()?->show_start
            : $this->performances()->without(['show', 'venue'])->reorder('performances.show_start', 'desc')->first(['show_start'])?->show_start);
    }
}
