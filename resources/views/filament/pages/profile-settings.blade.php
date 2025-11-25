<x-filament-panels::page>
    <form wire:submit="updateProfile">
        {{ $this->form }}
        <br>
        <div class="mt-6">
            <x-filament::button type="submit" color="primary">
                Update Profile
            </x-filament::button>
        </div>
    </form>
</x-filament-panels::page>
