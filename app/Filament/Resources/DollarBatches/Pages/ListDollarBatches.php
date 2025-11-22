<?php

namespace App\Filament\Resources\DollarBatches\Pages;

use App\Filament\Resources\DollarBatches\DollarBatchResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListDollarBatches extends ListRecords
{
    protected static string $resource = DollarBatchResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
