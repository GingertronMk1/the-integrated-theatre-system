<?php

declare(strict_types=1);

namespace App\Domain\User;

use App\Domain\User\ValueObject\UserId;

interface UserRepositoryInterface
{
    public function getNextId(): UserId;

    public function createUser(string $email, string $password): void;
}
