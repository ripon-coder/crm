<?php

namespace App\Filament\Resources\Vendors\Schemas;

use Filament\Schemas\Schema;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;

class VendorForm
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
                TextInput::make('payment_method')
                    ->maxLength(255),
                TextInput::make('account_no')
                    ->maxLength(255),
                TextInput::make('default_rate')
                    ->numeric(),
                Textarea::make('notes')
                    ->maxLength(65535)
                    ->columnSpanFull(),
            ]);
    }
}
