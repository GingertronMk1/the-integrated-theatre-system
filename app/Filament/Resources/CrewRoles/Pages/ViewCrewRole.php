<?php

namespace App\Filament\Resources\CrewRoles\Pages;

use App\Filament\Resources\CrewRoles\CrewRoleResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewCrewRole extends ViewRecord
{
    protected static string $resource = CrewRoleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
