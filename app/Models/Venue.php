<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Venue extends Model
{
    //
    use SoftDeletes;

    public function performances(): HasMany
    {
        return $this->hasMany(Performance::class);
    }
}
