<?php

namespace App\Models\Show;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Show extends Model
{
    use HasFactory;

    protected $with = [
        'defaultVenue',
        'season',
    ];

    public function defaultVenue() {
        return $this->belongsTo(Venue::class, 'default_venue_id', 'id');
    }

    public function season() {
        return $this->belongsTo(Season::class);
    }
}
