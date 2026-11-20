<?php

namespace App\Models;

use Carbon\CarbonImmutable;
use Database\Factories\ShowCastFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property string $id
 * @property string $show_id
 * @property string $person_id
 * @property string $role_name
 * @property int $sort
 * @property string|null $notes
 * @property CarbonImmutable|null $created_at
 * @property CarbonImmutable|null $updated_at
 * @property CarbonImmutable|null $deleted_at
 */
class ShowCast extends Model
{
    /** @use HasFactory<ShowCastFactory> */
    use HasFactory;

    use HasUuids;
    use SoftDeletes;

    protected $with = ['show', 'person'];

    protected $fillable = ['show_id', 'person_id', 'role_name', 'notes', 'sort'];

    protected $table = 'show_cast';

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
}
