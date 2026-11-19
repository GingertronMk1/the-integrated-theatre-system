<?php

namespace App\Filament\Resources\TrainingSessionPeople\Pages;

use App\Filament\Resources\TrainingSessionPeople\TrainingSessionPersonResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageTrainingSessionPeople extends ManageRecords
{
    protected static string $resource = TrainingSessionPersonResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
