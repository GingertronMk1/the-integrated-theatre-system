<?php

declare(strict_types=1);

namespace App\Application\Fixtures;

abstract class AbstractFixture
{
    abstract public function load(): void;

    public function getDependencies(): array
    {
        return [];
    }
}
