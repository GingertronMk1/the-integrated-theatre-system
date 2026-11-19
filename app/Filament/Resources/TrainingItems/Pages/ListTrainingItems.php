<?php

namespace App\Filament\Resources\TrainingItems\Pages;

use App\Filament\Resources\TrainingItems\TrainingItemResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListTrainingItems extends ListRecords
{
    protected static string $resource = TrainingItemResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
