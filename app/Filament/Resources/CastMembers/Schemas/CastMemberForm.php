<?php

namespace App\Filament\Resources\CastMembers\Schemas;

use App\Models\Person;
use App\Models\Show;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class CastMemberForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('person_id')
                    ->options(Person::query()->pluck('name', 'id'))
                    ->required(),
                Select::make('show_id')
                    ->options(Show::query()->pluck('title', 'id'))
                    ->required(),
                TextInput::make('role')
                    ->required(),
            ]);
    }
}
