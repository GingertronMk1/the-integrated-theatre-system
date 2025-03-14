<?php

namespace App\Filament\Resources\CastMemberResource\Pages;

use App\Filament\Resources\CastMemberResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCastMember extends EditRecord
{
    protected static string $resource = CastMemberResource::class;

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
