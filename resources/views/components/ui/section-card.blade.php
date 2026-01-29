{{-- Section Card Component --}}
@props([
    'title' => null,
    'subtitle' => null,
    'icon' => null,
    'animation' => '',
])

<div {{ $attributes->merge(['class' => "bg-white rounded-2xl shadow-xl p-6 {$animation}"]) }}>
    @if ($title || isset($header))
        <div class="flex items-center gap-3 mb-6">
            @if ($icon)
                <div class="p-3 bg-gradient-to-br from-primary to-primaryDark rounded-xl shadow-lg">
                    {!! $icon !!}
                </div>
            @elseif(isset($iconSlot))
                <div class="p-3 bg-gradient-to-br from-primary to-primaryDark rounded-xl shadow-lg">
                    {{ $iconSlot }}
                </div>
            @endif
            @if (isset($header))
                {{ $header }}
            @else
                <div>
                    <h2 class="text-xl font-bold text-gray-800">{{ $title }}</h2>
                    @if ($subtitle)
                        <p class="text-gray-500 text-sm">{{ $subtitle }}</p>
                    @endif
                </div>
            @endif
        </div>
    @endif

    {{ $slot }}
</div>
