<?php

namespace App\Filament\Resources\CastMembers\Pages;

use App\Filament\Resources\CastMembers\CastMemberResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewCastMember extends ViewRecord
{
    protected static string $resource = CastMemberResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
