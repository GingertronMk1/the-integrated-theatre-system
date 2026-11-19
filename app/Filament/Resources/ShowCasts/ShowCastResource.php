<?php

namespace App\Filament\Resources\ShowCasts;

use App\Filament\Resources\ShowCasts\Pages\ManageShowCasts;
use App\Models\ShowCast;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ShowCastResource extends Resource
{
    protected static ?string $model = ShowCast::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('show_id')->relationship('show', 'name')->searchable()->required(),
                Select::make('person_id')->relationship('person', 'name')->searchable()->required(),
                TextInput::make('role_name')->required(),
                Textarea::make('notes'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('show.name'),
                TextColumn::make('person.name'),
                TextColumn::make('role_name'),
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
            'index' => ManageShowCasts::route('/'),
        ];
    }
}
