<?php

declare(strict_types=1);

namespace App\Application\Fixtures;

interface FixtureLoaderInterface  
{
    public function loadFixtures(string ...$fixtures): void;
}
