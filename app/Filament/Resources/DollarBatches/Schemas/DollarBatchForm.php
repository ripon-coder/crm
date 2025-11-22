<?php

namespace App\Filament\Resources\DollarBatches\Schemas;

use Filament\Schemas\Schema;

class DollarBatchForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                \Filament\Forms\Components\Select::make('vendor_id')
                    ->relationship('vendor', 'name')
                    ->required(),
                \Filament\Forms\Components\TextInput::make('dollar_amount')
                    ->required()
                    ->numeric()
                    ->disabled(fn ($record) => $record && $record->dollarSales()->exists()), // Prevent edit if sales exist
                \Filament\Forms\Components\TextInput::make('rate')
                    ->required()
                    ->numeric(),
                \Filament\Forms\Components\Textarea::make('notes')
                    ->maxLength(65535)
                    ->columnSpanFull(),
            ]);
    }
}
