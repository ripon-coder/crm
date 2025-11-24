<x-filament-panels::page>
    <form wire:submit="createPayment">
        {{ $this->form }}
        <br>
        <div class="flex justify-end">
            <x-filament::button type="submit">
                Create Payment
            </x-filament::button>
        </div>
    </form>

    <div class="mt-8">
        {{ $this->table }}
    </div>
</x-filament-panels::page>
