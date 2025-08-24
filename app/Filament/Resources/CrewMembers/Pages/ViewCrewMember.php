<?php

namespace App\Filament\Resources\CrewMembers\Pages;

use App\Filament\Resources\CrewMembers\CrewMemberResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewCrewMember extends ViewRecord
{
    protected static string $resource = CrewMemberResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
