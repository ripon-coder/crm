<?php

namespace App\Filament\Pages;

use App\Models\DollarRequest;
use Filament\Pages\Page;
use Filament\Infolists\Infolist;
use Filament\Infolists\Contracts\HasInfolists;
use Filament\Infolists\Concerns\InteractsWithInfolists;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Concerns\InteractsWithForms;

class DollarPurchaseRequestView extends Page implements HasInfolists, HasForms
{
    use InteractsWithInfolists;
    use InteractsWithForms;


    protected string $view = 'filament.pages.dollar-purchase-request-view';
    
    protected static bool $shouldRegisterNavigation = false;

    public ?DollarRequest $record = null;

    public function mount(): void
    {
        $id = request()->query('record');
        if ($id) {
            $this->record = DollarRequest::with('customer')->find($id);
        }
        
        if (! $this->record) {
            redirect()->route('filament.admin.pages.dollar-purchase-request');
        }
    }

    public function requestInfolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->record($this->record)
            ->schema([
                Section::make('Customer Details')
                    ->schema([
                        TextEntry::make('customer.name')->label('Name'),
                        TextEntry::make('customer.email')->label('Email')->copyable(),
                        TextEntry::make('customer.phone')->label('Phone'),
                        TextEntry::make('customer.address')->label('Address'),
                    ])->columns(2),
                Section::make('Purchase Details')
                    ->schema([
                        TextEntry::make('dollar_amount')->money('USD')->label('Amount'),
                        TextEntry::make('dollar_rate')->label('Rate (BDT)'),
                        TextEntry::make('total_cost')->money('BDT')->label('Total Cost'),
                        TextEntry::make('payment_method')->badge()->formatStateUsing(fn (string $state): string => ucfirst(str_replace('_', ' ', $state))),
                        TextEntry::make('transaction_id')->label('Transaction ID')->copyable(),
                        TextEntry::make('bank_name')->label('Bank Name')->visible(fn ($record) => $record->bank_name),
                        TextEntry::make('account_number')->label('Account Number')->visible(fn ($record) => $record->account_number),
                        TextEntry::make('status')->badge()->colors([
                            'warning' => 'pending',
                            'success' => 'approved',
                            'danger' => 'rejected',
                        ]),
                    ])->columns(2),
                Section::make('Transaction Proof')
                    ->schema([
                        ImageEntry::make('transaction_proof')
                            ->label('')
                            ->width('100%')
                            ->height('auto')
                            ->extraImgAttributes(['class' => 'rounded-lg shadow-md']),
                    ]),
            ]);
    }
}
