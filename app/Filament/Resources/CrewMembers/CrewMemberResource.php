<?php

namespace App\Filament\Resources\CrewMembers;

use App\Filament\Resources\CrewMembers\Pages\CreateCrewMember;
use App\Filament\Resources\CrewMembers\Pages\EditCrewMember;
use App\Filament\Resources\CrewMembers\Pages\ListCrewMembers;
use App\Filament\Resources\CrewMembers\Pages\ViewCrewMember;
use App\Filament\Resources\CrewMembers\Schemas\CrewMemberForm;
use App\Filament\Resources\CrewMembers\Schemas\CrewMemberInfolist;
use App\Filament\Resources\CrewMembers\Tables\CrewMembersTable;
use App\Models\CrewMember;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CrewMemberResource extends Resource
{
    protected static ?string $model = CrewMember::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return CrewMemberForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return CrewMemberInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CrewMembersTable::configure($table);
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
            'index' => ListCrewMembers::route('/'),
            'create' => CreateCrewMember::route('/create'),
            'view' => ViewCrewMember::route('/{record}'),
            'edit' => EditCrewMember::route('/{record}/edit'),
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
