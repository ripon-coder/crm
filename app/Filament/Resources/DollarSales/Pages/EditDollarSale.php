<?php

namespace App\Filament\Resources\DollarSales\Pages;

use App\Filament\Resources\DollarSales\DollarSaleResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditDollarSale extends EditRecord
{
    protected static string $resource = DollarSaleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make()
                ->disabled(fn () => $this->record->payments()->exists())
                ->tooltip(fn () => $this->record->payments()->exists() ? 'Cannot delete sale with existing payments' : null),
        ];
    }
}
