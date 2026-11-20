<?php

namespace App\Models;

use Carbon\CarbonImmutable;
use Database\Factories\PlaywrightFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property string $id
 * @property string $name
 * @property string $bio
 * @property array<array-key, mixed> $external_links
 * @property CarbonImmutable|null $created_at
 * @property CarbonImmutable|null $updated_at
 * @property CarbonImmutable|null $deleted_at
 */
class Playwright extends Model
{
    /** @use HasFactory<PlaywrightFactory> */
    use HasFactory;

    use HasUuids, SoftDeletes;

    protected $fillable = ['name', 'bio', 'external_links'];

    protected function casts(): array
    {
        return ['external_links' => 'array'];
    }

    /** @return HasMany<Show, $this> */
    public function shows(): HasMany
    {
        return $this->hasMany(Show::class);
    }
}
