<?php

namespace App\Filament\Resources\CastMembers;

use App\Filament\Resources\CastMembers\Pages\CreateCastMember;
use App\Filament\Resources\CastMembers\Pages\EditCastMember;
use App\Filament\Resources\CastMembers\Pages\ListCastMembers;
use App\Filament\Resources\CastMembers\Pages\ViewCastMember;
use App\Filament\Resources\CastMembers\Schemas\CastMemberForm;
use App\Filament\Resources\CastMembers\Schemas\CastMemberInfolist;
use App\Filament\Resources\CastMembers\Tables\CastMembersTable;
use App\Models\CastMember;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CastMemberResource extends Resource
{
    protected static ?string $model = CastMember::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'role';

    public static function form(Schema $schema): Schema
    {
        return CastMemberForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return CastMemberInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CastMembersTable::configure($table);
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
            'index' => ListCastMembers::route('/'),
            'create' => CreateCastMember::route('/create'),
            'view' => ViewCastMember::route('/{record}'),
            'edit' => EditCastMember::route('/{record}/edit'),
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
