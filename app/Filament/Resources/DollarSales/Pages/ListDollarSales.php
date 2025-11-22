<?php

namespace App\Filament\Resources\DollarSales\Pages;

use App\Filament\Resources\DollarSales\DollarSaleResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListDollarSales extends ListRecords
{
    protected static string $resource = DollarSaleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
