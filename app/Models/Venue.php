<?php

namespace App\Models;

use Carbon\CarbonImmutable;
use Database\Factories\VenueFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property string $id
 * @property string $name
 * @property string $address
 * @property string $description
 * @property CarbonImmutable|null $created_at
 * @property CarbonImmutable|null $updated_at
 * @property CarbonImmutable|null $deleted_at
 */
class Venue extends Model
{
    /** @use HasFactory<VenueFactory> */
    use HasFactory;

    use HasUuids, SoftDeletes;

    protected $fillable = ['name', 'address', 'description'];

    /** @return HasMany<Performance, $this> */
    public function performances(): HasMany
    {
        return $this->hasMany(Performance::class);
    }
}
