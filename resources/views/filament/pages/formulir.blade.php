@php
    use App\Models\Formulir;
    $isFilled = Formulir::where('user_id', auth()->id())->exists();
@endphp

<x-filament-panels::page>
    <x-filament-panels::form wire:submit="save">
        {{ $this->form }}

        @unless($isFilled)
            <x-filament-panels::form.actions :actions="$this->getFormActions()" />
        @endunless
    </x-filament-panels::form>
</x-filament-panels::page>
