<?php

namespace App\Filament\Resources\CrewRoles;

use App\Filament\Resources\CrewRoles\Pages\CreateCrewRole;
use App\Filament\Resources\CrewRoles\Pages\EditCrewRole;
use App\Filament\Resources\CrewRoles\Pages\ListCrewRoles;
use App\Filament\Resources\CrewRoles\Pages\ViewCrewRole;
use App\Filament\Resources\CrewRoles\Schemas\CrewRoleForm;
use App\Filament\Resources\CrewRoles\Schemas\CrewRoleInfolist;
use App\Filament\Resources\CrewRoles\Tables\CrewRolesTable;
use App\Models\CrewRole;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CrewRoleResource extends Resource
{
    protected static ?string $model = CrewRole::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return CrewRoleForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return CrewRoleInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CrewRolesTable::configure($table);
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
            'index' => ListCrewRoles::route('/'),
            'create' => CreateCrewRole::route('/create'),
            'view' => ViewCrewRole::route('/{record}'),
            'edit' => EditCrewRole::route('/{record}/edit'),
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
