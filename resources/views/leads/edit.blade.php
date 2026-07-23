<x-app-layout>
    <x-slot name="header">
        <h2 class="page-title">{{ __('leads.edit_lead') }}</h2>
    </x-slot>

    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('leads.update', $lead) }}">
                @csrf
                @method('PUT')
                @include('leads._form')

                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">{{ __('leads.save_changes') }}</button>
                    <a href="{{ route('leads.show', $lead) }}" class="btn btn-link">{{ __('leads.cancel') }}</a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
