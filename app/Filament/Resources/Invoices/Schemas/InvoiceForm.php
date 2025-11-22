<?php

namespace App\Filament\Resources\Invoices\Schemas;

use Filament\Schemas\Schema;

class InvoiceForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                \Filament\Forms\Components\TextInput::make('invoice_number')
                    ->disabled()
                    ->dehydrated(false)
                    ->placeholder('Auto-generated'),
                \Filament\Forms\Components\Select::make('customer_id')
                    ->relationship('customer', 'name')
                    ->required()
                    ->searchable(),
                \Filament\Forms\Components\TextInput::make('total_amount')
                    ->numeric()
                    ->disabled()
                    ->dehydrated(false),
                \Filament\Forms\Components\TextInput::make('total_price')
                    ->numeric()
                    ->disabled()
                    ->dehydrated(false),
                \Filament\Forms\Components\Select::make('payment_status')
                    ->options([
                        'unpaid' => 'Unpaid',
                        'partial' => 'Partial',
                        'paid' => 'Paid',
                    ])
                    ->disabled()
                    ->dehydrated(false),
                \Filament\Forms\Components\DateTimePicker::make('generated_at')
                    ->disabled()
                    ->dehydrated(false),
                \Filament\Forms\Components\Textarea::make('notes')
                    ->maxLength(65535)
                    ->columnSpanFull(),
            ]);
    }
}
