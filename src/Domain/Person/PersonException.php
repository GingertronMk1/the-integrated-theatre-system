<?php

declare(strict_types=1);

namespace App\Domain\Person;

use App\Domain\Person\ValueObject\PersonId;
use RuntimeException;

class PersonException extends RuntimeException
{
    public static function notFound(PersonId $id): self
    {
        return new self("No person found with ID {$id}");
    }
}
