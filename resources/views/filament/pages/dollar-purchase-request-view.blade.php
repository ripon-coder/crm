<x-filament-panels::page>
    {{ $this->infolist }}
    
    <div class="mt-6">
        <form wire:submit="approve">
            {{ $this->form }}
        </form>
    </div>
</x-filament-panels::page>
