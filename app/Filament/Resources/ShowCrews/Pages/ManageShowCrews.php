<?php

namespace App\Filament\Resources\ShowCrews\Pages;

use App\Filament\Resources\ShowCrews\ShowCrewResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageShowCrews extends ManageRecords
{
    protected static string $resource = ShowCrewResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
