<?php

declare(strict_types=1);

namespace App\Application\User\CreateUser;

final class Command
{
    public function __construct(
        public string $email = '',
        public string $password = '',
    ) {
    }
}
