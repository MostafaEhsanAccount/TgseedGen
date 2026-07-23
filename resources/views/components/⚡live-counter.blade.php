<?php

use Livewire\Component;

new class extends Component
{
    public int $count = 0;

    public function increment(): void
    {
        $this->count++;
    }

    public function decrement(): void
    {
        $this->count--;
    }
};
?>

<div class="card card-sm">
    <div class="card-body d-flex align-items-center justify-content-between">
        <div>
            <div class="text-secondary small">Livewire — بدون أي تحميل صفحة</div>
            <div class="h1 mb-0">{{ $count }}</div>
        </div>
        <div class="btn-list">
            <button type="button" class="btn btn-outline-secondary" wire:click="decrement">-</button>
            <button type="button" class="btn btn-primary" wire:click="increment">+</button>
        </div>
    </div>
</div>
