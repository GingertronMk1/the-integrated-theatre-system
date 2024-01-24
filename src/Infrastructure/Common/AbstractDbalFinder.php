<?php

declare(strict_types=1);

namespace App\Infrastructure\Common;

use App\Domain\Common\ValueObject\AbstractUuidId;
use Doctrine\DBAL\Connection;
use Exception;

abstract class AbstractDbalFinder extends AbstractDbalService
{
    abstract protected function getTable(): string;

    protected function _count(Connection $connection, AbstractUuidId $id = null): int
    {
        $qb = $connection->createQueryBuilder();
        $count = $qb
            ->select('COUNT(*)')
            ->from($this->getTable());

        if (!is_null($id)) {
            $count = $count
                ->where('id = :id')
                ->setParameter('id', (string) $id);
        }
        $count = $count->fetchOne();
        if (false === $count) {
            throw new Exception('whoopsy');
        }

        return (int) $count;
    }

    protected function _findAll(Connection $connection, int $offset = null, int $limit = null): array
    {
        $qb = $connection->createQueryBuilder();
        $rows = $qb
            ->select('*')
            ->from($this->getTable());

        if (!is_null($offset)) {
            $rows = $rows->setFirstResult($offset);
        }

        if (!is_null($limit)) {
            $rows = $rows->setMaxResults($limit);
        }

        $rows = $rows->fetchAllAssociative();

        return array_map(
            fn (array $row) => $this->createFromRow($row),
            $rows
        );
    }

    abstract protected function createFromRow(array $row): mixed;


}
