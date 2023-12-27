<?php

declare(strict_types=1);

namespace App\Application\Fixtures;

abstract class AbstractFixture  
{
    abstract public function load(): void;

    abstract public function getAllFixtures(): array;
}
