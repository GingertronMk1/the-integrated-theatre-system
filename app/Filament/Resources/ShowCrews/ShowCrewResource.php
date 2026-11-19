<?php

namespace App\Filament\Resources\ShowCrews;

use App\Filament\Resources\ShowCrews\Pages\ManageShowCrews;
use App\Models\ShowCrew;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ShowCrewResource extends Resource
{
    protected static ?string $model = ShowCrew::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('show_id')->relationship('show', 'name')->searchable()->required(),
                Select::make('person_id')->relationship('person', 'name')->searchable()->required(),
                Select::make('role_id')->relationship('role', 'name')->searchable()->required(),
                Textarea::make('notes'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('show.name'),
                TextColumn::make('person.name'),
                TextColumn::make('role.name'),
                TextColumn::make('notes'),
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
            'index' => ManageShowCrews::route('/'),
        ];
    }
}
