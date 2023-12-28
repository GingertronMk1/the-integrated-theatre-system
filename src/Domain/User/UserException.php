<?php

declare(strict_types=1);

namespace App\Domain\User;

use App\Domain\User\ValueObject\UserId;
use RuntimeException;
use Throwable;

final class UserException extends RuntimeException
{
    public static function notFoundWithIdentifier(string $identifier): self
    {
        return new self("No user found with identifier '{$identifier}'");
    }

    public static function notFound(UserId $id, Throwable $previous = null): self
    {
        return new self("No user found with ID {$id}", previous: $previous);
    }

    public static function errorSaving(Throwable $previous): self
    {
        return new self('There was an issue storing the user', previous: $previous);
    }
}
