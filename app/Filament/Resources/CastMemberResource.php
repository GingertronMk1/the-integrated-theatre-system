<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CastMemberResource\Pages;
use App\Models\CastMember;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CastMemberResource extends Resource
{
    protected static ?string $model = CastMember::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('show_id')
                    ->relationship('show', 'title')
                    ->required(),
                Forms\Components\Select::make('person_id')
                    ->relationship('person', 'name')
                    ->createOptionForm(PersonResource::form($form)->getFlatComponents())
                    ->required(),
                Forms\Components\TextInput::make('role_name')
                    ->required(),
                Forms\Components\Textarea::make('notes')
                    ->cols(5),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('show.title')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('person.name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('role_name')
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCastMembers::route('/'),
            'create' => Pages\CreateCastMember::route('/create'),
            'view' => Pages\ViewCastMember::route('/{record}'),
            'edit' => Pages\EditCastMember::route('/{record}/edit'),
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
