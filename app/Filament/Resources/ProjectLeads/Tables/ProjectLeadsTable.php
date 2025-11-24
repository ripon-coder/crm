<?php

namespace App\Filament\Resources\ProjectLeads\Tables;

use App\Models\ProjectLead;
use Filament\Tables\Table;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\BooleanColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use App\Filament\Resources\ProjectLeads\ProjectLeadResource;

class ProjectLeadsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('id', 'desc')
            ->columns([
                TextColumn::make('id')->sortable(),
                TextColumn::make('customer.name')->label('Customer')->searchable()->sortable(),
                TextColumn::make('title')->searchable()->sortable(),
                BadgeColumn::make('status')
                    ->colors([
                        'pending' => 'secondary',
                        'in_progress' => 'primary',
                        'completed' => 'success',
                        'cancelled' => 'danger',
                    ]),
                TextColumn::make('budget')->numeric()->prefix('৳')->sortable(),
                TextColumn::make('due')
                    ->label('Due')
                    ->numeric()
                    ->prefix('৳')
                    ->state(fn (ProjectLead $record) => $record->budget - $record->payments()->sum('amount')),
                TextColumn::make('payment_status')
                    ->label('Payment Status')
                    ->badge()
                    ->state(function (ProjectLead $record) {
                        $paid = $record->payments()->sum('amount');
                        if ($paid >= $record->budget) return 'Fully Paid';
                        if ($paid > 0) return 'Partial';
                        return 'Not Paid';
                    })
                    ->color(fn (string $state): string => match ($state) {
                        'Fully Paid' => 'success',
                        'Partial' => 'warning',
                        'Not Paid' => 'danger',
                    }),
                TextColumn::make('start_date')->date()->sortable(),
                TextColumn::make('end_date')->date()->sortable(),
                BooleanColumn::make('is_active')->label('Active')->sortable(),
                TextColumn::make('created_at')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'in_progress' => 'In Progress',
                        'completed' => 'Completed',
                        'cancelled' => 'Cancelled',
                    ]),
                TernaryFilter::make('is_active')
                    ->label('Active Status')
                    ->boolean()
                    ->trueLabel('Active Only')
                    ->falseLabel('Inactive Only')
                    ->native(false),
            ])
            ->recordActions([
                Action::make('Invoice')
                    ->label('Invoice')
                    ->icon('heroicon-o-document-text')
                    ->url(fn (ProjectLead $record): string => route('filament.admin.pages.project-lead-invoice-view', ['record' => $record->id])),

                Action::make('Payments')
                    ->label('Payments')
                    ->icon('heroicon-o-wallet')
                    ->url(fn (ProjectLead $record): string => route('filament.admin.pages.project-lead-payment-view', ['record' => $record->id]))
                    ->openUrlInNewTab(),

                EditAction::make(),
                DeleteAction::make()
                    ->disabled(fn (ProjectLead $record) => $record->payments()->exists())
                    ->tooltip(fn (ProjectLead $record) => $record->payments()->exists() ? 'Cannot delete lead with payments' : null),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    // DeleteBulkAction::make(),
                ]),
            ]);
    }
}
