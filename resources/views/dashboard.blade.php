<x-app-layout>
    <x-slot name="header">
        <h2 class="page-title">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="card">
        <div class="card-body">
            {{ __("You're logged in!") }}
        </div>
    </div>
</x-app-layout>
