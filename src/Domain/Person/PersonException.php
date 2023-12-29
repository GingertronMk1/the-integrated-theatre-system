<?php

declare(strict_types=1);

namespace App\Domain\Person;

use RuntimeException;

class PersonException extends RuntimeException
{
    public function __construct(
    ) {
    }
}
