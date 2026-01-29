{{-- Back Button Component --}}
@props([
    'href' => null,
    'label' => 'Kembali',
    'animation' => 'animate-slide-up',
])

<a href="{{ $href ?? url()->previous() }}"
    {{ $attributes->merge(['class' => "inline-flex items-center gap-2 text-gray-600 hover:text-primary transition-colors {$animation}"]) }}>
    <x-icons.arrow-left class="w-5 h-5" />
    {{ $label }}
</a>
