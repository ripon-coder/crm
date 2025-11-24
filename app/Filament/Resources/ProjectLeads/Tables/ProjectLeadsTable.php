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
                TextColumn::make('budget')->numeric()->prefix('$')->sortable(),
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
