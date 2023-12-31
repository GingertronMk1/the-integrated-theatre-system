<?php

declare(strict_types=1);

namespace App\Domain\TrainingSession;

use App\Domain\TrainingSession\ValueObject\TrainingSessionId;
use RuntimeException;

final class TrainingSessionException extends RuntimeException
{
    public static function notFoundWithId(TrainingSessionId $id): self
    {
        return new self("No training session found with ID {$id}.");
    }
}
