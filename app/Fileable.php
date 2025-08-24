<?php

namespace App;

use App\Models\File;
use Exception;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use function method_exists;

trait Fileable
{
    /**
     * @throws Exception
     */
    public function files(): MorphMany
    {
        if (!method_exists($this, 'morphMany')) {
            throw new Exception('This model cannot be fileable')
        }

        return $this->morphMany(Fileable::class, 'fileable');
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
            ->latest()
            ->first();

        return $file?->getFileAttribute();
    }
}
