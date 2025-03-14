<?php

namespace App\Filament\Resources\CastMemberResource\Pages;

use App\Filament\Resources\CastMemberResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewCastMember extends ViewRecord
{
    protected static string $resource = CastMemberResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
