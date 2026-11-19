<?php

namespace App\Filament\Resources\Playwrights\Pages;

use App\Filament\Resources\Playwrights\PlaywrightResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListPlaywrights extends ListRecords
{
    protected static string $resource = PlaywrightResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
