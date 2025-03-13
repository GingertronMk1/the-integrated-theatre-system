<?php

namespace App\Filament\Resources\CrewMemberResource\Pages;

use App\Filament\Resources\CrewMemberResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewCrewMember extends ViewRecord
{
    protected static string $resource = CrewMemberResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
