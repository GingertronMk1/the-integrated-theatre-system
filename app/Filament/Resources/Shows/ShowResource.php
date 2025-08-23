<?php

namespace App\Filament\Resources\Shows;

use App\Filament\Resources\Shows\Pages\CreateShow;
use App\Filament\Resources\Shows\Pages\EditShow;
use App\Filament\Resources\Shows\Pages\ListShows;
use App\Filament\Resources\Shows\Pages\ViewShow;
use App\Filament\Resources\Shows\RelationManagers\CastMembersRelationManager;
use App\Filament\Resources\Shows\Schemas\ShowForm;
use App\Filament\Resources\Shows\Schemas\ShowInfolist;
use App\Filament\Resources\Shows\Tables\ShowsTable;
use App\Models\Show;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ShowResource extends Resource
{
    protected static ?string $model = Show::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Schema $schema): Schema
    {
        return ShowForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return ShowInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ShowsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            CastMembersRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListShows::route('/'),
            'create' => CreateShow::route('/create'),
            'view' => ViewShow::route('/{record}'),
            'edit' => EditShow::route('/{record}/edit'),
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
