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
use Ramsey\Uuid\Uuid;

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
        return Storage::get($this->filename);
    }

    public function fileable(): MorphTo
    {
        return $this->morphTo('fileable');
    }

    public static function generatePlaceholder(int $width = 200, int $height = 200, FileTypeEnum $type = FileTypeEnum::TYPE_OTHER): static
    {
        $img = imagecreate($width, $height);
        $background = imagecolorallocate($img, 127, 127, 127);
        $text_colour = imagecolorallocate($img, 255, 255, 255);
        //        $line_colour = imagecolorallocate( $img, 128, 255, 0 );
        imagestring(
            $img,
            4,
            10,
            ($height / 2) - 10,
            sprintf('%dx%d', $width, $height),
            $text_colour
        );
        imagestring(
            $img,
            4,
            10,
            ($height / 2) + 10,
            $type->value,
            $text_colour
        );

        ob_start();
        imagepng($img);
        $data = ob_get_contents();
        ob_end_clean();

        $data = base64_encode($data);
        $data = "data:image/png;base64,{$data}";

        imagedestroy($img);

        $filePath = sprintf('%s.png', Uuid::uuid7()->toString());
        Storage::put($filePath, $data);

        return new static([
            'filename' => $filePath,
            'type' => $type,
        ]);
    }
}
