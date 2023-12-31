<?php

declare(strict_types=1);

namespace App\Infrastructure\Common;

use App\Application\Common\Service\ClockInterface;
use App\Domain\Common\ValueObject\DateTime;
use DateTimeImmutable;

final class SystemClock implements ClockInterface
{
    public function getCurrentTime(): DateTime
    {
        return DateTime::fromDateTimeInterface(new DateTimeImmutable());
    }
}
