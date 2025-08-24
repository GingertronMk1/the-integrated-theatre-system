<?php

namespace App\Filament\Resources\CrewMembers\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class CrewMemberForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('crew_role_id')
                    ->required(),
                Select::make('person_id')
                    ->relationship('person', 'name')
                    ->required(),
                Select::make('show_id')
                    ->relationship('show', 'title')
                    ->required(),
                Textarea::make('notes')
                    ->columnSpanFull(),
            ]);
    }
}
