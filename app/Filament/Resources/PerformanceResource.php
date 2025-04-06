<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PerformanceResource\Pages;
use App\Models\Performance;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PerformanceResource extends Resource
{
    protected static ?string $model = Performance::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Shows';

    protected static ?int $navigationSort = 5;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\DatePicker::make('show_date'),
                Forms\Components\TimePicker::make('curtains')
                    ->seconds(false),
                Select::make('show_id')
                    ->relationship('show', 'title')
                    ->columnSpan(2),
                Select::make('venue_id')
                    ->relationship('venue', 'name')
                    ->createOptionForm(VenueResource::form($form)->getFlatComponents())
                    ->columnSpan(2),
                Textarea::make('notes')
                    ->columnSpan('full'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('show_date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('curtains')
                    ->time()
                    ->sortable(),
                Tables\Columns\TextColumn::make('venue.name')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('show.title')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('show.season.name')
                    ->sortable()
                    ->searchable(),
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPerformances::route('/'),
            'create' => Pages\CreatePerformance::route('/create'),
            'view' => Pages\ViewPerformance::route('/{record}'),
            'edit' => Pages\EditPerformance::route('/{record}/edit'),
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
