<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CrewMemberResource\Pages;
use App\Models\CrewMember;
use App\Models\Person;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CrewMemberResource extends Resource
{
    protected static ?string $model = CrewMember::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Cast & Crew';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('role_id')
                    ->relationship('role', 'name')
                    ->createOptionForm(CrewRoleResource::form($form)->getFlatComponents())
                    ->required(),
                Forms\Components\Select::make('person_id')
                    ->relationship('person', 'name')
                    ->createOptionForm(Person::form($form)->getFlatComponents())
                    ->required(),
                Forms\Components\Select::make('show_id')
                    ->relationship('show', 'name')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
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
            'index' => Pages\ListCrewMembers::route('/'),
            'create' => Pages\CreateCrewMember::route('/create'),
            'view' => Pages\ViewCrewMember::route('/{record}'),
            'edit' => Pages\EditCrewMember::route('/{record}/edit'),
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
