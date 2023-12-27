<?php

declare(strict_types=1);

namespace App\Infrastructure\User;

use App\Application\User\UserFinderInterface;
use App\Application\User\UserModel;
use App\Domain\User\ValueObject\UserId;
use Doctrine\DBAL\Connection;
use Exception;
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
        return UserModel::class === $class;
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

        if (!is_array($row)) {
            throw new Exception('Error finding categories');
        }

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

    public function findById(UserId $id): UserModel
    {
        $qb = $this->connection->createQueryBuilder();
        $row = $qb
            ->select('*')
            ->from('users', 'u')
            ->where('id = :id')
            ->setParameter('id', (string) $id)
            ->executeQuery()
            ->fetchAssociative();

        if (!is_array($row)) {
            throw new Exception("No training item found with ID {$id}");
        }

        return $this->createUserFromRow($row);
    }

    /**
     * @param array<string, string> $row
     */
    private function createUserFromRow(array $row): UserModel
    {
        return new UserModel(
            UserId::fromString($row['id']),
            $row['email'],
            [],
            $row['password'],
        );
    }
}
