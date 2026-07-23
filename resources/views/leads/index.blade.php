<x-app-layout>
    <x-slot name="header">
        <div class="d-flex align-items-center">
            <h2 class="page-title">{{ __('leads.title') }}</h2>
            <div class="ms-auto">
                <a href="{{ route('leads.board') }}" class="btn btn-outline-primary">{{ __('leads.kanban_board') }}</a>
            </div>
        </div>
    </x-slot>

    @if (session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif

    <livewire:lead-index />
</x-app-layout>
