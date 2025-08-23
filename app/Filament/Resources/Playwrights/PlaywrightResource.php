<?php

namespace App\Filament\Resources\Playwrights;

use App\Filament\Resources\Playwrights\Pages\CreatePlaywright;
use App\Filament\Resources\Playwrights\Pages\EditPlaywright;
use App\Filament\Resources\Playwrights\Pages\ListPlaywrights;
use App\Filament\Resources\Playwrights\Pages\ViewPlaywright;
use App\Filament\Resources\Playwrights\Schemas\PlaywrightForm;
use App\Filament\Resources\Playwrights\Schemas\PlaywrightInfolist;
use App\Filament\Resources\Playwrights\Tables\PlaywrightsTable;
use App\Models\Playwright;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PlaywrightResource extends Resource
{
    protected static ?string $model = Playwright::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return PlaywrightForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return PlaywrightInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PlaywrightsTable::configure($table);
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
            'index' => ListPlaywrights::route('/'),
            'create' => CreatePlaywright::route('/create'),
            'view' => ViewPlaywright::route('/{record}'),
            'edit' => EditPlaywright::route('/{record}/edit'),
        ];
    }

    public static function getRecordRouteBindingEloquentQuery(): Builder
    {
        return parent::getRecordRouteBindingEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
