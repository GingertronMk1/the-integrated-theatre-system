<?php

declare(strict_types=1);

namespace App\Application\User\CreateUser;

use App\Domain\User\UserEntity;
use App\Domain\User\UserRepositoryInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

final readonly class CommandHandler
{
    public function __construct(
        private UserRepositoryInterface $userRepository,
        private UserPasswordHasherInterface $passwordHasher
    ) {
    }

    public function handle(Command $command): void
    {
        $userEntity = new UserEntity(
            $this->userRepository->getNextId(),
            $command->email,
            [],
            $command->password
        );
        $hashedPassword = $this->passwordHasher->hashPassword($userEntity, $userEntity->getPassword());
        $this->userRepository->save(new UserEntity(
            $userEntity->id,
            $userEntity->email,
            $userEntity->roles,
            $hashedPassword
        ));
    }
}
