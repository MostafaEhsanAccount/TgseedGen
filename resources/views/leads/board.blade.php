<x-app-layout>
    <x-slot name="header">
        <div class="d-flex align-items-center">
            <h2 class="page-title">{{ __('leads.board') }}</h2>
            <div class="ms-auto">
                <a href="{{ route('leads.index') }}" class="btn btn-outline-primary">{{ __('leads.table_view') }}</a>
            </div>
        </div>
    </x-slot>

    <livewire:lead-board />
</x-app-layout>
