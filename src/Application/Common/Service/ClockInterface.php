<?php

declare(strict_types=1);

namespace App\Application\Common\Service;

use App\Domain\Common\ValueObject\DateTime;

interface ClockInterface
{
    public function getCurrentTime(): DateTime;
}
