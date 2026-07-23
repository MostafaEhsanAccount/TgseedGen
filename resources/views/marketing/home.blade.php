<x-marketing-layout>
    <div class="container-xl py-5">
        <div class="row align-items-center">
            <div class="col-lg-8 mx-auto text-center">
                <div class="text-primary fw-bold text-uppercase small mb-2">{{ __('marketing.home_hero_kicker') }}</div>
                <h1 class="display-5 fw-bold mb-3">{{ __('marketing.home_hero_title') }}</h1>
                <p class="fs-4 text-secondary mb-4">{{ __('marketing.home_hero_subtitle') }}</p>
                <div class="btn-list justify-content-center">
                    <a href="{{ route('register') }}" class="btn btn-primary btn-lg">{{ __('marketing.home_cta_primary') }}</a>
                    <a href="{{ route('marketing.features') }}" class="btn btn-outline-secondary btn-lg">{{ __('marketing.home_cta_secondary') }}</a>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-body-tertiary py-5">
        <div class="container-xl">
            <div class="row row-cards g-4">
                <div class="col-md-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <h3 class="card-title">{{ __('marketing.home_feature_1_title') }}</h3>
                            <p class="text-secondary mb-0">{{ __('marketing.home_feature_1_desc') }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <h3 class="card-title">{{ __('marketing.home_feature_2_title') }}</h3>
                            <p class="text-secondary mb-0">{{ __('marketing.home_feature_2_desc') }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <h3 class="card-title">{{ __('marketing.home_feature_3_title') }}</h3>
                            <p class="text-secondary mb-0">{{ __('marketing.home_feature_3_desc') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-xl py-5">
        <h2 class="text-center mb-5">{{ __('marketing.home_steps_title') }}</h2>
        <div class="row row-cards g-4">
            <div class="col-md-4 text-center">
                <div class="avatar avatar-lg bg-primary-lt mb-3 mx-auto">1</div>
                <h4>{{ __('marketing.home_step_1_title') }}</h4>
                <p class="text-secondary">{{ __('marketing.home_step_1_desc') }}</p>
            </div>
            <div class="col-md-4 text-center">
                <div class="avatar avatar-lg bg-primary-lt mb-3 mx-auto">2</div>
                <h4>{{ __('marketing.home_step_2_title') }}</h4>
                <p class="text-secondary">{{ __('marketing.home_step_2_desc') }}</p>
            </div>
            <div class="col-md-4 text-center">
                <div class="avatar avatar-lg bg-primary-lt mb-3 mx-auto">3</div>
                <h4>{{ __('marketing.home_step_3_title') }}</h4>
                <p class="text-secondary">{{ __('marketing.home_step_3_desc') }}</p>
            </div>
        </div>
    </div>

    <div class="bg-dark text-white py-5">
        <div class="container-xl text-center">
            <h2 class="mb-2">{{ __('marketing.home_pipeline_title') }}</h2>
            <p class="text-secondary mb-4">{{ __('marketing.home_pipeline_subtitle') }}</p>
            <div class="row justify-content-center g-3">
                @foreach (['#8B7CF6', '#4C9AFF', '#F5A623', '#3FD68B', '#F0605C'] as $color)
                    <div class="col-auto">
                        <div class="card" style="width: 140px; border-top: 3px solid {{ $color }}">
                            <div class="card-body text-dark">
                                <div class="placeholder-glow">
                                    <span class="placeholder col-8"></span>
                                    <span class="placeholder col-6"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="container-xl py-5">
        <h2 class="text-center mb-5">{{ __('marketing.home_testimonials_title') }}</h2>
        <div class="row row-cards g-4">
            @foreach ([1, 2, 3] as $i)
                <div class="col-md-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <p class="mb-3">&ldquo;{{ __('marketing.home_testimonial_'.$i.'_quote') }}&rdquo;</p>
                            <div class="fw-bold">{{ __('marketing.home_testimonial_'.$i.'_author') }}</div>
                            <div class="text-secondary small">{{ __('marketing.home_testimonial_'.$i.'_role') }}</div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <div class="bg-body-tertiary py-5">
        <div class="container-xl">
            <h2 class="text-center mb-5">{{ __('marketing.home_faq_title') }}</h2>
            <div class="accordion col-lg-8 mx-auto" id="home-faq">
                @foreach ([1, 2, 3, 4] as $i)
                    <div class="accordion-item">
                        <h3 class="accordion-header">
                            <button class="accordion-button {{ $i > 1 ? 'collapsed' : '' }}" type="button" data-bs-toggle="collapse" data-bs-target="#faq-{{ $i }}">
                                {{ __('marketing.home_faq_'.$i.'_q') }}
                            </button>
                        </h3>
                        <div id="faq-{{ $i }}" class="accordion-collapse collapse {{ $i === 1 ? 'show' : '' }}" data-bs-parent="#home-faq">
                            <div class="accordion-body text-secondary">{{ __('marketing.home_faq_'.$i.'_a') }}</div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="container-xl py-5 text-center">
        <h2 class="mb-2">{{ __('marketing.home_final_cta_title') }}</h2>
        <p class="text-secondary mb-4">{{ __('marketing.home_final_cta_subtitle') }}</p>
        <a href="{{ route('register') }}" class="btn btn-primary btn-lg">{{ __('marketing.home_final_cta_button') }}</a>
    </div>
</x-marketing-layout>
