<?php

namespace App\Models;

use Database\Factories\VenueFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

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
