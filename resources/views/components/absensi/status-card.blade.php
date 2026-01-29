{{-- Absensi Status Card Component --}}
@props([
    'type' => 'inactive', // inactive, libur, izin, hadir, pulang
    'title' => null,
    'subtitle' => null,
    'extraInfo' => null,
    'namaHariLibur' => null
])

@php
    $styles = [
        'inactive' => [
            'bg' => 'bg-gradient-to-br from-red-50 to-rose-50 border-red-300',
            'icon_bg' => 'bg-gradient-to-br from-red-500 to-rose-600',
            'title' => 'text-red-700',
            'subtitle' => 'text-red-600',
            'default_title' => 'Status: Inactive'
        ],
        'libur' => [
            'bg' => 'bg-gradient-to-br from-blue-50 to-indigo-50 border-blue-200',
            'icon_bg' => 'bg-gradient-to-br from-blue-500 to-indigo-600',
            'title' => 'text-blue-700',
            'subtitle' => 'text-blue-600',
            'default_title' => 'Hari Libur'
        ],
        'izin' => [
            'bg' => 'bg-gradient-to-br from-amber-50 to-yellow-50 border-amber-200',
            'icon_bg' => 'bg-gradient-to-br from-amber-500 to-yellow-600',
            'title' => 'text-amber-700',
            'subtitle' => 'text-amber-600',
            'default_title' => 'Sedang Izin'
        ],
        'hadir' => [
            'bg' => 'bg-gradient-to-br from-emerald-50 to-green-50 border-emerald-200',
            'icon_bg' => 'bg-gradient-to-br from-emerald-500 to-green-600',
            'title' => 'text-emerald-700',
            'subtitle' => 'text-emerald-600',
            'default_title' => 'Hadir'
        ],
        'pulang' => [
            'bg' => 'bg-gradient-to-br from-blue-50 to-indigo-50 border-blue-200',
            'icon_bg' => 'bg-gradient-to-br from-blue-500 to-indigo-600',
            'title' => 'text-blue-700',
            'subtitle' => 'text-blue-600',
            'default_title' => 'Pulang'
        ]
    ];

    $style = $styles[$type] ?? $styles['inactive'];
    $displayTitle = $title ?? $style['default_title'];

    // Append holiday name if provided
    if ($type === 'libur' && $namaHariLibur) {
        $displayTitle = $displayTitle . ' - ' . $namaHariLibur;
    }
@endphp

<div {{ $attributes->merge(['class' => "w-full p-6 rounded-2xl border-2 mb-6 shadow-sm {$style['bg']}"]) }}>
    <div class="flex items-center gap-4">
        <div class="p-4 rounded-2xl shadow-lg {{ $style['icon_bg'] }}">
            @if(isset($icon))
                {{ $icon }}
            @else
                @switch($type)
                    @case('inactive')
                        <x-icons.no-symbol class="h-8 w-8 text-white" />
                        @break
                    @case('libur')
                        <x-icons.sun class="h-8 w-8 text-white" />
                        @break
                    @case('izin')
                        <x-icons.exclamation-triangle class="h-8 w-8 text-white" />
                        @break
                    @case('hadir')
                        <x-icons.check class="h-8 w-8 text-white" />
                        @break
                    @case('pulang')
                        <x-icons.logout class="h-8 w-8 text-white" />
                        @break
                @endswitch
            @endif
        </div>
        <div class="flex-1">
            <p class="text-xl font-bold {{ $style['title'] }}">{{ $displayTitle }}</p>
            @if($subtitle)
                <p class="text-sm mt-1 {{ $style['subtitle'] }}">{{ $subtitle }}</p>
            @endif
            @if(trim($slot ?? ''))
                <p class="text-sm mt-1 {{ $style['subtitle'] }}">{{ $slot }}</p>
            @endif
            @if($extraInfo)
                <div class="mt-3 p-3 bg-white/70 rounded-lg border border-current/10">
                    {{ $extraInfo }}
                </div>
            @endif
        </div>
    </div>
</div>
