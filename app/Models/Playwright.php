<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Playwright extends Model
{
    use SoftDeletes;

    public function shows(): HasMany
    {
        return $this->hasMany(Show::class);
    }
}
