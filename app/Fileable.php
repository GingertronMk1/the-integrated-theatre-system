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
        if (! method_exists($this, 'morphMany')) {
            throw new Exception('This model cannot be fileable');
        }

        return $this->morphMany(File::class, 'fileable');
    }
}
