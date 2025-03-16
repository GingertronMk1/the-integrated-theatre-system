<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ShowResource\Pages;
use App\Filament\Resources\ShowResource\RelationManagers\CastMembersRelationManager;
use App\Filament\Resources\ShowResource\RelationManagers\CrewMembersRelationManager;
use App\Models\Show;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ShowResource extends Resource
{
    protected static ?string $model = Show::class;

    protected static ?string $navigationIcon = 'heroicon-o-film';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('title'),
                Textarea::make('blurb')
                    ->rows(10)
                    ->columnSpan('full'),
                Select::make('season_id')
                    ->relationship('season', 'name')
                    ->createOptionForm(SeasonResource::form($form)->getFlatComponents())
                    ->columnSpan(2),
                Select::make('playwright_id')
                    ->relationship('playwright', 'name')
                    ->createOptionForm(PlaywrightResource::form($form)->getFlatComponents())
                    ->columnSpan(2),
                Select::make('venue_id')
                    ->relationship('venue', 'name')
                    ->createOptionForm(VenueResource::form($form)->getFlatComponents())
                    ->columnSpan(2),
                TextInput::make('year')
                    ->numeric()
                    ->minValue(0)
                    ->step(1),
                TextInput::make('legacy_link'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('year')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('season.name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('playwright.name')
                    ->searchable()
                    ->sortable(),

            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            CastMembersRelationManager::class,
            CrewMembersRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListShows::route('/'),
            'create' => Pages\CreateShow::route('/create'),
            'view' => Pages\ViewShow::route('/{record}'),
            'edit' => Pages\EditShow::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
