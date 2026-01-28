@php
    $sizes = [
        'sm' => 'w-32 h-32',
        'md' => 'w-48 h-48',
        'lg' => 'w-64 h-64',
    ];
@endphp

<div
    {{ $attributes->class([
        'flex items-center justify-center object-contain',
        $sizes[$size],
        'logo-animation' => $animated,
    ]) }}>
    <img src="{{ asset($src) }}" alt="{{ $alt }}">
</div>
