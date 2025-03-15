<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Playwright extends Model
{
    use SoftDeletes;

    protected $casts = [
        'external_links' => 'array',
    ];

    public function shows(): HasMany
    {
        return $this->hasMany(Show::class);
    }
}
