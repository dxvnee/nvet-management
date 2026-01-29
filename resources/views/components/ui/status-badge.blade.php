{{-- Status Badge Component --}}
@props([
    'type' => 'default', // hadir, tepat_waktu, telat, izin, libur, tidak_hadir, default
    'size' => 'sm' // sm, md, lg
])

@php
    $sizeClasses = [
        'sm' => 'px-2.5 py-1 text-xs',
        'md' => 'px-3 py-1.5 text-sm',
        'lg' => 'px-4 py-2 text-base'
    ];

    $typeClasses = [
        'hadir' => 'bg-emerald-50 text-emerald-600 ring-1 ring-emerald-200',
        'tepat_waktu' => 'bg-green-100 text-green-700',
        'telat' => 'bg-red-100 text-red-700',
        'izin' => 'bg-amber-50 text-amber-600 ring-1 ring-amber-200',
        'libur' => 'bg-blue-50 text-blue-600 ring-1 ring-blue-200',
        'tidak_hadir' => 'bg-gray-50 text-gray-600 ring-1 ring-gray-200',
        'default' => 'bg-gray-100 text-gray-700',
        'success' => 'bg-green-100 text-green-700',
        'warning' => 'bg-yellow-100 text-yellow-700',
        'danger' => 'bg-red-100 text-red-700',
        'info' => 'bg-blue-100 text-blue-700',
        'primary' => 'bg-primary text-white shadow-sm',
    ];

    $baseClasses = 'inline-flex items-center gap-1 rounded-full font-semibold';
@endphp

<span {{ $attributes->merge(['class' => "$baseClasses " . $sizeClasses[$size] . " " . ($typeClasses[$type] ?? $typeClasses['default'])]) }}>
    {{ $slot }}
</span>
