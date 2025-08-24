<?php

namespace App\Filament\Resources\Shows\RelationManagers;

use App\Filament\Resources\CrewMembers\CrewMemberResource;
use Filament\Actions\CreateAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Table;

class CrewMembersRelationManager extends RelationManager
{
    protected static string $relationship = 'crewMembers';

    protected static ?string $relatedResource = CrewMemberResource::class;

    public function table(Table $table): Table
    {
        return $table
            ->headerActions([
                CreateAction::make(),
            ]);
    }
}
