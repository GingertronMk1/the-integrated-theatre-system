<?php

declare(strict_types=1);

namespace App\Infrastructure\TrainingCategory;

use App\Domain\TrainingCategory\TrainingCategoryEntity;
use App\Domain\TrainingCategory\TrainingCategoryFinderInterface;
use App\Domain\TrainingCategory\ValueObject\TrainingCategoryId;
use DateTimeImmutable;
use Doctrine\DBAL\Connection;

final readonly class DbalTrainingCategoryFinder implements TrainingCategoryFinderInterface
{
    public function __construct(
        private Connection $connection
    )
    {
    }

    public function find(TrainingCategoryId $id): TrainingCategoryEntity
    {
        $qb = $this->connection->createQueryBuilder();
        $row = $qb
            ->select('*')
            ->from('training_categories', 'tc')
            ->executeQuery()
            ->fetchAssociative()
        ;
        return $this->createTrainingCategoryFromRow($row);
    }

    public function findAll(): array
    {
        $qb = $this->connection->createQueryBuilder();
        $rows = $qb
            ->select('*')
            ->from('training_categories', 'tc')
            ->executeQuery()
            ->fetchAllAssociative()
        ;
        return array_map(
            fn (array $row) => $this->createTrainingCategoryFromRow($row),
            $rows
        );
    }

    private function createTrainingCategoryFromRow(array $row): TrainingCategoryEntity
    {
        return new TrainingCategoryEntity(
            TrainingCategoryId::fromString($row['id']),
            $row['name'],
            new DateTimeImmutable($row['created_at']),
            new DateTimeImmutable($row['updated_at']),
        );
    }
}
