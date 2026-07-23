<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Response;

class BlogController extends Controller
{
    /**
     * Placeholder posts until the real content-management pages (Phase 6)
     * back this with a database table.
     *
     * @var array<string, array{title: string, excerpt: string, body: string, published_at: string}>
     */
    private const POSTS = [
        'organizing-your-sales-pipeline' => [
            'title' => 'Organizing Your Sales Pipeline',
            'excerpt' => 'A simple framework for moving leads from first contact to closed deal without losing track of anyone.',
            'body' => "A clear pipeline is the difference between a sales process and a pile of sticky notes. Start with a small number of stages that map to real decisions your team makes — new, contacted, interested, won, lost — and resist the urge to add more until you feel real pain from missing one.\n\nEvery stage change should leave a trace. If you can't answer \"who moved this lead, and when\", your pipeline is decoration, not a tool.",
            'published_at' => '2026-06-02',
        ],
        'automating-your-outreach-campaigns' => [
            'title' => 'Automating Your Outreach Campaigns',
            'excerpt' => 'Why sending one thoughtful message to the right segment beats blasting your entire list.',
            'body' => "Automation should remove busywork, not judgment. Segment your leads before you write a single message — by industry, by stage, by how they were sourced — and write for that segment specifically.\n\nTrack opens and clicks, but don't treat them as gospel. Use them to compare campaigns against each other, not as an absolute measure of interest.",
            'published_at' => '2026-06-16',
        ],
        'getting-started-with-lead-scoring' => [
            'title' => 'Getting Started with Lead Scoring',
            'excerpt' => 'You do not need machine learning to prioritize leads well — you need a short list of signals you already trust.',
            'body' => "Before reaching for anything automated, write down the three or four signals that, in your own experience, correlate with a lead actually converting. Company size, source, how quickly they replied — whatever it is for your business.\n\nStart by scoring manually for a few weeks. Once you trust the signals, encoding them into the system is the easy part.",
            'published_at' => '2026-07-01',
        ],
    ];

    public function index(): View
    {
        $posts = collect(self::POSTS)
            ->map(fn ($post, $slug) => ['slug' => $slug, ...$post])
            ->sortByDesc('published_at')
            ->values();

        return view('marketing.blog.index', ['posts' => $posts]);
    }

    public function show(string $slug): View|Response
    {
        if (! isset(self::POSTS[$slug])) {
            abort(404);
        }

        return view('marketing.blog.show', ['post' => ['slug' => $slug, ...self::POSTS[$slug]]]);
    }
}
