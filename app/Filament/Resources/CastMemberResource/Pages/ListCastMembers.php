<?php

namespace App\Filament\Resources\CastMemberResource\Pages;

use App\Filament\Resources\CastMemberResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCastMembers extends ListRecords
{
    protected static string $resource = CastMemberResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
