<?php

namespace App\Filament\Resources\DollarSales\Tables;

use App\Models\DollarSale;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\Action;
use Filament\Tables\Table;

class DollarSalesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('id', 'desc')
            ->columns([
                \Filament\Tables\Columns\TextColumn::make('id')
                    ->sortable(),
                \Filament\Tables\Columns\TextColumn::make('batch_info')
                    ->label('Batch')
                    ->state(fn (DollarSale $record) => $record->batch->vendor->name . ' - ৳' . $record->batch->rate)
                    ->sortable(query: function ($query, string $direction) {
                        return $query->orderBy(
                            \App\Models\DollarBatch::select('rate')
                                ->whereColumn('dollar_batches.id', 'dollar_sales.batch_id'),
                            $direction
                        );
                    }),
                \Filament\Tables\Columns\TextColumn::make('customer.name')
                    ->searchable()
                    ->sortable(),
                \Filament\Tables\Columns\TextColumn::make('amount')
                    ->numeric()
                    ->prefix('$')
                    ->sortable(),
                \Filament\Tables\Columns\TextColumn::make('rate')
                    ->numeric()
                    ->prefix('৳')
                    ->sortable(),
                \Filament\Tables\Columns\TextColumn::make('total_price')
                    ->numeric()
                    ->prefix('৳')
                    ->sortable(),
                \Filament\Tables\Columns\TextColumn::make('due_amount')
                    ->label('Due')
                    ->numeric()
                    ->prefix('৳')
                    ->state(fn (DollarSale $record) => $record->total_price - $record->payments()->sum('amount')),
                \Filament\Tables\Columns\TextColumn::make('payment_status')
                    ->label('Payment Status')
                    ->badge()
                    ->state(function (DollarSale $record) {
                        $paid = $record->payments()->sum('amount');
                        if ($paid >= $record->total_price) return 'Fully Paid';
                        if ($paid > 0) return 'Partial';
                        return 'Not Paid';
                    })
                    ->color(fn (string $state): string => match ($state) {
                        'Fully Paid' => 'success',
                        'Partial' => 'warning',
                        'Not Paid' => 'danger',
                    }),
                \Filament\Tables\Columns\TextColumn::make('profit')
                    ->numeric()
                    ->prefix('৳')
                    ->sortable(),
                \Filament\Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([

                Action::make('Invoice')
                    ->label('Invoice')
                    ->icon('heroicon-o-document-text')
                    ->url(fn (DollarSale $record): string => route('filament.admin.pages.invoice-view', ['record' => $record->id])),

                Action::make('Payments')
                    ->label('Payments')
                    ->icon('heroicon-o-wallet')
                    ->url(fn (DollarSale $record): string => route('filament.admin.pages.payment-view', ['record' => $record->id]))
                    ->openUrlInNewTab(),

                EditAction::make(),
            ])
            ->toolbarActions([
                \Filament\Actions\DeleteAction::make()
                    ->disabled(fn (DollarSale $record) => $record->payments()->exists())
                    ->tooltip(fn (DollarSale $record) => $record->payments()->exists() ? 'Cannot delete sale with existing payments' : null),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    //DeleteBulkAction::make(),
                ]),
            ]);
    }
}
