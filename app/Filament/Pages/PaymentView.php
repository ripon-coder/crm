<?php

namespace App\Filament\Pages;

use App\Models\DollarSale;
use App\Models\Payment;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;

class PaymentView extends Page implements HasForms, HasTable
{
    use InteractsWithForms;
    use InteractsWithTable;

    protected string $view = 'filament.pages.payment-view';
    protected static ?string $title = 'Payments Create';
    protected static bool $shouldRegisterNavigation = false;

    public ?DollarSale $record = null;
    public ?array $data = [];

    public function mount(): void
    {
        $this->record = DollarSale::findOrFail(request()->query('record'));

        $this->form->fill([
            'amount'       => $this->record->total_price - $this->record->payments()->sum('amount'),
            'payment_method' => null,
            'transaction_id' => '',
            'notes'        => '',
        ]);
    }

    public function form($form)
    {
        return $form
            ->schema([
                \Filament\Schemas\Components\Section::make('Payment Details')
                    ->schema([
                        TextInput::make('amount')
                            ->label('Amount')
                            ->numeric()
                            ->required()
                            ->maxValue(fn () => $this->record->total_price - $this->record->payments()->sum('amount')),

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
            ])
            ->statePath('data');
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(
                $this->record
                    ? Payment::query()
                        ->where('payable_type', DollarSale::class)
                        ->where('payable_id', $this->record->id)
                    : Payment::query()->whereRaw('1 = 0') // fallback safe mode
            )
            ->columns([
                TextColumn::make('created_at')
                    ->label('Date')
                    ->dateTime()
                    ->sortable(),

                TextColumn::make('amount')
                    ->numeric()
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
            ->actions([
                \Filament\Actions\DeleteAction::make(),
            ]);
    }

    public function createPayment(): void
    {
        $data = $this->form->getState();

        $currentBalance = $this->record->payments()->sum('amount');
        if (($currentBalance + $data['amount']) > $this->record->total_price) {
             Notification::make()
                ->title('Payment amount exceeds total price')
                ->danger()
                ->send();
             return;
        }

        // Insert payment
        $this->record->payments()->create([
            'amount'         => $data['amount'],
            'payment_method' => $data['payment_method'],
            'transaction_id' => $data['transaction_id'] ?: '',
            'paid_at'        => now(),
            'notes'          => $data['notes'] ?: '',
        ]);

        // Success message
        Notification::make()
            ->title('Payment created successfully')
            ->success()
            ->send();

        // Refresh table
        $this->dispatch('refresh');

        // Reset form with updated due amount
        $this->form->fill([
            'amount'  => max(0, $this->record->total_price - $this->record->payments()->sum('amount')),
            'payment_method' => null,
            'transaction_id' => '',
            'notes' => '',
        ]);
    }
}
