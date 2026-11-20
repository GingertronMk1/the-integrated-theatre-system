<?php

namespace App\Models;

use App\TicketStatus;
use Carbon\CarbonImmutable;
use Database\Factories\TicketFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property string $id
 * @property string $performance_id
 * @property TicketStatus $status
 * @property int|null $cost_pence
 * @property string|null $buyer_name
 * @property string|null $buyer_email
 * @property CarbonImmutable|null $created_at
 * @property CarbonImmutable|null $updated_at
 * @property CarbonImmutable|null $deleted_at
 */
class Ticket extends Model
{
    /** @use HasFactory<TicketFactory> */
    use HasFactory;

    use HasUuids;
    use SoftDeletes;

    protected $with = ['performance'];

    protected $fillable = ['performance_id', 'status', 'cost_pence', 'buyer_name', 'buyer_email'];

    protected $hidden = ['buyer_name', 'buyer_email'];

    protected function casts(): array
    {
        return ['status' => TicketStatus::class];
    }

    /** @return BelongsTo<Performance, $this> */
    public function performance(): BelongsTo
    {
        return $this->belongsTo(Performance::class);
    }
}
