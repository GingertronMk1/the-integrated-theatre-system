<?php

namespace App\Filament\Resources\Shows\RelationManagers;

use App\Filament\Resources\CastMembers\CastMemberResource;
use Filament\Actions\CreateAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Table;

class CastMembersRelationManager extends RelationManager
{
    protected static string $relationship = 'castMembers';

    protected static ?string $relatedResource = CastMemberResource::class;

    public function table(Table $table): Table
    {
        return $table
            ->headerActions([
                CreateAction::make(),
            ]);
    }
}
