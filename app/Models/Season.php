<?php

namespace App\Models;

use Carbon\CarbonImmutable;
use Database\Factories\SeasonFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property string $id
 * @property string $name
 * @property string $colour
 * @property string $description
 * @property CarbonImmutable|null $created_at
 * @property CarbonImmutable|null $updated_at
 * @property CarbonImmutable|null $deleted_at
 */
class Season extends Model
{
    /** @use HasFactory<SeasonFactory> */
    use HasFactory;

    use HasUuids, SoftDeletes;

    protected $fillable = ['name', 'colour', 'description'];

    /** @return HasMany<Show, $this> */
    public function shows(): HasMany
    {
        return $this->hasMany(Show::class);
    }
}
