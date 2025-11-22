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
            DeleteAction::make(),
        ];
    }
}
