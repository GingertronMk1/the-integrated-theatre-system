<?php

declare(strict_types=1);

namespace App\Application\User\CreateUser;

use App\Domain\User\UserRepositoryInterface;

final readonly class CommandHandler
{
    public function __construct(
        private UserRepositoryInterface $userRepository
    ) {
    }

    public function handle(Command $command): void
    {
        $this->userRepository->createUser($command->email, $command->password);
    }
}
