<?php

namespace App\Filament\Resources\Payments\Tables;

use App\Models\Payment;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PaymentsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('id', 'desc')
            ->columns([
                TextColumn::make('id')->sortable(),
                TextColumn::make('payable_type')->label('Payable Type'),
                TextColumn::make('payable_id')->label('Payable ID'),
                TextColumn::make('amount')->numeric()->prefix('৳'),
                TextColumn::make('payment_method')->label('Method'),
                TextColumn::make('paid_at')->dateTime(),
                // TextColumn::make('is_active')->boolean()->label('Active'),
            ]);
    }
}
