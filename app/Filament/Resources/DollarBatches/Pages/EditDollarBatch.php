<?php

namespace App\Filament\Resources\DollarBatches\Pages;

use App\Filament\Resources\DollarBatches\DollarBatchResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditDollarBatch extends EditRecord
{
    protected static string $resource = DollarBatchResource::class;

    protected function getHeaderActions(): array
    {
        return [
           // DeleteAction::make(),
        ];
    }
}
