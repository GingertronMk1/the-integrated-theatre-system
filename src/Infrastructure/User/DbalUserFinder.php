<?php

declare(strict_types=1);

namespace App\Infrastructure\User;

use App\Application\User\UserFinderInterface;
use App\Application\User\UserModel;
use App\Domain\User\UserException;
use App\Domain\User\ValueObject\UserId;
use App\Infrastructure\Common\AbstractDbalFinder;
use Doctrine\DBAL\Connection;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

final class DbalUserFinder extends AbstractDbalFinder implements UserFinderInterface
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
            ->from($this->getTable())
            ->where('email = :email')
            ->setParameter('email', $identifier)
            ->executeQuery()
            ->fetchAssociative();

        if (!is_array($row)) {
            throw UserException::notFoundWithIdentifier($identifier);
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
            ->from($this->getTable())
            ->executeQuery()
            ->fetchAllAssociative();

        return array_map(fn ($row) => $this->createUserFromRow($row), $rows);
    }

    public function find(UserId $id): UserModel
    {
        $qb = $this->connection->createQueryBuilder();
        $row = $qb
            ->select('*')
            ->from($this->getTable())
            ->where('id = :id')
            ->setParameter('id', (string) $id)
            ->executeQuery()
            ->fetchAssociative();

        if (!is_array($row)) {
            throw UserException::notFound($id);
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

    protected function getTable(): string
    {
        return 'users';
    }

    public function count(UserId $id = null): int
    {
        return $this->_count($this->connection, $id);
    }
}
