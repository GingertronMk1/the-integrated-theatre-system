<?php

declare(strict_types=1);

namespace App\Application\Fixtures;

interface DependentFixtureInterface extends FixtureInterface
{
    /** @return array<int|string, string> */
    public function getDependencies(): array;
}
