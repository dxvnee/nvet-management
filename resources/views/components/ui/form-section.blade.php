{{-- Form Section Component --}}
@props(['title', 'icon' => null, 'bordered' => false])

<div {{ $attributes->merge(['class' => $bordered ? 'border-t pt-6' : '']) }}>
    <h4 class="text-lg font-semibold mb-4 flex items-center gap-2">
        @if ($icon)
            {!! $icon !!}
        @endif
        {{ $title }}
    </h4>
    {{ $slot }}
</div>
