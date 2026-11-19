<?php

namespace App\Filament\Resources\TrainingSessionPeople;

use App\Filament\Resources\TrainingSessionPeople\Pages\ManageTrainingSessionPeople;
use App\Models\TrainingSessionPerson;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class TrainingSessionPersonResource extends Resource
{
    protected static ?string $model = TrainingSessionPerson::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('training_session_id')->relationship('trainingSession', 'id')->searchable()->required(),
                Select::make('person_id')->relationship('person', 'name')->searchable()->required(),
                Select::make('type')->options(['trainer' => 'Trainer', 'trainee' => 'Trainee'])->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('training_session_id'),
                TextColumn::make('person.name'),
                TextColumn::make('type'),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageTrainingSessionPeople::route('/'),
        ];
    }
}
