<?php

namespace App\Filament\Resources\Playwrights\Pages;

use App\Filament\Resources\Playwrights\PlaywrightResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewPlaywright extends ViewRecord
{
    protected static string $resource = PlaywrightResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
