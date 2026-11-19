<?php

namespace App\Filament\Resources\TrainingItems\Pages;

use App\Filament\Resources\TrainingItems\TrainingItemResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditTrainingItem extends EditRecord
{
    protected static string $resource = TrainingItemResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
