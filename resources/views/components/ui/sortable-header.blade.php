{{-- Sortable Table Header Component --}}
@props([
    'column',
    'label',
    'currentSort' => null,
    'currentDirection' => null,
    'align' => 'left', // left, center, right
])

@php
    $isActive = $currentSort === $column;
    $newDirection = $isActive && $currentDirection === 'asc' ? 'desc' : 'asc';

    $alignClasses = [
        'left' => 'justify-start',
        'center' => 'justify-center',
        'right' => 'justify-end',
    ];
@endphp

<th class="py-3 px-4 font-semibold text-gray-600">
    <a href="{{ request()->fullUrlWithQuery(['sort_by' => $column, 'sort_direction' => $newDirection]) }}"
        class="flex items-center {{ $alignClasses[$align] }} space-x-1 hover:text-primary transition-colors">
        <span>{{ $label }}</span>
        @if ($isActive)
            @if ($currentDirection === 'asc')
                <x-icons.chevron-up class="w-4 h-4 text-primary" />
            @else
                <x-icons.chevron-down class="w-4 h-4 text-primary" />
            @endif
        @else
            <x-icons.chevron-up-down class="w-4 h-4 text-gray-400" />
        @endif
    </a>
</th>
