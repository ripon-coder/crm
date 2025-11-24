<?php

namespace App\Filament\Resources\ProjectLeads\Pages;

use App\Filament\Resources\ProjectLeads\ProjectLeadResource;
use Filament\Resources\Pages\ListRecords;

class ListProjectLeads extends ListRecords
{
    protected static string $resource = ProjectLeadResource::class;

    protected function getHeaderActions(): array
    {
        return [
            \Filament\Actions\CreateAction::make(),
        ];
    }
}
