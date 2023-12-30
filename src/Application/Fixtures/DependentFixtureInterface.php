<?php

declare(strict_types=1);

namespace App\Application\Fixtures;

use Symfony\Component\DependencyInjection\Attribute\AutoconfigureTag;

#[AutoconfigureTag('app.fixture')]
interface DependentFixtureInterface
{
    /** @return array<int|string, string> */
    public function getDependencies(): array;
}
