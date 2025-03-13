<?php

namespace App\Filament\Resources\PlaywrightResource\Pages;

use App\Filament\Resources\PlaywrightResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPlaywrights extends ListRecords
{
    protected static string $resource = PlaywrightResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
