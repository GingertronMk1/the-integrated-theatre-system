<?php

declare(strict_types=1);

namespace App\Infrastructure\TrainingItem;

use App\Application\TrainingItem\TrainingItemFinderInterface;
use App\Application\TrainingItem\TrainingItemModel;
use App\Domain\Common\ValueObject\DateTime;
use App\Domain\TrainingCategory\ValueObject\TrainingCategoryId;
use App\Domain\TrainingItem\TrainingItemException;
use App\Domain\TrainingItem\ValueObject\TrainingItemId;
use App\Infrastructure\Common\AbstractDbalFinder;
use Doctrine\DBAL\Connection;

final class DbalTrainingItemFinder extends AbstractDbalFinder implements TrainingItemFinderInterface
{
    public function __construct(
        private Connection $connection
    ) {
    }

    public function find(TrainingItemId $id): TrainingItemModel
    {
        return $this->findByColumn('id', (string) $id);
    }

    public function findAll(array $ids = [], int $offset = null, int $limit = null): array
    {
        return $this->_findAll($this->connection, $offset, $limit);
    }

    public function findByName(string $name): TrainingItemModel
    {
        return $this->findByColumn('name', $name);
    }

    private function findByColumn(string $column, string $value): TrainingItemModel
    {
        $qb = $this->connection->createQueryBuilder();
        $row = $qb
            ->select('*')
            ->from($this->getTable())
            ->where("{$column} = :value")
            ->setParameter('value', $value)
            ->executeQuery()
            ->fetchAssociative()
        ;

        if (!is_array($row)) {
            throw TrainingItemException::notFoundWithColumn($column, $value);
        }

        return $this->createFromRow($row);
    }

    /**
     * @param array<string, mixed> $row
     */
    private function createFromRow(array $row): TrainingItemModel
    {
        return new TrainingItemModel(
            TrainingItemId::fromString($row['id']),
            $row['name'],
            $row['is_dangerous'],
            TrainingCategoryId::fromString($row['training_category_id']),
            DateTime::fromString($row['created_at']),
            DateTime::fromString($row['updated_at']),
        );
    }

    protected function getTable(): string
    {
        return 'training_items';
    }

    public function count(TrainingItemId $id = null): int
    {
        return $this->_count($this->connection, $id);
    }
}
