<x-marketing-layout>
    <div class="container-xl py-5">
        <div class="col-lg-6 mx-auto">
            <div class="text-center mb-4">
                <h1 class="mb-2">{{ __('marketing.contact_title') }}</h1>
                <p class="text-secondary">{{ __('marketing.contact_subtitle') }}</p>
            </div>

            @if (session('status'))
                <div class="alert alert-success">{{ session('status') }}</div>
            @endif

            <div class="card">
                <div class="card-body">
                    <form method="POST" action="{{ route('marketing.contact.submit') }}">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">{{ __('marketing.contact_name') }}</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}">
                            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">{{ __('marketing.contact_email') }}</label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}">
                            @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">{{ __('marketing.contact_message') }}</label>
                            <textarea name="message" rows="5" class="form-control @error('message') is-invalid @enderror">{{ old('message') }}</textarea>
                            @error('message') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <button type="submit" class="btn btn-primary w-100">{{ __('marketing.contact_send') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-marketing-layout>
