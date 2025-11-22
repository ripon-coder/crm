<?php

namespace App\Filament\Resources\Customers\Schemas;

use Filament\Schemas\Schema;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;

class CustomerForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                TextInput::make('phone')
                    ->maxLength(255),
                TextInput::make('email')
                    ->email()
                    ->maxLength(255),
                Textarea::make('address')
                    ->maxLength(65535)
                    ->columnSpanFull(),
                TextInput::make('national_id')
                    ->maxLength(255),
                Textarea::make('notes')
                    ->maxLength(65535)
                    ->columnSpanFull(),
            ]);
    }
}
