<?php

declare(strict_types=1);

namespace App\Infrastructure\Season;

use App\Application\Season\SeasonFinderInterface;
use App\Application\Season\SeasonModel;
use App\Domain\Common\ValueObject\Colour;
use App\Domain\Common\ValueObject\DateTime;
use App\Domain\Season\SeasonException;
use App\Domain\Season\ValueObject\SeasonId;
use App\Infrastructure\Common\AbstractDbalFinder;
use Doctrine\DBAL\Connection;

final class DbalSeasonFinder extends AbstractDbalFinder implements SeasonFinderInterface
{
    public function __construct(
        private Connection $connection
    ) {
    }

    protected function getTable(): string
    {
        return 'seasons';
    }

    public function find(SeasonId $id): SeasonModel
    {
        $qb = $this->connection->createQueryBuilder();
        $row = $qb
            ->select('*')
            ->from($this->getTable())
            ->where('id = :id')
            ->setParameter('id', (string) $id)
            ->fetchAssociative();

        if (!is_array($row)) {
            throw new SeasonException("No row found with {$id}");
        }

        return $this->createFromRow($row);
    }

    public function findAll(?int $offset = null, ?int $limit = null): array
    {
        return $this->_findAll($this->connection, $offset, $limit);
    }

    /**
     * @param array<string, mixed> $row
     */
    protected function createFromRow(array $row): SeasonModel
    {
        $deletedAt = null;
        if (!is_null($row['deleted_at'])) {
            $deletedAt = DateTime::fromString($row['deleted_at']);
        }

        return new SeasonModel(
            SeasonId::fromString($row['id']),
            $row['name'],
            $row['description'],
            Colour::fromString($row['colour']),
            DateTime::fromString($row['created_at']),
            DateTime::fromString($row['updated_at']),
            $deletedAt,
        );
    }

    public function count(?SeasonId $id = null): int
    {
        return $this->_count($this->connection, $id);
    }
}
