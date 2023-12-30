<?php

declare(strict_types=1);

namespace App\Infrastructure\User;

use App\Domain\User\UserEntity;
use App\Domain\User\UserRepositoryInterface;
use App\Domain\User\ValueObject\UserId;
use DateTimeImmutable;
use Doctrine\DBAL\Connection;
use Exception;

final readonly class DbalUserRepository implements UserRepositoryInterface
{
    public function __construct(
        private Connection $connection,
    ) {
    }

    public function getNextId(): UserId
    {
        return UserId::generate();
    }

    public function createUser(UserEntity $userEntity): void
    {
        try {
            $this->connection->transactional(function (Connection $conn) use ($userEntity) {
                $queryBuilder = $conn->createQueryBuilder();
                $queryBuilder
                    ->insert('users')
                    ->values([
                        'id' => ':id',
                        'email' => ':email',
                        'password' => ':password',
                        'created_at' => ':now',
                        'updated_at' => ':now',
                    ])
                    ->setParameters([
                        'id' => (string) $userEntity->getId(),
                        'email' => $userEntity->getEmail(),
                        'password' => $userEntity->getPassword(),
                        'now' => (new DateTimeImmutable())->format('c'),
                    ])
                    ->executeQuery()
                ;
            });
        } catch (Exception $e) {
            throw $e;
        }
    }
}
