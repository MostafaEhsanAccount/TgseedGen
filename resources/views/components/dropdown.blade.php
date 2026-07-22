@props(['align' => 'end'])

<div class="dropdown">
    <div data-bs-toggle="dropdown" aria-expanded="false" role="button">
        {{ $trigger }}
    </div>

    <div class="dropdown-menu dropdown-menu-{{ $align }}">
        {{ $content }}
    </div>
</div>
