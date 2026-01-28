@props([
    'icon' => null,
    'title',
    'subtitle' => null,
    'gradient' => 'from-gray-100 to-gray-200',
    'iconColor' => 'text-gray-400',
])

<div class="text-center py-10">
    <div
        class="w-20 h-20 bg-gradient-to-br {{ $gradient }} rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-inner">
        @if ($icon)
            {!! $icon !!}
        @else
            {{ $slot }}
        @endif
    </div>
    <h4 class="font-semibold text-gray-800 mb-1">{{ $title }}</h4>
    @if ($subtitle)
        <p class="text-sm text-gray-500">{{ $subtitle }}</p>
    @endif
</div>
