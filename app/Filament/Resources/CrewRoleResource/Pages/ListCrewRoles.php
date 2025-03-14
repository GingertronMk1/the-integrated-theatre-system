<?php

namespace App\Filament\Resources\CrewRoleResource\Pages;

use App\Filament\Resources\CrewRoleResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCrewRoles extends ListRecords
{
    protected static string $resource = CrewRoleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
