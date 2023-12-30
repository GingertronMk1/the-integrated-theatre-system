<?php

declare(strict_types=1);

namespace App\Domain\TrainingSession;

use RuntimeException;

class TrainingSessionException extends RuntimeException
{
    public function __construct(
    ) {
    }
}
