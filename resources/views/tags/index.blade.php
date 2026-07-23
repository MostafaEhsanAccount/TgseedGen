<x-app-layout>
    <x-slot name="header">
        <h2 class="page-title">{{ __('tags.title') }}</h2>
    </x-slot>

    @if (session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif

    <div class="row g-3">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header"><h3 class="card-title">{{ __('tags.new_tag') }}</h3></div>
                <div class="card-body">
                    <form method="POST" action="{{ route('tags.store') }}">
                        @csrf
                        <div class="mb-2">
                            <label class="form-label">{{ __('tags.name') }}</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}">
                            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="mb-2">
                            <label class="form-label">{{ __('tags.color') }}</label>
                            <input type="color" name="color" class="form-control form-control-color" value="{{ old('color', '#4f46e5') }}">
                        </div>
                        <button type="submit" class="btn btn-primary">{{ __('tags.add') }}</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="table-responsive">
                    <table class="table table-vcenter card-table">
                        <thead>
                            <tr>
                                <th>{{ __('tags.name') }}</th>
                                <th>{{ __('tags.lead_count') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($tags as $tag)
                                <tr>
                                    <td><span class="badge" style="background-color: {{ $tag->color }}">{{ $tag->name }}</span></td>
                                    <td>{{ $tag->leads_count }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="2" class="text-center text-secondary py-4">{{ __('tags.no_tags_yet') }}</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
