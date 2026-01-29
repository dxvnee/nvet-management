{{-- Absensi Button Component --}}
@props([
    'type' => 'hadir', // hadir, pulang, izin, lembur-masuk
    'disabled' => false,
    'onclick' => null,
    'label' => null,
])

@php
    $styles = [
        'hadir' => [
            'active' => 'bg-gradient-to-r from-emerald-500 to-green-600 hover:from-emerald-600 hover:to-green-700',
            'default_label' => 'Absen Hadir',
            'icon' => 'check',
        ],
        'pulang' => [
            'active' => 'bg-gradient-to-r from-blue-500 to-indigo-600 hover:from-blue-600 hover:to-indigo-700',
            'default_label' => 'Absen Pulang',
            'icon' => 'logout',
        ],
        'izin' => [
            'active' => 'bg-gradient-to-r from-amber-500 to-yellow-600 hover:from-amber-600 hover:to-yellow-700',
            'default_label' => 'Izin Tidak Masuk',
            'icon' => 'exclamation-triangle',
        ],
        'lembur-masuk' => [
            'active' => 'bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700',
            'default_label' => 'Masuk Lembur Hari Libur',
            'icon' => 'clock',
        ],
    ];

    $style = $styles[$type] ?? $styles['hadir'];
    $displayLabel = $label ?? $style['default_label'];
    $baseClasses =
        'group w-full py-3 px-6 rounded-2xl font-bold text-white transition-all duration-300 flex items-center justify-center gap-3';
    $activeClasses = "{$style['active']} shadow-lg hover:shadow-xl transform hover:scale-[1.02]";
    $disabledClasses = 'bg-gray-300 cursor-not-allowed';
@endphp

<button type="button" @if ($onclick) onclick="{{ $onclick }}" @endif
    @if ($disabled) disabled @endif
    {{ $attributes->merge(['class' => "{$baseClasses} " . ($disabled ? $disabledClasses : $activeClasses)]) }}>
    <div class="p-2 bg-white/20 rounded-xl group-hover:scale-110 transition-transform">
        @switch($style['icon'])
            @case('check')
                <x-icons.check class="h-6 w-6" />
            @break

            @case('logout')
                <x-icons.logout class="h-6 w-6" />
            @break

            @case('exclamation-triangle')
                <x-icons.exclamation-triangle class="h-6 w-6" />
            @break

            @case('clock')
                <x-icons.clock class="h-6 w-6" />
            @break
        @endswitch
    </div>
    <span>{{ $displayLabel }}</span>
</button>
