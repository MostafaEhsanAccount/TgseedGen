<?php

namespace Tests\Feature;

use Livewire\Livewire;
use Tests\TestCase;

class LiveCounterTest extends TestCase
{
    public function test_it_starts_at_zero(): void
    {
        Livewire::test('live-counter')
            ->assertSet('count', 0);
    }

    public function test_increment_and_decrement_update_the_count_without_a_page_reload(): void
    {
        Livewire::test('live-counter')
            ->call('increment')
            ->assertSet('count', 1)
            ->call('increment')
            ->assertSet('count', 2)
            ->call('decrement')
            ->assertSet('count', 1);
    }
}
