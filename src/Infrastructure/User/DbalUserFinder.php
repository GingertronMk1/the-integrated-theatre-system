<?php

declare(strict_types=1);

namespace App\Infrastructure\User;

use App\Domain\User\UserEntity;
use App\Domain\User\UserFinderInterface;
use App\Domain\User\ValueObject\UserId;
use Doctrine\DBAL\Connection;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

final readonly class DbalUserFinder implements UserFinderInterface
{
    public function __construct(
        private Connection $connection
    ) {
    }

    public function refreshUser(UserInterface $user): UserInterface
    {
        return $this->loadUserByIdentifier($user->getUserIdentifier());
    }

    public function supportsClass(string $class): bool
    {
        return UserEntity::class === $class;
    }

    public function loadUserByIdentifier(string $identifier): UserInterface
    {
        $row = $this
            ->connection
            ->createQueryBuilder()
            ->select('*')
            ->from('users', 'u')
            ->where('email = :email')
            ->setParameter('email', $identifier)
            ->executeQuery()
            ->fetchAssociative();

        return $this->createUserFromRow($row);
    }

    public function upgradePassword(PasswordAuthenticatedUserInterface $user, mixed $newHashedPassword): void
    {
        // Doing nothing for now
    }

    public function findAll(): array
    {
        $qb = $this->connection->createQueryBuilder();
        $rows = $qb
            ->select('*')
            ->from('users', 'u')
            ->executeQuery()
            ->fetchAllAssociative();

        return array_map(fn ($row) => $this->createUserFromRow($row), $rows);
    }

    public function findById(UserId $id): UserEntity
    {
        $qb = $this->connection->createQueryBuilder();
        $row = $qb
            ->select('*')
            ->from('users', 'u')
            ->where('id = :id')
            ->setParameter('id', (string) $id)
            ->executeQuery()
            ->fetchAssociative();

        return $this->createUserFromRow($row);
    }

    /**
     * @param array<string, string> $row
     */
    private function createUserFromRow(array $row): UserEntity
    {
        return new UserEntity(
            UserId::fromString($row['id']),
            $row['email'],
            [],
            $row['password'],
        );
    }
}
