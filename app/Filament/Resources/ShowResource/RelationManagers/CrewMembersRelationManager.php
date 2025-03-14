<?php

namespace App\Filament\Resources\ShowResource\RelationManagers;

use App\Filament\Resources\CrewMemberResource;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class CrewMembersRelationManager extends RelationManager
{
    protected static string $relationship = 'crewMembers';

    public function form(Form $form): Form
    {
        $schema = CrewMemberResource::form($form)->getComponents();
        $schema = array_filter(
            $schema,
            fn (Forms\Components\Component $component) => $component instanceof Forms\Components\Field && $component->getName() !== 'show_id'
        );

        return $form
            ->schema($schema);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('crewRole.name')
            ->columns([
                Tables\Columns\TextColumn::make('crewRole.name'),
                Tables\Columns\TextColumn::make('person.name'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
