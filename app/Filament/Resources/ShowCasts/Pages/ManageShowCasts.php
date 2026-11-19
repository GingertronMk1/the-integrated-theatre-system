<?php

namespace App\Filament\Resources\ShowCasts\Pages;

use App\Filament\Resources\ShowCasts\ShowCastResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageShowCasts extends ManageRecords
{
    protected static string $resource = ShowCastResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
