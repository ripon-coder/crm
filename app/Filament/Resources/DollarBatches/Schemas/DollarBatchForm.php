<?php

namespace App\Filament\Resources\DollarBatches\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class DollarBatchForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([

            Section::make('Batch Details')
                ->schema([
                    Select::make('vendor_id')
                        ->label('Vendor')
                        ->relationship('vendor', 'name')
                        ->required()
                        ->preload(),

                    TextInput::make('dollar_amount')
                        ->label('Dollar Amount')
                        ->required()
                        ->numeric()
                        ->prefix('$')
                        ->disabled(fn (?string $operation, $record) => $operation === 'edit' && $record?->dollarSales()->exists())
                        ->dehydrated()
                        ->helperText(fn ($record) => $record?->dollarSales()->exists() 
                            ? '⚠️ Cannot edit: This batch has existing sales' 
                            : null),

                    TextInput::make('rate')
                        ->label('Purchase Rate (৳)')
                        ->required()
                        ->numeric()
                        ->prefix('৳')
                        ->disabled(fn (?string $operation, $record) => $operation === 'edit' && $record?->dollarSales()->exists())
                        ->dehydrated()
                        ->helperText(fn ($record) => $record?->dollarSales()->exists() 
                            ? '⚠️ Cannot edit: This batch has existing sales' 
                            : null),

                    Toggle::make('is_active')
                        ->label('Is Active')
                        ->default(true)
                        ->inline(false),
                ])
                ->columns(3),

            Section::make('Additional Information')
                ->schema([
                    Textarea::make('notes')
                        ->label('Notes')
                        ->rows(3)
                        ->maxLength(65535),
                ]),

        ])->columns(1);
    }
}
