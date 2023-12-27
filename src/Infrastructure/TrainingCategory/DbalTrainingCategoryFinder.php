<?php

declare(strict_types=1);

namespace App\Infrastructure\TrainingCategory;

use App\Application\TrainingCategory\TrainingCategoryFinderInterface;
use App\Application\TrainingCategory\TrainingCategoryModel;
use App\Domain\TrainingCategory\ValueObject\TrainingCategoryId;
use DateTimeImmutable;
use Doctrine\DBAL\Connection;
use Exception;

final readonly class DbalTrainingCategoryFinder implements TrainingCategoryFinderInterface
{
    public function __construct(
        private Connection $connection
    ) {
    }

    public function find(TrainingCategoryId $id): TrainingCategoryModel
    {
        $qb = $this->connection->createQueryBuilder();
        $row = $qb
            ->select('*')
            ->from('training_categories', 'tc')
            ->executeQuery()
            ->fetchAssociative()
        ;

        if (!is_array($row)) {
            throw new Exception("No category found with ID {$id}");
        }

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

    /**
     * @param array<string, mixed> $row
     */
    private function createTrainingCategoryFromRow(array $row): TrainingCategoryModel
    {
        return new TrainingCategoryModel(
            TrainingCategoryId::fromString($row['id']),
            $row['name'],
            new DateTimeImmutable($row['created_at']),
            new DateTimeImmutable($row['updated_at']),
        );
    }
}
