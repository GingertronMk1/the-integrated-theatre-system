<?php

declare(strict_types=1);

namespace App\Infrastructure\TrainingCategory;

use App\Application\TrainingCategory\TrainingCategoryFinderInterface;
use App\Application\TrainingCategory\TrainingCategoryModel;
use App\Domain\Common\ValueObject\DateTime;
use App\Domain\TrainingCategory\TrainingCategoryException;
use App\Domain\TrainingCategory\ValueObject\TrainingCategoryId;
use App\Infrastructure\Common\AbstractDbalFinder;
use Doctrine\DBAL\Connection;

final class DbalTrainingCategoryFinder extends AbstractDbalFinder implements TrainingCategoryFinderInterface
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
            ->from($this->getTable())
            ->fetchAssociative()
        ;

        if (!is_array($row)) {
            throw TrainingCategoryException::notFound($id);
        }

        return $this->createTrainingCategoryFromRow($row);
    }

    public function findAll(): array
    {
        $qb = $this->connection->createQueryBuilder();
        $rows = $qb
            ->select('*')
            ->from($this->getTable())
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
            DateTime::fromString($row['created_at']),
            DateTime::fromString($row['updated_at']),
        );
    }

    protected function getTable(): string
    {
        return 'training_categories';
    }

    public function count(TrainingCategoryId $id = null): int
    {
        return $this->_count($this->connection, $id);
    }
}
