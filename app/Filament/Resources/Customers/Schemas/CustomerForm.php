<?php

namespace App\Filament\Resources\Customers\Schemas;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class CustomerForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([

            Section::make('Customer Information')
                ->schema([
                    TextInput::make('name')
                        ->label('Customer Name')
                        ->required()
                        ->maxLength(255),

                    TextInput::make('phone')
                        ->label('Phone Number')
                        ->maxLength(255)
                        ->unique(table: 'customers', column: 'phone', ignoreRecord: true),

                    TextInput::make('email')
                        ->label('Email Address')
                        ->email()
                        ->maxLength(255)
                        ->unique(table: 'customers', column: 'email', ignoreRecord: true),

                    TextInput::make('national_id')
                        ->label('National ID')
                        ->maxLength(255),

                    TextInput::make('dollar_rate')
                        ->label('Dollar Rate')
                        ->numeric()
                        ->step(0.01),

                    Toggle::make('is_active')
                        ->label('Is Active')
                        ->default(true),
                ])
                ->columns(2),

            Section::make('Additional Details')
                ->schema([
                    Textarea::make('address')
                        ->label('Address')
                        ->rows(3)
                        ->maxLength(65535)
                        ->columnSpanFull(),

                    Textarea::make('notes')
                        ->label('Notes')
                        ->rows(3)
                        ->maxLength(65535)
                        ->columnSpanFull(),
                ])
                ->columns(1),

        ])->columns(1);
    }
}
