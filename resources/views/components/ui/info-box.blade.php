{{-- Info Box Component --}}
@props([
    'type' => null, // info, warning, success, danger (alias: color)
    'color' => null,
    'title' => null,
])

@php
    // Support both 'type' and 'color' props
    $infoType = $type ?? ($color ?? 'info');

    $typeStyles = [
        'info' => [
            'bg' => 'bg-gradient-to-r from-primary/5 to-primary/10 border-primary/20',
            'icon' => 'bg-primary/20 text-primary',
            'title' => 'text-primary',
            'text' => 'text-primary',
        ],
        'warning' => [
            'bg' => 'bg-yellow-50 border-yellow-200',
            'icon' => 'bg-yellow-100 text-yellow-600',
            'title' => 'text-yellow-800',
            'text' => 'text-yellow-700',
        ],
        'success' => [
            'bg' => 'bg-green-50 border-green-200',
            'icon' => 'bg-green-100 text-green-600',
            'title' => 'text-green-800',
            'text' => 'text-green-700',
        ],
        'danger' => [
            'bg' => 'bg-red-50 border-red-200',
            'icon' => 'bg-red-100 text-red-600',
            'title' => 'text-red-800',
            'text' => 'text-red-700',
        ],
    ];

    $styles = $typeStyles[$infoType] ?? $typeStyles['info'];
@endphp

<div {{ $attributes->merge(['class' => "rounded-2xl p-4 border shadow-sm {$styles['bg']}"]) }}>
    <div class="flex items-start gap-3">
        @if (isset($icon))
            <div class="p-2 rounded-xl flex-shrink-0 {{ $styles['icon'] }}">
                {{ $icon }}
            </div>
        @else
            <div class="p-2 rounded-xl flex-shrink-0 {{ $styles['icon'] }}">
                @switch($infoType)
                    @case('warning')
                        <x-icons.exclamation-triangle class="w-5 h-5" />
                    @break

                    @case('success')
                        <x-icons.check class="w-5 h-5" />
                    @break

                    @case('danger')
                        <x-icons.x-mark class="w-5 h-5" />
                    @break

                    @default
                        <x-icons.information-circle class="w-5 h-5" />
                @endswitch
            </div>
        @endif
        <div class="flex-1">
            @if ($title)
                <h3 class="font-semibold mb-1 {{ $styles['title'] }}">{{ $title }}</h3>
            @endif
            <div class="text-sm {{ $styles['text'] }}">
                {{ $slot }}
            </div>
        </div>
    </div>
</div>
