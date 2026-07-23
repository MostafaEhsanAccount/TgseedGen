<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MarketingPagesTest extends TestCase
{
    use RefreshDatabase;

    public function test_home_page_loads(): void
    {
        $this->get(route('marketing.home'))->assertOk();
    }

    public function test_home_page_defaults_to_ltr_english(): void
    {
        $this->get(route('marketing.home'))
            ->assertSee('lang="en" dir="ltr"', false);
    }

    public function test_features_page_loads(): void
    {
        $this->get(route('marketing.features'))->assertOk();
    }

    public function test_pricing_page_loads(): void
    {
        $this->get(route('marketing.pricing'))->assertOk();
    }

    public function test_contact_page_loads(): void
    {
        $this->get(route('marketing.contact'))->assertOk();
    }

    public function test_submitting_the_contact_form_succeeds(): void
    {
        $this->post(route('marketing.contact.submit'), [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'message' => 'Hello there',
        ])->assertRedirect(route('marketing.contact'));
    }

    public function test_submitting_the_contact_form_requires_an_email(): void
    {
        $this->post(route('marketing.contact.submit'), [
            'name' => 'Test User',
            'message' => 'Hello there',
        ])->assertSessionHasErrors('email');
    }

    public function test_terms_privacy_and_cookie_pages_load(): void
    {
        $this->get(route('marketing.terms'))->assertOk();
        $this->get(route('marketing.privacy'))->assertOk();
        $this->get(route('marketing.cookiePolicy'))->assertOk();
    }

    public function test_blog_index_lists_posts(): void
    {
        $this->get(route('marketing.blog.index'))
            ->assertOk()
            ->assertSee('Organizing Your Sales Pipeline');
    }

    public function test_blog_show_renders_a_valid_post(): void
    {
        $this->get(route('marketing.blog.show', 'organizing-your-sales-pipeline'))
            ->assertOk()
            ->assertSee('Organizing Your Sales Pipeline');
    }

    public function test_blog_show_404s_for_an_unknown_slug(): void
    {
        $this->get(route('marketing.blog.show', 'does-not-exist'))->assertNotFound();
    }
}
