<?php

declare(strict_types=1);

namespace App\Infrastructure\Common;

use Doctrine\DBAL\Query\QueryBuilder;
use Stringable;

abstract class AbstractDbalService
{
    abstract protected function getTable(): string;

    /**
     * @param array<Stringable> $in
     */
    protected function columnInArray(QueryBuilder $qb, string $column, array $in): string
    {
        return $qb->expr()->in(
            $column,
            array_map(fn (Stringable $item) => "'{$item}'", $in)
        );
    }
}
