@props([
    'variant' => 'default', // success, warning, danger, info, default
    'icon' => null,
])

@php
    $variants = [
        'success' => 'bg-emerald-50 text-emerald-600 ring-1 ring-emerald-200',
        'warning' => 'bg-amber-50 text-amber-600 ring-1 ring-amber-200',
        'danger' => 'bg-rose-50 text-rose-600 ring-1 ring-rose-200',
        'info' => 'bg-blue-50 text-blue-600 ring-1 ring-blue-200',
        'default' => 'bg-gray-50 text-gray-600 ring-1 ring-gray-200',
        'purple' => 'bg-purple-50 text-purple-600 ring-1 ring-purple-200',
        'green' => 'bg-green-50 text-green-600 ring-1 ring-green-200',
        'orange' => 'bg-orange-50 text-orange-600 ring-1 ring-orange-200',
    ];
    $classes = $variants[$variant] ?? $variants['default'];
@endphp

<span class="text-xs px-2 py-0.5 rounded-full font-medium {{ $classes }} inline-flex items-center gap-1">
    @if ($icon)
        {!! $icon !!}
    @endif
    {{ $slot }}
</span>
