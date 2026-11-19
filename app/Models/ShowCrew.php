<?php

namespace App\Models;

use Database\Factories\ShowCrewFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ShowCrew extends Model
{
    /** @use HasFactory<ShowCrewFactory> */
    use HasFactory;

    use HasUuids;

    protected $fillable = ['show_id', 'person_id', 'role_id', 'notes'];

    protected $table = 'show_crew';

    public $timestamps = false;

    /** @return BelongsTo<Show, $this> */
    public function show(): BelongsTo
    {
        return $this->belongsTo(Show::class);
    }

    /** @return BelongsTo<Person, $this> */
    public function person(): BelongsTo
    {
        return $this->belongsTo(Person::class);
    }

    /** @return BelongsTo<Role, $this> */
    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }
}
