<x-marketing-layout>
    <div class="container-xl py-5">
        <div class="col-lg-8 mx-auto text-center mb-5">
            <h1 class="mb-3">{{ __('marketing.features_title') }}</h1>
            <p class="fs-4 text-secondary">{{ __('marketing.features_subtitle') }}</p>
        </div>

        <div class="row row-cards g-4">
            @foreach (range(1, 6) as $i)
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <h3 class="card-title">{{ __('marketing.features_'.$i.'_title') }}</h3>
                            <p class="text-secondary mb-0">{{ __('marketing.features_'.$i.'_desc') }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="text-center mt-5">
            <a href="{{ route('register') }}" class="btn btn-primary btn-lg">{{ __('marketing.home_cta_primary') }}</a>
        </div>
    </div>
</x-marketing-layout>
