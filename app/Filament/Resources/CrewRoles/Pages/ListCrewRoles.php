<?php

namespace App\Filament\Resources\CrewRoles\Pages;

use App\Filament\Resources\CrewRoles\CrewRoleResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListCrewRoles extends ListRecords
{
    protected static string $resource = CrewRoleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
