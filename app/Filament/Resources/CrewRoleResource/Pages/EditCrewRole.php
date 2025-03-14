<?php

namespace App\Filament\Resources\CrewRoleResource\Pages;

use App\Filament\Resources\CrewRoleResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCrewRole extends EditRecord
{
    protected static string $resource = CrewRoleResource::class;

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
