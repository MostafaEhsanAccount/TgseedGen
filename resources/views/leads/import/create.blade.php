<x-app-layout>
    <x-slot name="header">
        <h2 class="page-title">{{ __('leads.import_leads') }}</h2>
    </x-slot>

    <div class="card col-lg-6 mx-auto">
        <div class="card-body">
            <h3 class="card-title">{{ __('leads.upload_csv_file') }}</h3>
            <p class="text-secondary">{{ __('leads.upload_csv_hint') }}</p>

            <form method="POST" action="{{ route('leads.import.preview') }}" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label class="form-label">{{ __('leads.choose_file') }}</label>
                    <input type="file" name="file" accept=".csv,text/csv" class="form-control @error('file') is-invalid @enderror" required>
                    @error('file') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <button type="submit" class="btn btn-primary">{{ __('leads.upload_and_continue') }}</button>
                <a href="{{ route('leads.index') }}" class="btn btn-link">{{ __('leads.cancel') }}</a>
            </form>
        </div>
    </div>
</x-app-layout>
