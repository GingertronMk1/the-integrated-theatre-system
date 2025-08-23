<?php

namespace App\Filament\Resources\People\Schemas;

use App\Models\User;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class PersonForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                Textarea::make('bio')
                    ->columnSpanFull(),
                Select::make('user_id')->label('User')->options(User::query()->pluck('name', 'id')),
            ]);
    }
}
