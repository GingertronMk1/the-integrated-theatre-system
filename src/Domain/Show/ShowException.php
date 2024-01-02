<?php

declare(strict_types=1);

namespace App\Domain\Show;

use App\Domain\Show\ValueObject\ShowId;
use RuntimeException;

final class ShowException extends RuntimeException
{
    public static function notFound(ShowId $id): self
    {
        return new self("There was a problem finding a show with ID {$id}.");
    }
}
