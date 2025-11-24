<?php

namespace App\Filament\Pages;

use App\Models\DollarRequest;
use App\Models\DollarBatch;
use App\Models\DollarSale;
use App\Models\Customer;
use App\Models\Payment;
use Filament\Pages\Page;

use Filament\Infolists\Contracts\HasInfolists;
use Filament\Infolists\Concerns\InteractsWithInfolists;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Grid;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ImageEntry;

use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Concerns\InteractsWithForms;

use Filament\Support\Enums\TextSize;
use Filament\Support\Enums\FontWeight;
use Filament\Support\Enums\FontFamily;

use Filament\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\DB;

class DollarPurchaseRequestView extends Page implements HasInfolists, HasForms
{
    use InteractsWithInfolists;
    use InteractsWithForms;

    protected string $view = 'filament.pages.dollar-purchase-request-view';
    
    protected static bool $shouldRegisterNavigation = false;

    public ?DollarRequest $record = null;
    
    public ?array $approvalData = [];

    public function mount(): void
    {
        $id = request()->query('record');
        if ($id) {
            $this->record = DollarRequest::with('customer')->find($id);
        }
        
        if (! $this->record) {
            redirect()->route('filament.admin.pages.dollar-purchase-request');
        }
        
        // Initialize form data with rate from request
        $this->form->fill([
            'batch_id' => null,
            'rate' => $this->record->dollar_rate,
        ]);
    }

    public function getTitle(): string
    {
        return 'Request Details #' . ($this->record->id ?? '');
    }

    public function getInfolistProperty(): Schema
    {
        return $this->infolist(Schema::make($this));
    }

    public function infolist(Schema $schema): Schema
    {
        return $schema
            ->record($this->record)
            ->schema([
                Grid::make(2)
                    ->schema([
                        Section::make('Customer Details')
                            ->icon('heroicon-o-user')
                            ->schema([
                                TextEntry::make('customer.name')->label('Name'),
                                TextEntry::make('customer.email')->label('Email')->copyable(),
                                TextEntry::make('customer.phone')->label('Phone'),
                                TextEntry::make('customer.address')->label('Address'),
                            ])
                            ->columnSpan(1),

                        Section::make('Purchase Details')
                            ->icon('heroicon-o-currency-dollar')
                            ->schema([
                                Grid::make(2)
                                    ->schema([
                                        TextEntry::make('dollar_amount')
                                            ->label('Amount')
                                            ->money('USD')
                                            ->size(TextSize::Large)
                                            ->weight(FontWeight::Bold),
                                        TextEntry::make('dollar_rate')
                                            ->label('Rate')
                                            ->prefix('৳'),
                                    ]),
                                TextEntry::make('total_cost')
                                    ->label('Total Cost')
                                    ->prefix('৳')
                                    ->size(TextSize::Large)
                                    ->weight(FontWeight::Bold)
                                    ->color('primary'),
                                TextEntry::make('payment_method')
                                    ->label('Payment Method')
                                    ->badge()
                                    ->formatStateUsing(fn (string $state): string => ucfirst(str_replace('_', ' ', $state))),
                                TextEntry::make('transaction_id')
                                    ->label('Transaction ID')
                                    ->fontFamily(FontFamily::Mono)
                                    ->visible(fn ($record) => $record->transaction_id),
                                TextEntry::make('bank_name')
                                    ->label('Bank Name')
                                    ->visible(fn ($record) => $record->bank_name),
                                TextEntry::make('account_number')
                                    ->label('Account Number')
                                    ->fontFamily(FontFamily::Mono)
                                    ->visible(fn ($record) => $record->account_number),
                                TextEntry::make('status')
                                    ->label('Status')
                                    ->badge()
                                    ->color(fn (string $state): string => match ($state) {
                                        'approved' => 'success',
                                        'rejected' => 'danger',
                                        default => 'warning',
                                    }),
                            ])
                            ->columnSpan(1),
                    ]),

                Section::make('Transaction Proof')
                    ->icon('heroicon-o-photo')
                    ->schema([
                        ImageEntry::make('transaction_proof')
                            ->hiddenLabel()
                            ->disk('public')
                            ->extraImgAttributes([
                                'class' => 'max-h-[600px] object-contain mx-auto',
                            ])
                            ->visible(fn ($record) => $record->transaction_proof),
                        TextEntry::make('no_proof')
                            ->hiddenLabel()
                            ->default('No proof uploaded')
                            ->visible(fn ($record) => ! $record->transaction_proof),
                    ]),
            ]);
    }

    public function form(\Filament\Schemas\Schema $schema): \Filament\Schemas\Schema
    {
        return $schema
            ->statePath('approvalData')
            ->schema([
                Section::make('Approval Details')
                    ->description('Select a batch and confirm the rate to approve this request')
                    ->schema([
                        Select::make('batch_id')
                            ->label('Select Batch')
                            ->options(function () {
                                return DollarBatch::where('is_active', true)
                                    ->where('remaining_amount', '>', 0)
                                    ->with('vendor')
                                    ->get()
                                    ->mapWithKeys(function ($batch) {
                                        return [
                                            $batch->id => "{$batch->vendor->name} - Rate: ৳{$batch->rate} - Remaining: \${$batch->remaining_amount}"
                                        ];
                                    });
                            })
                            ->preload()
                            ->required()
                            ->live()
                            ->afterStateUpdated(function ($state, callable $set, callable $get, $livewire) {
                                // Calculate profit when batch changes
                                $rate = $get('rate');
                                if ($state && $rate && $livewire->record) {
                                    $batch = DollarBatch::find($state);
                                    if ($batch) {
                                        $profit = ($rate - $batch->rate) * $livewire->record->dollar_amount;
                                        $set('profit', number_format($profit, 2, '.', ''));
                                    }
                                }
                            }),
                        
                        TextInput::make('rate')
                            ->label('Sale Rate (৳/$)')
                            ->required()
                            ->numeric()
                            ->prefix('৳')
                            ->minValue(0)
                            ->live()
                            ->helperText(function ($state, $livewire) {
                                if ($state && $livewire->record) {
                                    return 'Total: ৳' . number_format($state * $livewire->record->dollar_amount, 2);
                                }
                                return null;
                            })
                            ->live()
                            ->afterStateUpdated(function ($state, callable $set, callable $get, $livewire) {
                                // Calculate profit when rate changes
                                $batchId = $get('batch_id');
                                if ($batchId && $state && $livewire->record) {
                                    $batch = DollarBatch::find($batchId);
                                    if ($batch) {
                                        $profit = ($state - $batch->rate) * $livewire->record->dollar_amount;
                                        $set('profit', number_format($profit, 2, '.', ''));
                                    }
                                }
                            }),
                        
                        TextInput::make('profit')
                            ->label('Profit')
                            ->numeric()
                            ->readOnly()
                            ->dehydrated(false)
                            ->prefix('৳')
                            ->placeholder('Auto-calculated')
                            ->hint('(Sale Rate - Batch Rate) × Amount'),
                    ])
                    ->columns(2)
                    ->visible(fn () => $this->record?->status === 'pending'),
            ]);
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('approve')
                ->label('Approve Request')
                ->icon('heroicon-o-check-circle')
                ->color('success')
                ->requiresConfirmation()
                ->modalHeading('Approve Dollar Purchase Request')
                ->modalDescription('This will create a customer (if needed) and a dollar sale record.')
                ->visible(fn () => $this->record?->status === 'pending')
                ->disabled(fn () => empty($this->approvalData['batch_id']))
                ->action(function () {
                    $this->validate();
                    
                    try {
                        DB::transaction(function () {
                            // 1. Find or create customer
                            $customer = Customer::firstOrCreate(
                                ['email' => $this->record->customer_email],
                                [
                                    'name' => $this->record->customer_name,
                                    'phone' => $this->record->customer_phone,
                                    'address' => $this->record->customer_address,
                                ]
                            );
                            
                            // 2. Validate batch has sufficient stock
                            $batch = DollarBatch::find($this->approvalData['batch_id']);
                            if ($batch->remaining_amount < $this->record->dollar_amount) {
                                throw new \Exception(
                                    "Insufficient stock in batch. Remaining: {$batch->remaining_amount}, Requested: {$this->record->dollar_amount}"
                                );
                            }
                            
                            // 3. Create dollar sale (stock will be decremented by model observer)
                            $dollarSale = DollarSale::create([
                                'customer_id' => $customer->id,
                                'batch_id' => $this->approvalData['batch_id'],
                                'amount' => $this->record->dollar_amount,
                                'rate' => $this->approvalData['rate'],
                                'invoice_id' => null,
                            ]);
                            
                            // 4. Create payment record
                            Payment::create([
                                'payable_type' => DollarSale::class,
                                'payable_id' => $dollarSale->id,
                                'amount' => $dollarSale->total_price,
                                'payment_method' => $this->record->payment_method,
                                'transaction_id' => $this->record->transaction_id,
                                'paid_at' => now(),
                                'notes' => "Payment from dollar purchase request #{$this->record->id}",
                            ]);
                            
                            // 5. Update request status
                            $this->record->update([
                                'status' => 'approved',
                                'customer_id' => $customer->id,
                            ]);
                        });
                        
                        Notification::make()
                            ->success()
                            ->title('Request Approved')
                            ->body('Dollar sale has been created successfully.')
                            ->send();
                        
                        return redirect()->route('filament.admin.pages.dollar-purchase-request');
                        
                    } catch (\Exception $e) {
                        Notification::make()
                            ->danger()
                            ->title('Approval Failed')
                            ->body($e->getMessage())
                            ->send();
                    }
                }),
        ];
    }
}
