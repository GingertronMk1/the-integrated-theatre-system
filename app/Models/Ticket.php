<?php

namespace App\Models;

use App\TicketStatus;
use Database\Factories\TicketFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Ticket extends Model
{
    /** @use HasFactory<TicketFactory> */
    use HasFactory;

    use HasUuids;

    protected $with = ['performance'];

    protected $fillable = ['performance_id', 'status', 'cost_pence'];

    public $timestamps = false;

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
