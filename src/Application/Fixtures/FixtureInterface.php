<?php

declare(strict_types=1);

namespace App\Application\Fixtures;

interface FixtureInterface
{
    public function load(): void;
}
