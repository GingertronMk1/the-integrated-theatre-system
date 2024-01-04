<?php

declare(strict_types=1);

namespace App\Infrastructure\User;

use App\Application\Common\Service\ClockInterface;
use App\Domain\User\UserEntity;
use App\Domain\User\UserRepositoryInterface;
use App\Domain\User\ValueObject\UserId;
use App\Infrastructure\Common\AbstractDbalRepository;
use Doctrine\DBAL\Connection;
use Exception;

final class DbalUserRepository extends AbstractDbalRepository implements UserRepositoryInterface
{
    public function __construct(
        private readonly Connection $connection,
        private readonly ClockInterface $clock,
    ) {
    }

    public function getNextId(): UserId
    {
        return UserId::generate();
    }

    public function save(UserEntity $userEntity): void
    {
        try {
            $this->connection->transactional(function (Connection $conn) use ($userEntity) {
                $countQb = $conn->createQueryBuilder();
                $count = $countQb
                    ->select('COUNT(*)')
                    ->from($this->getTable())
                    ->where('id = :id')
                    ->setParameter('id', (string) $userEntity->id)
                    ->fetchOne();

                $upsertQb = $conn->createQueryBuilder();
                if (0 === $count) {
                    $upsertQb
                        ->insert($this->getTable())
                        ->values([
                            'id' => ':id',
                            'email' => ':email',
                            'password' => ':password',
                            'created_at' => ':now',
                            'updated_at' => ':now',
                        ]);
                } else {
                    $upsertQb
                        ->update($this->getTable())
                        ->set('email', ':email')
                        ->set('password', ':password')
                        ->set('updated_at', ':now')
                        ->where('id = :id')
                    ;
                }
                $upsertQb->setParameters([
                        'id' => (string) $userEntity->getId(),
                        'email' => $userEntity->getEmail(),
                        'password' => $userEntity->getPassword(),
                        'now' => (string) $this->clock->getCurrentTime(),
                    ])
                    ->executeStatement()
                ;
            });
        } catch (Exception $e) {
            throw $e;
        }
    }

    protected function getTable(): string
    {
        return 'users';
    }
}
