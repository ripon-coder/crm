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
                    ->disabled(fn (?string $operation, $record) => $operation === 'edit' && $record?->dollarSales()->exists())
                    ->dehydrated()
                    ->helperText(fn ($record) => $record?->dollarSales()->exists() 
                        ? '⚠️ Cannot edit: This batch has existing sales' 
                        : null),
                \Filament\Forms\Components\TextInput::make('rate')
                    ->required()
                    ->numeric()
                    ->disabled(fn (?string $operation, $record) => $operation === 'edit' && $record?->dollarSales()->exists())
                    ->dehydrated()
                    ->helperText(fn ($record) => $record?->dollarSales()->exists() 
                        ? '⚠️ Cannot edit: This batch has existing sales' 
                        : null),
                \Filament\Forms\Components\Toggle::make('is_active')
                    ->label('Is Active')
                    ->default(true),
                \Filament\Forms\Components\Textarea::make('notes')
                    ->maxLength(65535)
                    ->columnSpanFull(),
            ]);
    }
}
