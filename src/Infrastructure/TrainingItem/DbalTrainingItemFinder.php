<?php

declare(strict_types=1);

namespace App\Infrastructure\TrainingItem;

use App\Application\TrainingItem\TrainingItemFinderInterface;
use App\Application\TrainingItem\TrainingItemModel;
use App\Domain\TrainingCategory\ValueObject\TrainingCategoryId;
use App\Domain\TrainingItem\ValueObject\TrainingItemId;
use DateTimeImmutable;
use Doctrine\DBAL\Connection;

final readonly class DbalTrainingItemFinder implements TrainingItemFinderInterface
{
    public function __construct(
        private Connection $connection
    ) {
    }

    public function find(TrainingItemId $id): TrainingItemModel
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

    /**
     * @param array<string, mixed> $row
     */
    private function createTrainingItemFromRow(array $row): TrainingItemModel
    {
        return new TrainingItemModel(
            TrainingItemId::fromString($row['id']),
            $row['name'],
            $row['is_dangerous'],
            TrainingCategoryId::fromString($row['training_category_id']),
            new DateTimeImmutable($row['created_at']),
            new DateTimeImmutable($row['updated_at']),
        );
    }
}
