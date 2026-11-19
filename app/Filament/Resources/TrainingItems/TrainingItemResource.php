<?php

namespace App\Filament\Resources\TrainingItems;

use App\Filament\Resources\TrainingItems\Pages\CreateTrainingItem;
use App\Filament\Resources\TrainingItems\Pages\EditTrainingItem;
use App\Filament\Resources\TrainingItems\Pages\ListTrainingItems;
use App\Models\TrainingItem;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class TrainingItemResource extends Resource
{
    protected static ?string $model = TrainingItem::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')->required(),
                Select::make('training_category_id')->relationship('trainingCategory', 'name')->searchable()->required(),
                Toggle::make('dangerous'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name'),
                TextColumn::make('trainingCategory.name'),
                TextColumn::make('dangerous'),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\SessionsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListTrainingItems::route('/'),
            'create' => CreateTrainingItem::route('/create'),
            'edit' => EditTrainingItem::route('/{record}/edit'),
        ];
    }
}
