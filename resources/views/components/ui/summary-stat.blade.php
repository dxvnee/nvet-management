{{-- Summary Stat Card Component --}}
@props([
    'value',
    'label',
    'color' => 'primary', // primary, success, danger, warning, info
    'icon' => null,
])

@php
    $colorClasses = [
        'primary' => 'from-primary to-primaryDark',
        'success' => 'from-emerald-500 to-green-600',
        'danger' => 'from-red-500 to-rose-600',
        'warning' => 'from-amber-500 to-yellow-600',
        'info' => 'from-blue-500 to-indigo-600',
    ];
@endphp

<div
    {{ $attributes->merge(['class' => 'bg-white rounded-2xl shadow-lg border border-gray-100 p-4 hover:shadow-xl transition-all duration-300']) }}>
    <div class="flex items-center gap-3">
        <div class="p-3 bg-gradient-to-br {{ $colorClasses[$color] }} rounded-xl shadow-lg">
            @if ($icon)
                {!! $icon !!}
            @elseif(isset($iconSlot))
                {{ $iconSlot }}
            @else
                <x-icons.chart-bar class="w-6 h-6 text-white" />
            @endif
        </div>
        <div>
            <p class="text-2xl font-bold text-gray-800">{{ $value }}</p>
            <p class="text-xs text-gray-500 uppercase tracking-wider">{{ $label }}</p>
        </div>
    </div>
</div>
