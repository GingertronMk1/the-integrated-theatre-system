<?php

declare(strict_types=1);

namespace App\Domain\TrainingItem;

use App\Domain\TrainingItem\ValueObject\TrainingItemId;
use RuntimeException;
use Throwable;

final class TrainingItemException extends RuntimeException
{
    public static function notFound(TrainingItemId $id, Throwable $previous = null): self
    {
        return new self("No item found with ID {$id}", previous: $previous);
    }

    public static function errorSaving(Throwable $previous): self
    {
        return new self('There was an issue storing the item', previous: $previous);
    }
}
