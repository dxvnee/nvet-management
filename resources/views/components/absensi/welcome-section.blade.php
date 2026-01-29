{{-- Absensi Welcome Section Component --}}
@props([
    'title' => 'Absensi Kehadiran',
    'showClock' => true,
    'showDate' => true,
])

<div
    {{ $attributes->merge(['class' => 'relative overflow-hidden bg-gradient-to-br from-primary via-primaryDark to-primary rounded-3xl shadow-2xl p-6 md:p-8 text-white animate-slide-up']) }}>
    {{-- Background Pattern --}}
    <div class="absolute inset-0 opacity-10">
        <div class="absolute -top-10 -right-10 w-40 h-40 bg-white rounded-full"></div>
        <div class="absolute -bottom-10 -left-10 w-32 h-32 bg-white rounded-full"></div>
        <div class="absolute top-1/2 left-1/3 w-20 h-20 bg-white rounded-full"></div>
    </div>

    <div class="relative flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
        <div class="flex items-center gap-4">
            <div class="p-4 bg-white/20 backdrop-blur-sm rounded-2xl">
                <x-icons.clock class="w-8 h-8 md:w-10 md:h-10 text-white" />
            </div>
            <div>
                <h2 class="text-xl md:text-2xl font-bold mb-1">{{ $title }}</h2>
                @if ($showDate)
                    <p class="text-white/80 text-sm md:text-base flex items-center gap-2">
                        <x-icons.calendar class="w-4 h-4" />
                        <span id="current-datetime">{{ now()->locale('id')->isoFormat('dddd, D MMMM Y') }}</span>
                    </p>
                @endif
            </div>
        </div>
        @if ($showClock)
            <div class="flex items-center gap-4">
                <div class="text-right bg-white/10 backdrop-blur-sm rounded-2xl px-4 md:px-6 py-3">
                    <p class="text-white/70 text-xs uppercase tracking-wider mb-1">Waktu Sekarang</p>
                    <p class="text-2xl md:text-3xl font-bold font-mono" x-data="{ time: '' }" x-init="setInterval(() => time = new Date().toLocaleTimeString('id-ID'), 1000)"
                        x-text="time"></p>
                </div>
            </div>
        @endif
    </div>
</div>
