<?php

namespace App\Filament\Resources\Shows\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class ShowForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->required(),
                Textarea::make('description')
                    ->columnSpanFull(),
                Select::make('playwright_id')
                    ->relationship('playwright', 'name')
                    ->required(),
                Select::make('season_id')
                    ->relationship('season', 'name')
                    ->required(),
                Select::make('venue_id')
                    ->relationship('venue', 'name')
                    ->required(),
            ]);
    }
}
