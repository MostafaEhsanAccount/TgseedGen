<x-marketing-layout>
    <div class="container-xl py-5">
        <div class="col-lg-8 mx-auto">
            <a href="{{ route('marketing.blog.index') }}" class="mb-3 d-inline-block">{{ __('marketing.blog_back_to_blog') }}</a>
            <div class="text-secondary small mb-1">
                {{ __('marketing.blog_published_on', ['date' => \Illuminate\Support\Carbon::parse($post['published_at'])->translatedFormat('d M Y')]) }}
            </div>
            <h1 class="mb-4">{{ $post['title'] }}</h1>
            <div class="fs-5" style="white-space: pre-line;">{{ $post['body'] }}</div>
        </div>
    </div>
</x-marketing-layout>
