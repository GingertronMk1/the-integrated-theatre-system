<?php

declare(strict_types=1);

namespace App\Application\Fixtures;

interface DependantFixtureInterface extends FixtureInterface
{
    public function getDependencies(): array;
}
