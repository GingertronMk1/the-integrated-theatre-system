<?php

declare(strict_types=1);

namespace App\Infrastructure\Show;

use App\Application\Season\SeasonFinderInterface;
use App\Application\Show\ShowFinderInterface;
use App\Application\Show\ShowModel;
use App\Domain\Common\ValueObject\DateTime;
use App\Domain\Season\ValueObject\SeasonId;
use App\Domain\Show\ShowException;
use App\Domain\Show\ValueObject\ShowId;
use Doctrine\DBAL\Connection;

final readonly class DbalShowFinder implements ShowFinderInterface
{
    public function __construct(
        private Connection $connection,
        private SeasonFinderInterface $seasonFinder
    ) {
    }

    /**
     * @return array<ShowModel>
     */
    public function findAll(): array
    {
        $qb = $this->connection->createQueryBuilder();
        $rows = $qb
            ->select('*')
            ->from('shows')
            ->where('deleted_at IS NULL')
            ->fetchAllAssociative();

        return array_map(fn (array $row) => $this->createShowFromRow($row), $rows);
    }

    public function find(ShowId $id): ShowModel
    {
        $qb = $this->connection->createQueryBuilder();
        $row = $qb
            ->select('*')
            ->from('shows')
            ->where('id = :id')
            ->andWhere('deleted_at IS NULL')
            ->setParameter('id', (string) $id)
            ->fetchAssociative();

        if (!is_array($row)) {
            throw ShowException::notFound($id);
        }

        return $this->createShowFromRow($row);
    }

    /**
     * @param array<string, ?string> $row
     */
    public function createShowFromRow(array $row): ShowModel
    {
        $deletedAt = null;
        if (!is_null($row['deleted_at'])) {
            $deletedAt = DateTime::fromString($row['deleted_at']);
        }

        $season = null;
        if (!is_null($row['season_id'])) {
            $season = $this->seasonFinder->find(SeasonId::fromString($row['season_id']));
        }

        return new ShowModel(
            ShowId::fromString($row['id']),
            $row['name'],
            $row['description'],
            $row['year'], $season,
            DateTime::fromString($row['created_at']),
            DateTime::fromString($row['updated_at']),
            $deletedAt,
        );
    }
}
