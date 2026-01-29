{{-- Form Checkbox Component --}}
@props([
    'name',
    'label',
    'value' => '1',
    'checked' => false,
    'color' => 'primary', // primary, red, blue, green, gray
    'description' => null,
])

@php
    $colorClasses = [
        'primary' => 'text-primary focus:ring-primary',
        'red' => 'text-red-500 focus:ring-red-500',
        'blue' => 'text-blue-500 focus:ring-blue-500',
        'green' => 'text-green-500 focus:ring-green-500',
        'gray' => 'text-gray-500 focus:ring-gray-500',
    ];
@endphp

<div class="space-y-1">
    <div class="flex items-center">
        <input type="hidden" name="{{ $name }}" value="0">
        <input type="checkbox" name="{{ $name }}" id="{{ $name }}" value="{{ $value }}"
            {{ $checked || old($name) ? 'checked' : '' }}
            {{ $attributes->merge(['class' => "h-4 w-4 border-gray-300 rounded {$colorClasses[$color]}"]) }}>
        <label for="{{ $name }}" class="ml-2 block text-sm text-gray-900">
            {{ $label }}
        </label>
    </div>
    @if ($description)
        <p class="text-xs text-gray-500 ml-6">{{ $description }}</p>
    @endif
</div>
