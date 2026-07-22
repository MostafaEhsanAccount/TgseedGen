<x-app-layout>
    <x-slot name="header">
        <h2 class="page-title">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="row row-deck row-cards">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>
        </div>

        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    @include('profile.partials.update-password-form')
                </div>
            </div>
        </div>

        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
