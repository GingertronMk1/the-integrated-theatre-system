<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Playwright extends Model
{
    /** @use HasFactory<\Database\Factories\PlaywrightFactory> */
    use HasFactory;
    use SoftDeletes;
}
