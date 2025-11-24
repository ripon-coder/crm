<?php

namespace App\Filament\Pages;

use App\Models\ProjectLead;
use Filament\Pages\Page;
use Illuminate\Contracts\Support\Htmlable;

class ProjectLeadInvoiceView extends Page
{
    protected string $view = 'filament.pages.project-lead-invoice-view';
    protected static bool $shouldRegisterNavigation = false;

    public ?ProjectLead $record = null;
    
    public function mount(): void
    {
        $recordId = request()->query('record');
        
        if (!$recordId) {
            abort(404, 'Record not found');
        }
        
        $this->record = ProjectLead::with(['customer', 'payments'])
            ->findOrFail($recordId);
    }
    
    public function getTitle(): string | Htmlable
    {
        return 'Invoice #' . $this->record?->id;
    }
}
