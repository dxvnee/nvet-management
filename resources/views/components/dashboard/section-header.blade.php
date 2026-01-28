@props([
    'title',
    'subtitle' => null,
    'gradient' => 'from-primary to-primaryDark',
    'linkHref' => null,
    'linkText' => 'Lihat Semua',
])

<div class="flex items-center justify-between mb-6">
    <div class="flex items-center gap-3">
        <div class="p-2.5 bg-gradient-to-br {{ $gradient }} rounded-xl shadow-md">
            {{ $icon ?? '' }}
        </div>
        <div>
            <h3 class="text-lg font-bold text-gray-800">{{ $title }}</h3>
            @if ($subtitle)
                <p class="text-xs text-gray-500">{{ $subtitle }}</p>
            @endif
        </div>
    </div>
    <div class="flex items-center gap-4">
        @if (isset($extra))
            {{ $extra }}
        @endif
        @if ($linkHref)
            <a href="{{ $linkHref }}"
                class="inline-flex items-center gap-1 text-primary hover:text-primaryDark text-sm font-medium transition-colors group">
                {{ $linkText }}
                <x-icons.arrow-right class="w-4 h-4 group-hover:translate-x-1 transition-transform" />
            </a>
        @endif
    </div>
</div>
