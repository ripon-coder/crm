<?php

namespace App\Filament\Resources\DollarBatches\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Table;

class DollarBatchesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                \Filament\Tables\Columns\TextColumn::make('vendor.name')
                    ->searchable()
                    ->sortable(),
                \Filament\Tables\Columns\TextColumn::make('dollar_amount')
                    ->numeric()
                    ->sortable(),
                \Filament\Tables\Columns\TextColumn::make('remaining_amount')
                    ->numeric()
                    ->sortable()
                    ->color(fn ($state, $record) => $state < $record->dollar_amount * 0.2 ? 'danger' : 'success'),
                \Filament\Tables\Columns\TextColumn::make('rate')
                    ->numeric()
                    ->sortable(),
                \Filament\Tables\Columns\TextColumn::make('total_cost')
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
                    //DeleteBulkAction::make(),
                ]),
            ]);
    }
}
