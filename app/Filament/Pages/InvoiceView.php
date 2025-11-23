<?php

namespace App\Filament\Pages;

use App\Models\DollarSale;
use Filament\Pages\Page;
use Illuminate\Contracts\Support\Htmlable;
use Barryvdh\DomPDF\Facade\Pdf;
class InvoiceView extends Page
{
    protected string $view = 'filament.pages.invoice-view';
    protected static bool $shouldRegisterNavigation = false;

    public ?DollarSale $record = null;
    
    public function mount(): void
    {
        $recordId = request()->query('record');
        
        if (!$recordId) {
            abort(404, 'Record not found');
        }
        
        $this->record = DollarSale::with(['customer', 'batch', 'payments'])
            ->findOrFail($recordId);
    }
    
    public function getTitle(): string | Htmlable
    {
        return 'Invoice #' . $this->record?->id;
    }
}
