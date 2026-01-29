{{-- Page Hero Component --}}
@props(['title', 'subtitle' => null, 'animation' => 'animate-slide-up'])

<div
    {{ $attributes->merge(['class' => "relative overflow-hidden bg-gradient-to-br from-primary via-primaryDark to-primary rounded-3xl shadow-2xl p-6 md:p-8 text-white {$animation}"]) }}>
    {{-- Background Pattern --}}
    <div class="absolute inset-0 opacity-10">
        <div class="absolute -top-10 -right-10 w-40 h-40 bg-white rounded-full"></div>
        <div class="absolute -bottom-10 -left-10 w-32 h-32 bg-white rounded-full"></div>
        <div class="absolute top-1/2 left-1/3 w-20 h-20 bg-white rounded-full"></div>
    </div>

    <div class="relative flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
        <div class="flex items-center gap-4">
            @if (isset($icon))
                <div class="p-4 bg-white/20 backdrop-blur-sm rounded-2xl">
                    {{ $icon }}
                </div>
            @endif
            <div>
                <h2 class="text-2xl md:text-3xl font-bold mb-1">{{ $title }}</h2>
                @if ($subtitle)
                    <p class="text-white/80 text-sm md:text-base flex items-center gap-2">
                        {{ $subtitle }}
                    </p>
                @endif
            </div>
        </div>
        @if (isset($actions))
            <div class="flex items-center gap-4">
                {{ $actions }}
            </div>
        @endif
    </div>
</div>
