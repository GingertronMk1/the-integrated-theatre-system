<?php

declare(strict_types=1);

namespace App\Infrastructure\Show;

use App\Application\CastMember\CastMemberFinderInterface;
use App\Application\CrewMember\CrewMemberFinderInterface;
use App\Application\Season\SeasonFinderInterface;
use App\Application\Show\ShowFinderInterface;
use App\Application\Show\ShowModel;
use App\Domain\Common\ValueObject\DateTime;
use App\Domain\Season\ValueObject\SeasonId;
use App\Domain\Show\ShowException;
use App\Domain\Show\ValueObject\ShowId;
use App\Infrastructure\Common\AbstractDbalFinder;
use Doctrine\DBAL\Connection;

final class DbalShowFinder extends AbstractDbalFinder implements ShowFinderInterface
{
    public function __construct(
        private Connection $connection,
        private SeasonFinderInterface $seasonFinder,
        private CastMemberFinderInterface $castMemberFinder,
        private CrewMemberFinderInterface $crewMemberFinder
    ) {
    }

    /**
     * @return array<ShowModel>
     */
    public function findAll(int $offset = null, int $limit = null): array
    {
        return $this->_findAll($this->connection, $offset, $limit);
    }

    public function find(ShowId $id): ShowModel
    {
        $qb = $this->connection->createQueryBuilder();
        $row = $qb
            ->select('*')
            ->from($this->getTable())
            ->where('id = :id')
            ->andWhere('deleted_at IS NULL')
            ->setParameter('id', (string) $id)
            ->fetchAssociative();

        if (!is_array($row)) {
            throw ShowException::notFound($id);
        }

        return $this->createFromRow($row);
    }

    /**
     * @param array<string, ?string> $row
     */
    protected function createFromRow(array $row): ShowModel
    {
        $deletedAt = null;
        if (!is_null($row['deleted_at'])) {
            $deletedAt = DateTime::fromString($row['deleted_at']);
        }

        $season = null;
        if (!is_null($row['season_id'])) {
            $season = $this->seasonFinder->find(SeasonId::fromString($row['season_id']));
        }
        $showId = ShowId::fromString($row['id']);

        return new ShowModel(
            $showId,
            $row['name'],
            $row['description'],
            $row['year'],
            $season,
            $this->castMemberFinder->findForShow($showId),
            $this->crewMemberFinder->findForShow($showId),
            DateTime::fromString($row['created_at']),
            DateTime::fromString($row['updated_at']),
            $deletedAt,
        );
    }

    protected function getTable(): string
    {
        return 'shows';
    }

    public function count(ShowId $id = null): int
    {
        return $this->_count($this->connection, $id);
    }
}
