<?php

namespace App\Filament\Resources\DollarSales\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class DollarSaleForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([

            Section::make('Sale Details')
                ->schema([
                    Select::make('batch_id')
                        ->label('Dollar Batch')
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

                    Select::make('customer_id')
                        ->label('Customer')
                        ->relationship(
                            name: 'customer',
                            titleAttribute: 'name',
                            modifyQueryUsing: fn ($query) => $query->where('is_active', true)
                        )
                        ->preload()
                        ->required(),

                    TextInput::make('amount')
                        ->label('Dollar Amount')
                        ->required()
                        ->numeric()
                        ->prefix('$')
                        ->live(onBlur: true)
                        ->rules([
                            function (callable $get) {
                                return function (string $attribute, $value, \Closure $fail) use ($get) {
                                    $batchId = $get('batch_id');
                                    if ($batchId && $value) {
                                        $batch = \App\Models\DollarBatch::find($batchId);
                                        if ($batch && $batch->remaining_amount < $value) {
                                            $fail("⚠️ Insufficient stock in batch! Available: \${$batch->remaining_amount}, Requested: \${$value}");
                                        }
                                    }
                                };
                            }
                        ])
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

                    TextInput::make('rate')
                        ->label('Sale Rate (৳)')
                        ->required()
                        ->numeric()
                        ->prefix('৳')
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
                ])
                ->columns(2),
 
             Section::make('Calculated Values')
                 ->schema([
                    TextInput::make('total_price')
                        ->label('Total Price')
                        ->numeric()
                        ->readOnly()
                        ->dehydrated(false)
                        ->prefix('৳')
                        ->placeholder('Auto-calculated')
                        ->hint('Amount × Rate'),

                    TextInput::make('profit')
                        ->label('Profit')
                        ->numeric()
                        ->readOnly()
                        ->dehydrated(false)
                        ->prefix('৳')
                        ->placeholder('Auto-calculated')
                        ->hint('(Sale Rate - Batch Rate) × Amount'),

                    Textarea::make('notes')
                        ->label('Notes')
                        ->rows(3)
                        ->maxLength(65535)
                        ->columnSpanFull(),
                ])
                ->columns(2),

        ])->columns(1);
    }
}