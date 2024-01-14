<?php

declare(strict_types=1);

namespace App\Application\Common;

use App\Domain\Common\ValueObject\AbstractUuidId;

interface AbstractCommandHandler
{
    public function handle(mixed $command): AbstractUuidId;
}
