<?php

namespace App\Models;

use App\FileTypeEnum;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class File extends Model
{
    /** @use HasFactory<\Database\Factories\FileFactory> */
    use HasFactory;
    use HasUuids;
    use SoftDeletes;

    protected $casts = [
        'type' => FileTypeEnum::class,
    ];

    public function getFileAttribute(): Filesystem|string|null
    {
        return Storage::get($this->path);
    }

    public function fileable(): MorphTo
    {
        return $this->morphTo('fileable');
    }

    public function generateRandomImage()
    {
        $img = imagecreate(200, 200);
    }
}
