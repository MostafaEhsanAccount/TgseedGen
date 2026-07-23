<x-app-layout>
    <x-slot name="header">
        <h2 class="page-title">{{ __('leads.new_lead') }}</h2>
    </x-slot>

    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('leads.store') }}">
                @csrf
                @include('leads._form')

                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">{{ __('leads.save') }}</button>
                    <a href="{{ route('leads.index') }}" class="btn btn-link">{{ __('leads.cancel') }}</a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
