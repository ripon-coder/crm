<?php

namespace App\Filament\Pages;

use App\Models\DollarRequest;
use Filament\Pages\Page;
use Filament\Tables\Table;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Columns\TextColumn;
use UnitEnum;
use BackedEnum;

use Filament\Infolists\Contracts\HasInfolists;
use Filament\Infolists\Concerns\InteractsWithInfolists;
use Filament\Actions\Action;
use App\Filament\Pages\DollarPurchaseRequestView;

class DollarPurchaseRequest extends Page implements HasTable, HasInfolists
{
    use InteractsWithTable;
    use InteractsWithInfolists;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-viewfinder-circle';
    protected static UnitEnum|string|null $navigationGroup = 'Dollar-Sales';
    protected string $view = 'filament.pages.dollar-purchase-request';
    
    protected static ?string $navigationLabel = 'Purchase Requests';
    

    
    protected static ?int $navigationSort = 4;

    public function table(Table $table): Table
    {
        return $table
            ->query(DollarRequest::query()->with(['customer']))
            ->columns([
                TextColumn::make('id')
                    ->label('Request ID')
                    ->sortable()
                    ->searchable()
                    ->prefix('#'),
                    
                TextColumn::make('customer.name')
                    ->label('Customer')
                    ->sortable()
                    ->searchable(),
                    
                TextColumn::make('customer.email')
                    ->label('Email')
                    ->sortable()
                    ->searchable()
                    ->copyable(),
                    
                TextColumn::make('customer.phone')
                    ->label('Phone')
                    ->sortable()
                    ->searchable(),
                    
                TextColumn::make('dollar_amount')
                    ->label('Dollar Amount')
                    ->sortable()
                    ->prefix('$'),
                    
                TextColumn::make('dollar_rate')
                    ->label('Rate')
                    ->sortable()
                    ->prefix('৳'),
                    
                TextColumn::make('total_cost')
                    ->label('Total Cost')
                    ->sortable()
                    ->prefix('৳'),
                    
                TextColumn::make('payment_method')
                    ->label('Payment Method')
                    ->sortable()
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => ucfirst(str_replace('_', ' ', $state))),
                    
                TextColumn::make('status')
                    ->label('Status')
                    ->sortable()
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pending' => 'warning',
                        'approved' => 'success',
                        'rejected' => 'danger',
                        default => 'gray',
                    }),
                    
                TextColumn::make('created_at')
                    ->label('Submitted')
                    ->sortable()
                    ->dateTime('M d, Y h:i A'),
            ])
            ->defaultSort('created_at', 'desc')
            ->actions([
                Action::make('view')
                    ->icon('heroicon-o-eye')
                    ->url(fn (DollarRequest $record): string => \App\Filament\Pages\DollarPurchaseRequestView::getUrl(['record' => $record->id])),
            ])
            ->filters([
                // Add filters here if needed
            ]);
    }
}
