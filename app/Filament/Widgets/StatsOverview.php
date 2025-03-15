<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\CastMemberResource;
use App\Filament\Resources\CrewMemberResource;
use App\Filament\Resources\CrewRoleResource;
use App\Filament\Resources\PersonResource;
use App\Filament\Resources\PlaywrightResource;
use App\Filament\Resources\SeasonResource;
use App\Filament\Resources\ShowResource;
use App\Filament\Resources\VenueResource;
use Doctrine\Inflector\InflectorFactory;
use Filament\Resources\Resource;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Database\Eloquent\Model;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $inflector = InflectorFactory::create()->build();
        $return = [];
        foreach ($this->getClasses() as $resource) {
            /**
             * @var class-string<resource> $resource
             * @var class-string<Model> $class
             */
            $class = $resource::getModel();
            $count = $class::query()->count();
            $label = $resource::getTitleCaseModelLabel();
            if ($count !== 1) {
                $label = $inflector->pluralize($label);
            }

            $return[] = Stat::make($label, $count)->url($resource::getUrl('index'));
        }

        return $return;
    }

    private function getClasses(): array
    {
        return [
            ShowResource::class,
            PersonResource::class,
            PlaywrightResource::class,
            SeasonResource::class,
            VenueResource::class,
            CrewRoleResource::class,
            CrewMemberResource::class,
            CastMemberResource::class,
        ];
    }
}
