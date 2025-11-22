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
                    ->relationship(
                        name: 'batch',
                        titleAttribute: 'id',
                        modifyQueryUsing: fn ($query) => $query
                            ->where('is_active', true)
                            ->where('remaining_amount', '>', 0)
                            ->with('vendor')
                    )
                    ->getOptionLabelFromRecordUsing(fn ($record) => 
                        "{$record->vendor->name} - Rate: ৳{$record->rate} - Remaining: \${$record->remaining_amount}"
                    )
                    ->preload()
                    ->required()
                    ->live()
                    ->afterStateUpdated(function ($state, callable $set, callable $get) {
                        // Recalculate profit when batch changes
                        $amount = $get('amount');
                        $rate = $get('rate');
                        if ($state && $amount && $rate) {
                            $batch = \App\Models\DollarBatch::find($state);
                            if ($batch) {
                                $profit = ($rate - $batch->rate) * $amount;
                                $set('profit', number_format($profit, 2, '.', ''));
                            }
                        }
                    }),
                \Filament\Forms\Components\Select::make('customer_id')
                    ->relationship(
                        name: 'customer',
                        titleAttribute: 'name',
                        modifyQueryUsing: fn ($query) => $query->where('is_active', true)
                    )
                    ->preload()
                    ->required(),
                \Filament\Forms\Components\TextInput::make('amount')
                    ->required()
                    ->numeric()
                    ->live(onBlur: true)
                    ->afterStateUpdated(function ($state, callable $set, callable $get) {
                        $rate = $get('rate');
                        if ($state && $rate) {
                            // Calculate total_price
                            $totalPrice = $state * $rate;
                            $set('total_price', number_format($totalPrice, 2, '.', ''));
                            
                            // Calculate profit if batch is selected
                            $batchId = $get('batch_id');
                            if ($batchId) {
                                $batch = \App\Models\DollarBatch::find($batchId);
                                if ($batch) {
                                    $profit = ($rate - $batch->rate) * $state;
                                    $set('profit', number_format($profit, 2, '.', ''));
                                }
                            }
                        }
                    }),
                \Filament\Forms\Components\TextInput::make('rate')
                    ->required()
                    ->numeric()
                    ->live(onBlur: true)
                    ->afterStateUpdated(function ($state, callable $set, callable $get) {
                        $amount = $get('amount');
                        if ($state && $amount) {
                            // Calculate total_price
                            $totalPrice = $amount * $state;
                            $set('total_price', number_format($totalPrice, 2, '.', ''));
                            
                            // Calculate profit if batch is selected
                            $batchId = $get('batch_id');
                            if ($batchId) {
                                $batch = \App\Models\DollarBatch::find($batchId);
                                if ($batch) {
                                    $profit = ($state - $batch->rate) * $amount;
                                    $set('profit', number_format($profit, 2, '.', ''));
                                }
                            }
                        }
                    }),
                \Filament\Forms\Components\TextInput::make('total_price')
                    ->label('Total Price (Calculated)')
                    ->numeric()
                    ->readOnly()
                    ->dehydrated(false) // Not saved directly from form, calculated in model
                    ->prefix('৳')
                    ->placeholder('Auto-calculated'),
                \Filament\Forms\Components\TextInput::make('profit')
                    ->label('Profit (Calculated)')
                    ->numeric()
                    ->readOnly()
                    ->dehydrated(false) // Not saved directly from form, calculated in model
                    ->prefix('৳')
                    ->placeholder('Auto-calculated'),
                \Filament\Forms\Components\Textarea::make('notes')
                    ->maxLength(65535)
                    ->columnSpanFull(),
            ]);
    }
}
