<x-marketing-layout>
    <div class="container-xl py-5">
        <div class="col-lg-8 mx-auto text-center mb-5">
            <h1 class="mb-3">{{ __('marketing.pricing_title') }}</h1>
            <p class="fs-4 text-secondary">{{ __('marketing.pricing_subtitle') }}</p>
        </div>

        <div class="row row-cards g-4 justify-content-center">
            <div class="col-md-4">
                <div class="card h-100">
                    <div class="card-body">
                        <h3 class="card-title">{{ __('marketing.pricing_starter_name') }}</h3>
                        <p class="text-secondary">{{ __('marketing.pricing_starter_desc') }}</p>
                        <div class="h1 mb-3">$15 <span class="fs-5 text-secondary fw-normal">{{ __('marketing.pricing_per_month') }}</span></div>
                        <ul class="list-unstyled mb-4">
                            <li class="mb-2">✓ {{ __('marketing.pricing_starter_feature_1') }}</li>
                            <li class="mb-2">✓ {{ __('marketing.pricing_starter_feature_2') }}</li>
                            <li class="mb-2">✓ {{ __('marketing.pricing_starter_feature_3') }}</li>
                        </ul>
                        <a href="{{ route('register') }}" class="btn btn-outline-primary w-100">{{ __('marketing.pricing_cta') }}</a>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card h-100 border-primary">
                    <div class="card-status-top bg-primary"></div>
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between">
                            <h3 class="card-title mb-0">{{ __('marketing.pricing_growth_name') }}</h3>
                            <span class="badge bg-primary-lt">{{ __('marketing.pricing_most_popular') }}</span>
                        </div>
                        <p class="text-secondary">{{ __('marketing.pricing_growth_desc') }}</p>
                        <div class="h1 mb-3">$45 <span class="fs-5 text-secondary fw-normal">{{ __('marketing.pricing_per_month') }}</span></div>
                        <ul class="list-unstyled mb-4">
                            <li class="mb-2">✓ {{ __('marketing.pricing_growth_feature_1') }}</li>
                            <li class="mb-2">✓ {{ __('marketing.pricing_growth_feature_2') }}</li>
                            <li class="mb-2">✓ {{ __('marketing.pricing_growth_feature_3') }}</li>
                        </ul>
                        <a href="{{ route('register') }}" class="btn btn-primary w-100">{{ __('marketing.pricing_cta') }}</a>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card h-100">
                    <div class="card-body">
                        <h3 class="card-title">{{ __('marketing.pricing_business_name') }}</h3>
                        <p class="text-secondary">{{ __('marketing.pricing_business_desc') }}</p>
                        <div class="h1 mb-3">$95 <span class="fs-5 text-secondary fw-normal">{{ __('marketing.pricing_per_month') }}</span></div>
                        <ul class="list-unstyled mb-4">
                            <li class="mb-2">✓ {{ __('marketing.pricing_business_feature_1') }}</li>
                            <li class="mb-2">✓ {{ __('marketing.pricing_business_feature_2') }}</li>
                            <li class="mb-2">✓ {{ __('marketing.pricing_business_feature_3') }}</li>
                        </ul>
                        <a href="{{ route('register') }}" class="btn btn-outline-primary w-100">{{ __('marketing.pricing_cta') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-marketing-layout>
