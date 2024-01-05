<?php

declare(strict_types=1);

namespace App\Infrastructure\Season;

use App\Application\Season\SeasonFinderInterface;
use App\Application\Season\SeasonModel;
use App\Domain\Common\ValueObject\Colour;
use App\Domain\Common\ValueObject\DateTime;
use App\Domain\Season\SeasonException;
use App\Domain\Season\ValueObject\SeasonId;
use Doctrine\DBAL\Connection;
use App\Infrastructure\Common\AbstractDbalFinder;

final readonly class DbalSeasonFinder  extends AbstractDbalFinder implements SeasonFinderInterface
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

    public function findAll(): array
    {
        $qb = $this->connection->createQueryBuilder();
        $rows = $qb
            ->select('*')
            ->from($this->getTable())
            ->fetchAllAssociative()
        ;

        return array_map(
            fn (array $row) => $this->createFromRow($row),
            $rows
        );
    }

    /**
     * @param array<string, mixed> $row
     */
    private function createFromRow(array $row): SeasonModel
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
}
