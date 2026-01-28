@props([
    'title',
    'value',
    'icon' => null,
    'gradient' => 'from-primary to-primaryDark',
    'hoverBorder' => 'hover:border-primary/20',
    'valueColor' => 'bg-gradient-to-r from-primary to-primaryDark bg-clip-text text-transparent',
    'delay' => '1',
    'pulse' => false,
])

<div
    class="group bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-500 p-5 lg:p-6 border border-gray-100 {{ $hoverBorder }} animate-slide-up-delay-{{ $delay }}">
    <div class="flex items-center justify-between mb-4">
        <div
            class="p-3 bg-gradient-to-br {{ $gradient }} rounded-xl shadow-lg group-hover:scale-110 transition-transform duration-300 {{ $pulse ? 'animate-pulse' : '' }}">
            @if ($icon)
                {!! $icon !!}
            @else
                {{ $slot }}
            @endif
        </div>
        <div class="text-right">
            <span class="text-3xl lg:text-4xl font-bold {{ $valueColor }}">{{ $value }}</span>
        </div>
    </div>
    <h3 class="text-xs lg:text-sm font-semibold text-gray-500 uppercase tracking-wider">{{ $title }}</h3>
    @if (isset($footer))
        <div class="mt-3">
            {{ $footer }}
        </div>
    @endif
</div>
