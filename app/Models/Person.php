<?php

namespace App\Models;

use App\Fileable;
use App\FileTypeEnum;
use Exception;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Person extends Model
{
    use Fileable;

    /** @use HasFactory<\Database\Factories\PersonFactory> */
    use HasFactory;
    use HasUuids;
    use SoftDeletes;

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @throws Exception
     */
    public function getHeadshotAttribute(): \Illuminate\Contracts\Filesystem\Filesystem|string|null
    {
        /** @var ?File $file */
        $file = $this
            ->files()
            ->where('type', FileTypeEnum::TYPE_HEADSHOT)
            ->orderByDesc('created_at')
            ->first();

        return $file?->getFileAttribute();
    }
}
