<?php

namespace App\Filament\Resources\Playwrights\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class PlaywrightForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')->required(),
                TextInput::make('bio'),
            ]);
    }
}
