<?php

declare(strict_types=1);

namespace App\Application\User\CreateUser;

use App\Domain\User\UserEntity;
use App\Domain\User\UserRepositoryInterface;
use App\Domain\User\ValueObject\UserId;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

final readonly class CommandHandler
{
    public function __construct(
        private UserRepositoryInterface $userRepository,
        private UserPasswordHasherInterface $passwordHasher
    ) {
    }

    public function handle(Command $command): UserId
    {
        $id = $this->userRepository->getNextId();
        $userEntity = new UserEntity(
            $id,
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

        return $id;
    }
}
