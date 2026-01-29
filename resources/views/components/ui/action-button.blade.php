{{-- Action Button Component --}}
@props([
    'type' => 'button', // button, submit, link
    'variant' => 'primary', // primary, secondary, success, danger, warning, ghost
    'size' => 'md', // sm, md, lg
    'href' => null,
    'icon' => null,
    'disabled' => false,
])

@php
    $sizeClasses = [
        'sm' => 'px-3 py-1.5 text-xs gap-1.5',
        'md' => 'px-4 py-2 text-sm gap-2',
        'lg' => 'px-6 py-3 text-base gap-3',
    ];

    $variantClasses = [
        'primary' =>
            'bg-gradient-to-r from-primary to-primaryDark text-white hover:from-primaryDark hover:to-primary shadow-lg hover:shadow-xl',
        'secondary' =>
            'bg-white text-gray-700 border border-gray-200 hover:border-primary hover:text-primary shadow-sm hover:shadow-md',
        'success' =>
            'bg-gradient-to-r from-green-500 to-green-600 text-white hover:from-green-600 hover:to-green-700 shadow-lg hover:shadow-xl',
        'danger' =>
            'bg-gradient-to-r from-red-500 to-red-600 text-white hover:from-red-600 hover:to-red-700 shadow-lg hover:shadow-xl',
        'warning' =>
            'bg-gradient-to-r from-yellow-500 to-yellow-600 text-white hover:from-yellow-600 hover:to-yellow-700 shadow-lg hover:shadow-xl',
        'ghost' => 'bg-transparent text-gray-600 hover:text-primary hover:bg-gray-100',
        'icon-primary' => 'p-2 bg-primary/10 hover:bg-primary/20 text-primary rounded-lg',
        'icon-danger' => 'p-2 bg-red-100 hover:bg-red-200 text-red-600 rounded-lg',
        'icon-success' => 'p-2 bg-green-100 hover:bg-green-200 text-green-600 rounded-lg',
        'icon-info' => 'p-2 bg-blue-100 hover:bg-blue-200 text-blue-600 rounded-lg',
    ];

    $baseClasses = 'inline-flex items-center justify-center font-semibold rounded-xl transition-all duration-300';
    $disabledClasses = 'bg-gray-300 cursor-not-allowed text-gray-500';

    $classes = $disabled
        ? "{$baseClasses} {$sizeClasses[$size]} {$disabledClasses}"
        : "{$baseClasses} {$sizeClasses[$size]} {$variantClasses[$variant]}";
@endphp

@if ($type === 'link' && $href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>
        @if ($icon)
            {!! $icon !!}
        @endif
        {{ $slot }}
    </a>
@else
    <button type="{{ $type }}" {{ $disabled ? 'disabled' : '' }} {{ $attributes->merge(['class' => $classes]) }}>
        @if ($icon)
            {!! $icon !!}
        @endif
        {{ $slot }}
    </button>
@endif
