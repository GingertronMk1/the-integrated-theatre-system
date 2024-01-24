<?php

declare(strict_types=1);

namespace App\Infrastructure\Common;

use App\Domain\Common\ValueObject\AbstractUuidId;
use Doctrine\DBAL\Connection;
use Exception;

abstract class AbstractDbalRepository extends AbstractDbalService
{
    protected function getCount(Connection $connection, AbstractUuidId $id): int
    {
        $qb = $connection->createQueryBuilder();
        $count = $qb
            ->select('COUNT(*)')
            ->from($this->getTable())
            ->where('id = :id')
            ->setParameter('id', (string) $id)
            ->fetchOne();
        if (false === $count) {
            throw new Exception('whoopsy');
        }

        return (int) $count;
    }

}
