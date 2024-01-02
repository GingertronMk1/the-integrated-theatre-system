<?php

declare(strict_types=1);

namespace App\Infrastructure\Show;

use App\Application\Common\Service\ClockInterface;
use App\Domain\Show\ShowRepositoryInterface;
use Doctrine\DBAL\Connection;

final readonly class DbalShowRepository implements ShowRepositoryInterface
{
    public function __construct(
        private Connection $connection,
        private ClockInterface $clock
    ) {
    }
}
