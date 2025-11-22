<?php

namespace App\Filament\Resources\DollarSales\Schemas;

use Filament\Schemas\Schema;

class DollarSaleForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                \Filament\Forms\Components\Select::make('batch_id')
                    ->relationship('batch', 'id')
                    ->required(),
                \Filament\Forms\Components\Select::make('customer_id')
                    ->relationship('customer', 'name')
                    ->required()
                    ->searchable(),
                \Filament\Forms\Components\TextInput::make('amount')
                    ->required()
                    ->numeric(),
                \Filament\Forms\Components\TextInput::make('rate')
                    ->required()
                    ->numeric(),
                \Filament\Forms\Components\TextInput::make('total_price')
                    ->numeric()
                    ->disabled()
                    ->dehydrated(false), // Not saved directly from form, calculated in model
                \Filament\Forms\Components\TextInput::make('profit')
                    ->numeric()
                    ->disabled()
                    ->dehydrated(false),
                \Filament\Forms\Components\Textarea::make('notes')
                    ->maxLength(65535)
                    ->columnSpanFull(),
            ]);
    }
}
