<?php

namespace App\Filament\Resources\Vendors\Schemas;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class VendorForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([

            Section::make('Vendor Information')
                ->schema([
                    TextInput::make('name')
                        ->label('Vendor Name')
                        ->required()
                        ->maxLength(255),

                    TextInput::make('phone')
                        ->label('Phone Number')
                        ->maxLength(255),

                    TextInput::make('email')
                        ->label('Email Address')
                        ->email()
                        ->maxLength(255),

                    TextInput::make('default_rate')
                        ->label('Default Rate (৳)')
                        ->numeric()
                        ->prefix('৳'),

                    Toggle::make('is_active')
                        ->label('Is Active')
                        ->default(true),
                ])
                ->columns(2),

            Section::make('Payment Details')
                ->schema([
                    TextInput::make('payment_method')
                        ->label('Payment Method')
                        ->maxLength(255),

                    TextInput::make('account_no')
                        ->label('Account Number')
                        ->maxLength(255),
                ])
                ->columns(2),

            Section::make('Additional Details')
                ->schema([
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
