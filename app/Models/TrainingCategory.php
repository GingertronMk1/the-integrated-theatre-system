<?php

namespace App\Models;

use Database\Factories\TrainingCategoryFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TrainingCategory extends Model
{
    /** @use HasFactory<TrainingCategoryFactory> */
    use HasFactory;

    use HasUuids;

    protected $fillable = ['name'];

    /** @return HasMany<TrainingItem, $this> */
    public function items(): HasMany
    {
        return $this->hasMany(TrainingItem::class);
    }
}
