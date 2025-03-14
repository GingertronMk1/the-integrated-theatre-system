<?php

namespace App\Filament\Widgets;

use App\Models\CastMember;
use App\Models\CrewMember;
use App\Models\CrewRole;
use App\Models\Person;
use App\Models\Playwright;
use App\Models\Season;
use App\Models\Show;
use Doctrine\Inflector\InflectorFactory;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Database\Eloquent\Model;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $inflector = InflectorFactory::create()->build();
        $return = [];
        foreach ($this->getClasses() as $class) {
            if (! ($class instanceof Model)) {
                continue;
            }

            $classBaseName = preg_replace('/.*\\\\(\w+$)/', '$1', $class);
            $classBaseName = preg_replace('/(?<!^)[A-Z]/', ' $0', $classBaseName);

            $return[] = Stat::make($inflector->pluralize($classBaseName), $class::query()->count());
        }

        return $return;
    }

    private function getClasses(): array
    {
        return [
            Show::class,
            Person::class,
            Playwright::class,
            Season::class,
            CrewRole::class,
            CrewMember::class,
            CastMember::class,
        ];
    }
}
