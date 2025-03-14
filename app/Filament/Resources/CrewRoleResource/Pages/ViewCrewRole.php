<?php

namespace App\Filament\Resources\CrewRoleResource\Pages;

use App\Filament\Resources\CrewRoleResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewCrewRole extends ViewRecord
{
    protected static string $resource = CrewRoleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
