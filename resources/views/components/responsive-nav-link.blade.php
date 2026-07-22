@props(['active'])

<a {{ $attributes->merge(['class' => 'list-group-item list-group-item-action' . (($active ?? false) ? ' active' : '')]) }}>
    {{ $slot }}
</a>
