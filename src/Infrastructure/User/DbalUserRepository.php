<?php

declare(strict_types=1);

namespace App\Infrastructure\User;

use App\Application\User\UserRepositoryInterface;
use App\Domain\User\UserEntity;
use App\Domain\User\ValueObject\UserId;
use Doctrine\DBAL\Connection;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

final readonly class DbalUserRepository implements UserRepositoryInterface
{
    public function __construct(
        private Connection $connection,
        private UserPasswordHasherInterface $passwordHasher
    ) {
    }

    public function getNextId(): UserId
    {
        return UserId::generate();
    }

    public function createUser(string $email, string $password): void
    {
        try {
            $this->connection->transactional(function (Connection $conn) use ($email, $password) {
                $user = new UserEntity(
                    $this->getNextId(),
                    $email,
                    [],
                    $password
                );
                $queryBuilder = $conn->createQueryBuilder();
                $queryBuilder
                    ->insert('users')
                    ->values([
                        'id' => ':id',
                        'email' => ':email',
                        'password' => ':password',
                    ])
                    ->setParameters([
                        'id' => (string) $user->getId(),
                        'email' => $user->getEmail(),
                        'password' => $this->passwordHasher->hashPassword($user, $user->getPassword()),
                    ])
                    ->executeQuery()
                ;
            });
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
