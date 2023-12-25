<?php

declare(strict_types=1);

namespace App\Infrastructure\TrainingCategory;

use App\Application\TrainingCategory\TrainingCategoryRepositoryInterface;
use App\Domain\TrainingCategory\ValueObject\TrainingCategoryId;
use DateTimeImmutable;
use Doctrine\DBAL\Connection;

final readonly class DbalTrainingCategoryRepository implements TrainingCategoryRepositoryInterface
{
    public function __construct(
        private Connection $connection
    ) {
    }

    public function createTrainingCategory(string $name): void
    {
        $qb = $this->connection->createQueryBuilder();
        $qb
            ->insert('training_categories')
            ->values([
                'id' => ':id',
                'name' => ':name',
                'created_at' => ':now',
                'updated_at' => ':now',
            ])
            ->setParameters([
                'id' => (string) TrainingCategoryId::generate(),
                'name' => $name,
                'now' => (new DateTimeImmutable())->format('c'),
            ])
            ->executeQuery()
        ;
    }

    public function updateTrainingCategory(TrainingCategoryId $id, string $name): void
    {
        $finderQB = $this->connection->createQueryBuilder();
        $result = $finderQB
            ->select('COUNT(*)')
            ->from('training_categories')
            ->where('id = :id')
            ->setParameter('id', (string) $id)
            ->fetchFirstColumn()
            ;
        if ($result < 1) {
            throw new \Exception("No category found with ID {$id}");
        }

        $qb = $this->connection->createQueryBuilder();
        $qb
            ->update('training_categories')
            ->set('name', ':name')
            ->set('updated_at', ':now')
            ->setParameters([
                'id' => (string) $id,
                'name' => $name,
                'now' => (new DateTimeImmutable())->format('c'),
            ])
            ->where('id = :id')
            ->executeQuery()
        ;

    }
}
