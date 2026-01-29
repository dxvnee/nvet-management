{{-- Absensi Time Card Component --}}
@props([
    'type' => 'masuk', // masuk, pulang
    'absen' => null,
    'sudahPulang' => null,
    'time' => null,
    'isActive' => null,
    'telatMinutes' => null,
    'shiftNumber' => null,
])

@php
    // Auto-detect values from absen object if provided
    if ($absen) {
        if ($type === 'masuk') {
            $time = $time ?? ($absen->jam_masuk ? $absen->jam_masuk->format('H:i') : null);
            $isActive = $isActive ?? (bool) $absen->jam_masuk;
            $telatMinutes = $telatMinutes ?? ($absen->telat ? $absen->menit_telat : null);
            $shiftNumber = $shiftNumber ?? $absen->shift_number;
        } else {
            $time = $time ?? ($sudahPulang && $absen->jam_pulang ? $absen->jam_pulang->format('H:i') : null);
            $isActive = $isActive ?? (bool) $sudahPulang;
        }
    }

    $isActive = $isActive ?? false;

    $styles = [
        'masuk' => [
            'active_bg' => 'bg-gradient-to-br from-emerald-50 to-green-50 border-emerald-200 shadow-sm',
            'inactive_bg' => 'bg-gradient-to-br from-gray-50 to-gray-100 border-gray-200',
            'active_icon' => 'bg-gradient-to-br from-emerald-500 to-green-600',
            'inactive_icon' => 'bg-gray-300',
            'active_title' => 'text-emerald-700',
            'inactive_title' => 'text-gray-500',
            'active_text' => 'text-emerald-600',
            'inactive_text' => 'text-gray-400',
            'label' => 'Hadir',
        ],
        'pulang' => [
            'active_bg' => 'bg-gradient-to-br from-blue-50 to-indigo-50 border-blue-200 shadow-sm',
            'inactive_bg' => 'bg-gradient-to-br from-gray-50 to-gray-100 border-gray-200',
            'active_icon' => 'bg-gradient-to-br from-blue-500 to-indigo-600',
            'inactive_icon' => 'bg-gray-300',
            'active_title' => 'text-blue-700',
            'inactive_title' => 'text-gray-500',
            'active_text' => 'text-blue-600',
            'inactive_text' => 'text-gray-400',
            'label' => 'Pulang',
        ],
    ];

    $style = $styles[$type];
    $bgClass = $isActive ? $style['active_bg'] : $style['inactive_bg'];
    $iconClass = $isActive ? $style['active_icon'] : $style['inactive_icon'];
    $titleClass = $isActive ? $style['active_title'] : $style['inactive_title'];
    $textClass = $isActive ? $style['active_text'] : $style['inactive_text'];
@endphp

<div {{ $attributes->merge(['class' => "group p-5 rounded-2xl border-2 transition-all duration-300 {$bgClass}"]) }}>
    <div class="flex items-center gap-4">
        <div class="p-3 rounded-xl shadow-lg transition-transform group-hover:scale-105 {{ $iconClass }}">
            @if ($type === 'masuk')
                <x-icons.check class="h-6 w-6 text-white" />
            @else
                <x-icons.logout class="h-6 w-6 text-white" />
            @endif
        </div>
        <div class="flex-1">
            <div class="flex items-center gap-2 flex-wrap">
                <p class="font-bold text-lg {{ $titleClass }}">{{ $style['label'] }}</p>
                @if ($shiftNumber && $type === 'masuk')
                    <span
                        class="text-xs px-2.5 py-1 rounded-full font-bold shadow-sm
                        {{ (int) $shiftNumber === 1 ? 'bg-gradient-to-r from-blue-500 to-blue-600 text-white' : 'bg-gradient-to-r from-orange-500 to-orange-600 text-white' }}">
                        Shift {{ $shiftNumber }}
                    </span>
                @endif
            </div>
            @if ($isActive && $time)
                <p class="text-sm mt-1 flex items-center gap-1 {{ $textClass }}">
                    <x-icons.clock class="w-4 h-4" />
                    <span class="font-semibold">{{ $time }}</span>
                    @if ($telatMinutes && $type === 'masuk')
                        <span class="ml-1 px-2 py-0.5 rounded-full text-xs font-bold bg-rose-100 text-rose-600">
                            TELAT {{ $telatMinutes }}m
                        </span>
                    @endif
                </p>
            @else
                <p class="text-sm mt-1 {{ $textClass }}">Belum {{ strtolower($style['label']) }}</p>
            @endif
        </div>
    </div>
</div>
