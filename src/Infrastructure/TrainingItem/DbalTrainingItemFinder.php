<?php

declare(strict_types=1);

namespace App\Infrastructure\TrainingItem;

use App\Domain\TrainingCategory\ValueObject\TrainingCategoryId;
use App\Domain\TrainingItem\TrainingItemEntity;
use App\Domain\TrainingItem\TrainingItemFinderInterface;
use App\Domain\TrainingItem\ValueObject\TrainingItemId;
use DateTimeImmutable;
use Doctrine\DBAL\Connection;

final readonly class DbalTrainingItemFinder implements TrainingItemFinderInterface
{
    public function __construct(
        private Connection $connection
    ) {
    }

    public function find(TrainingItemId $id): TrainingItemEntity
    {
        $qb = $this->connection->createQueryBuilder();
        $row = $qb
            ->select('*')
            ->from('training_items', 'tc')
            ->executeQuery()
            ->fetchAssociative()
        ;

        return $this->createTrainingItemFromRow($row);
    }

    public function findAll(): array
    {
        $qb = $this->connection->createQueryBuilder();
        $rows = $qb
            ->select('*')
            ->from('training_items', 'tc')
            ->executeQuery()
            ->fetchAllAssociative()
        ;

        return array_map(
            fn (array $row) => $this->createTrainingItemFromRow($row),
            $rows
        );
    }

    private function createTrainingItemFromRow(array $row): TrainingItemEntity
    {
        return new TrainingItemEntity(
            TrainingItemId::fromString($row['id']),
            $row['name'],
            $row['is_dangerous'],
            TrainingCategoryId::fromString($row['training_category_id']),
            new DateTimeImmutable($row['created_at']),
            new DateTimeImmutable($row['updated_at']),
        );
    }
}
