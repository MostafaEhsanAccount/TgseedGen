<x-app-layout>
    <x-slot name="header">
        <h2 class="page-title">{{ __('leads.map_columns') }}</h2>
    </x-slot>

    <div class="card col-lg-8 mx-auto">
        <div class="card-body">
            <p class="text-secondary">{{ __('leads.map_columns_subtitle') }}</p>

            <form method="POST" action="{{ route('leads.import.store') }}">
                @csrf
                <input type="hidden" name="stored_path" value="{{ $storedPath }}">
                <input type="hidden" name="original_filename" value="{{ $originalFilename }}">

                <table class="table">
                    <thead>
                        <tr>
                            <th>{{ __('leads.csv_column') }}</th>
                            <th>{{ __('leads.maps_to') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($headers as $index => $header)
                            <tr>
                                <td class="align-middle">{{ $header }}</td>
                                <td>
                                    <select name="mapping[{{ $index }}]" class="form-select">
                                        <option value="ignore">{{ __('leads.ignore_field') }}</option>
                                        @foreach ($mappableFields as $field)
                                            <option value="{{ $field }}" @selected(strtolower(trim($header)) === $field)>{{ __('leads.'.$field) }}</option>
                                        @endforeach
                                    </select>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <button type="submit" class="btn btn-primary">{{ __('leads.confirm_import') }}</button>
                <a href="{{ route('leads.import.create') }}" class="btn btn-link">{{ __('leads.back') }}</a>
            </form>
        </div>
    </div>
</x-app-layout>
