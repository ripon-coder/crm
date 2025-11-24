<?php

namespace App\Filament\Resources\Payments\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class PaymentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Payment Details')
                ->schema([
                    // Polymorphic relation: payable_type and payable_id
                    Select::make('payable_type')
                        ->label('Payable Type')
                        ->options([
                            'App\\Models\\Invoice' => 'Invoice',
                            'App\\Models\\ProjectLead' => 'Project Lead',
                            // add other payable models if needed
                        ])
                        ->required(),
                    TextInput::make('payable_id')
                        ->label('Payable ID')
                        ->numeric()
                        ->required(),
                    TextInput::make('amount')
                        ->label('Amount')
                        ->numeric()
                        ->required(),
                    TextInput::make('payment_method')
                        ->label('Payment Method')
                        ->maxLength(255),
                    TextInput::make('transaction_id')
                        ->label('Transaction ID')
                        ->maxLength(255),
                    TextInput::make('paid_at')
                        ->label('Paid At')
                        ->type('datetime'),
                ])->columns(2),
            Section::make('Additional')
                ->schema([
                    Textarea::make('notes')
                        ->label('Notes')
                        ->rows(3),
                    // Toggle::make('is_active')
                    //     ->label('Is Active')
                    //     ->default(true),
                ])->columns(1),
        ])->columns(1);
    }
}
