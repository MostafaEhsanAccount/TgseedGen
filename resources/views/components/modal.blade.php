@props([
    'name',
    'show' => false,
])

<div class="modal fade" id="{{ $name }}" tabindex="-1" aria-hidden="true" @if($show) data-autoshow="1" @endif>
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            {{ $slot }}
        </div>
    </div>
</div>

@if ($show)
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var el = document.getElementById(@json($name));
            if (el) { bootstrap.Modal.getOrCreateInstance(el).show(); }
        });
    </script>
@endif
