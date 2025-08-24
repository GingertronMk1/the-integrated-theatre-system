<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CrewRole extends Model
{
    /** @use HasFactory<\Database\Factories\CrewRoleFactory> */
    use HasFactory;

    use HasUuids;
    use SoftDeletes;
}
