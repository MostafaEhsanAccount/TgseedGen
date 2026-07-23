<x-marketing-layout>
    <div class="container-xl py-5">
        <div class="col-lg-8 mx-auto text-center mb-5">
            <h1 class="mb-2">{{ __('marketing.blog_title') }}</h1>
            <p class="fs-4 text-secondary">{{ __('marketing.blog_subtitle') }}</p>
        </div>

        <div class="col-lg-8 mx-auto d-flex flex-column gap-4">
            @foreach ($posts as $post)
                <div class="card">
                    <div class="card-body">
                        <div class="text-secondary small mb-1">
                            {{ __('marketing.blog_published_on', ['date' => \Illuminate\Support\Carbon::parse($post['published_at'])->translatedFormat('d M Y')]) }}
                        </div>
                        <h3 class="card-title">
                            <a href="{{ route('marketing.blog.show', $post['slug']) }}" class="text-body">{{ $post['title'] }}</a>
                        </h3>
                        <p class="text-secondary">{{ $post['excerpt'] }}</p>
                        <a href="{{ route('marketing.blog.show', $post['slug']) }}">{{ __('marketing.blog_read_more') }}</a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-marketing-layout>
