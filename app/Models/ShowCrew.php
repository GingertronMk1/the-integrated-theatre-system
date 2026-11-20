<?php

namespace App\Models;

use Carbon\CarbonImmutable;
use Database\Factories\ShowCrewFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property string $id
 * @property string $show_id
 * @property string $role_id
 * @property string $person_id
 * @property string|null $notes
 * @property CarbonImmutable|null $created_at
 * @property CarbonImmutable|null $updated_at
 * @property CarbonImmutable|null $deleted_at
 */
class ShowCrew extends Model
{
    /** @use HasFactory<ShowCrewFactory> */
    use HasFactory;

    use HasUuids;
    use SoftDeletes;

    protected $with = ['show', 'person', 'role'];

    protected $fillable = ['show_id', 'person_id', 'role_id', 'notes'];

    protected $table = 'show_crew';

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
