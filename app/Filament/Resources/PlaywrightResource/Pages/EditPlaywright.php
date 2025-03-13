<?php

namespace App\Filament\Resources\PlaywrightResource\Pages;

use App\Filament\Resources\PlaywrightResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPlaywright extends EditRecord
{
    protected static string $resource = PlaywrightResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
            Actions\ForceDeleteAction::make(),
            Actions\RestoreAction::make(),
        ];
    }
}
