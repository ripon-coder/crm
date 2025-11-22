<?php

namespace App\Filament\Resources\DollarSales\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Table;

class DollarSalesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                \Filament\Tables\Columns\TextColumn::make('batch.id')
                    ->label('Batch ID')
                    ->sortable(),
                \Filament\Tables\Columns\TextColumn::make('customer.name')
                    ->searchable()
                    ->sortable(),
                \Filament\Tables\Columns\TextColumn::make('user.name')
                    ->label('Sold By')
                    ->sortable(),
                \Filament\Tables\Columns\TextColumn::make('amount')
                    ->numeric()
                    ->sortable(),
                \Filament\Tables\Columns\TextColumn::make('rate')
                    ->numeric()
                    ->sortable(),
                \Filament\Tables\Columns\TextColumn::make('total_price')
                    ->numeric()
                    ->sortable(),
                \Filament\Tables\Columns\TextColumn::make('profit')
                    ->numeric()
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
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
