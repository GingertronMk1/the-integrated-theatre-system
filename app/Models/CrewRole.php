<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class CrewRole extends Model
{
    //
    use SoftDeletes;

    public function crewMembers(): HasMany
    {
        return $this->hasMany(CrewMember::class);
    }
}
