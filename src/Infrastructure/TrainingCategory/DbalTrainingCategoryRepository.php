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
    )
    {
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
                'updated_at' => ':now'
            ])
            ->setParameters([
                'id' => (string) TrainingCategoryId::generate(),
                'name' => $name,
                'now' => (new DateTimeImmutable())->format('c')
            ])
            ->executeQuery()
        ;
    }
}
