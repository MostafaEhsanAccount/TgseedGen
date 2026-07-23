<x-app-layout>
    <x-slot name="header">
        <h2 class="page-title">{{ __('leads.import_status') }}</h2>
    </x-slot>

    @if (session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif

    <div class="card col-lg-8 mx-auto">
        <div class="card-body">
            <div class="d-flex align-items-center mb-3">
                <div>
                    <div class="fw-bold">{{ $batch->original_filename }}</div>
                    <div class="text-secondary small">
                        @php
                            $statusLabels = [
                                'processing' => __('leads.status_processing'),
                                'completed' => __('leads.status_completed'),
                                'completed_with_errors' => __('leads.status_completed_with_errors'),
                                'failed' => __('leads.status_failed'),
                            ];
                        @endphp
                        {{ $statusLabels[$batch->status] ?? $batch->status }}
                    </div>
                </div>
                <a href="{{ route('leads.import.show', $batch) }}" class="btn btn-outline-secondary btn-sm ms-auto">{{ __('leads.refresh_status') }}</a>
            </div>

            <div class="row row-cards g-3 mb-3">
                <div class="col-3">
                    <div class="card card-sm"><div class="card-body text-center"><div class="h2 mb-0">{{ $batch->total_rows }}</div><div class="text-secondary small">{{ __('leads.total_rows') }}</div></div></div>
                </div>
                <div class="col-3">
                    <div class="card card-sm"><div class="card-body text-center"><div class="h2 mb-0 text-success">{{ $batch->imported_rows }}</div><div class="text-secondary small">{{ __('leads.imported_rows') }}</div></div></div>
                </div>
                <div class="col-3">
                    <div class="card card-sm"><div class="card-body text-center"><div class="h2 mb-0 text-warning">{{ $batch->skipped_rows }}</div><div class="text-secondary small">{{ __('leads.skipped_rows') }}</div></div></div>
                </div>
                <div class="col-3">
                    <div class="card card-sm"><div class="card-body text-center"><div class="h2 mb-0 text-danger">{{ $batch->failed_rows }}</div><div class="text-secondary small">{{ __('leads.failed_rows') }}</div></div></div>
                </div>
            </div>

            @if (! empty($batch->error_log))
                <h4>{{ __('leads.error_log') }}</h4>
                <table class="table table-sm">
                    <thead><tr><th>{{ __('leads.row') }}</th><th>{{ __('leads.reason') }}</th></tr></thead>
                    <tbody>
                        @foreach ($batch->error_log as $entry)
                            <tr><td>{{ $entry['row'] }}</td><td>{{ $entry['reason'] }}</td></tr>
                        @endforeach
                    </tbody>
                </table>
            @endif

            <a href="{{ route('leads.index') }}" class="btn btn-primary">{{ __('leads.title') }}</a>
        </div>
    </div>
</x-app-layout>
