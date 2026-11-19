<?php

namespace App\Models;

use Database\Factories\RoleFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Role extends Model
{
    /** @use HasFactory<RoleFactory> */
    use HasFactory;

    use HasUuids;

    protected $fillable = ['name'];

    /** @return HasMany<ShowCrew, $this> */
    public function crew(): HasMany
    {
        return $this->hasMany(ShowCrew::class);
    }
}
