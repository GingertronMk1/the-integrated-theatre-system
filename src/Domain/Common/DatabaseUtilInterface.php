<?php

declare(strict_types=1);

namespace App\Domain\Common;

interface DatabaseUtilInterface
{
    public function truncateAllTables(): void;
}
