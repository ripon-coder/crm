<?php

namespace App\Filament\Resources\DollarSales\RelationManagers;

use Filament\Forms;
use Filament\Schemas\Schema;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Notifications\Notification;

class PaymentsRelationManager extends RelationManager
{
    protected static string $relationship = 'payments';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                \Filament\Schemas\Components\Section::make('Payment Details')
                    ->schema([
                        TextInput::make('amount')
                            ->label('Amount')
                            ->numeric()
                            ->required()
                            ->maxValue(function ($livewire) {
                                $owner = $livewire->getOwnerRecord();
                                return $owner->total_price - $owner->payments()->sum('amount');
                            }),

                        Select::make('payment_method')
                            ->label('Payment Method')
                            ->options([
                                'cash' => 'Cash',
                                'bank_transfer' => 'Bank Transfer',
                                'check' => 'Check',
                                'other' => 'Other',
                            ])
                            ->required(),

                        TextInput::make('transaction_id')
                            ->label('Transaction ID')
                            ->nullable(),

                        Textarea::make('notes')
                            ->label('Notes')
                            ->nullable()
                            ->columnSpanFull(),
                    ])
                    ->columns(2),
            ])->columns(1);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('id')
            ->columns([
                TextColumn::make('created_at')
                    ->label('Date')
                    ->dateTime()
                    ->sortable(),

                TextColumn::make('amount')
                    ->numeric()
                    ->prefix('৳')
                    ->sortable(),

                TextColumn::make('payment_method')
                    ->label('Method')
                    ->formatStateUsing(fn (string $state): string => ucfirst($state)),

                TextColumn::make('transaction_id')
                    ->label('Transaction ID')
                    ->placeholder('-'),

                TextColumn::make('notes')
                    ->label('Notes')
                    ->limit(50)
                    ->placeholder('-'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                \Filament\Actions\CreateAction::make()
                    ->mutateFormDataUsing(function (array $data) {
                        $data['paid_at'] = now();
                        return $data;
                    })
                    ->before(function ($livewire, array $data) {
                         $owner = $livewire->getOwnerRecord();
                         $currentBalance = $owner->payments()->sum('amount');
                         if (($currentBalance + $data['amount']) > $owner->total_price) {
                             Notification::make()
                                ->title('Payment amount exceeds total price')
                                ->danger()
                                ->send();
                             $livewire->halt();
                         }
                    }),
            ])
            ->actions([
                \Filament\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                \Filament\Actions\BulkActionGroup::make([
                    \Filament\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
