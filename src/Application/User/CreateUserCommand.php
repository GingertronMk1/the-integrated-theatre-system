<?php

declare(strict_types=1);

namespace App\Application\User;

final class CreateUserCommand
{
    public function __construct(
        public string $email = '',
        public string $password = '',
    ) {
    }
}
