<?php

namespace App\Filament\Resources\CrewMembers\Pages;

use App\Filament\Resources\CrewMembers\CrewMemberResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListCrewMembers extends ListRecords
{
    protected static string $resource = CrewMemberResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
