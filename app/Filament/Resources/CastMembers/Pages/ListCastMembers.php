<?php

namespace App\Filament\Resources\CastMembers\Pages;

use App\Filament\Resources\CastMembers\CastMemberResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListCastMembers extends ListRecords
{
    protected static string $resource = CastMemberResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
