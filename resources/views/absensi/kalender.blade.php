<x-app-layout>
    <x-slot name="header">Kalender Absensi</x-slot>
    <x-slot name="subtle">Pantau absensi pegawai dalam format kalender</x-slot>

    <div class="space-y-6">
        {{-- Navigation Bulan/Tahun --}}
        <x-ui.section-card>
            <div class="flex flex-col md:flex-row items-center justify-between mb-6 gap-4">
                <h2 class="text-xl md:text-2xl font-bold text-gray-800">
                    {{ \Carbon\Carbon::create($tahun, $bulan)->format('F Y') }}
                </h2>
                <div class="flex flex-col sm:flex-row gap-4 w-full md:w-auto items-center">
                    {{-- Month/Year Selector --}}
                    <form method="GET" action="{{ route('absen.kalender') }}"
                        class="flex flex-col md:flex-row gap-2 w-full sm:w-auto">
                        <div class="flex gap-2 w-full sm:w-auto">
                            <select name="bulan"
                                class="flex-1 sm:flex-none px-3 py-2 rounded-lg border border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all min-w-[140px] text-center sm:text-left">
                                @for ($m = 1; $m <= 12; $m++)
                                    <option value="{{ $m }}" {{ $m == $bulan ? 'selected' : '' }}>
                                        {{ \Carbon\Carbon::create(null, $m)->format('F') }}
                                    </option>
                                @endfor
                            </select>
                            <select name="tahun"
                                class="flex-1 sm:flex-none px-3 py-2 rounded-lg border border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all min-w-[100px] text-center sm:text-left">
                                @for ($y = date('Y') - 2; $y <= date('Y') + 2; $y++)
                                    <option value="{{ $y }}" {{ $y == $tahun ? 'selected' : '' }}>
                                        {{ $y }}
                                    </option>
                                @endfor
                            </select>
                        </div>
                        <x-ui.action-button type="submit" variant="primary" class="w-full sm:w-auto">
                            Tampilkan
                        </x-ui.action-button>
                    </form>
                </div>
            </div>

            {{-- Kalender Grid --}}
            <div class="grid grid-cols-7 gap-1 md:gap-2">
                {{-- Header Hari --}}
                @foreach (['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'] as $hari)
                    <div
                        class="p-2 md:p-3 text-center font-semibold text-gray-600 bg-gray-50 rounded-lg text-xs md:text-base">
                        <span class="md:hidden">{{ substr($hari, 0, 1) }}</span>
                        <span class="hidden md:inline">{{ $hari }}</span>
                    </div>
                @endforeach

                {{-- Days --}}
                @php
                    $startOfMonth = \Carbon\Carbon::create($tahun, $bulan, 1);
                    $endOfMonth = \Carbon\Carbon::create($tahun, $bulan)->endOfMonth();
                    $startDayOfWeek = $startOfMonth->dayOfWeek;
                @endphp

                {{-- Empty cells before first day --}}
                @for ($i = 0; $i < $startDayOfWeek; $i++)
                    <div class="p-2 md:p-3 bg-gray-50 rounded-lg"></div>
                @endfor

                {{-- Days of month --}}
                @for ($day = 1; $day <= $endOfMonth->day; $day++)
                    @php
                        $currentDate = \Carbon\Carbon::create($tahun, $bulan, $day);
                        $dateKey = $currentDate->format('Y-m-d');
                        $dayData = $kalenderData[$dateKey] ?? null;
                        $isToday = $currentDate->isToday();
                        $isWeekend = $currentDate->isWeekend();
                        $publicHoliday = $dayData['public_holiday'] ?? null;
                    @endphp

                    <a href="{{ route('absen.detailHari', $dateKey) }}" class="block group h-full">
                        <div
                            class="h-full min-h-[80px] md:min-h-[100px] p-1 md:p-2 rounded-lg border flex flex-col justify-between
                            {{ $isToday ? 'border-primary bg-primaryExtraLight' : 'border-gray-200 bg-white' }}
                            {{ $isWeekend ? 'bg-gray-50' : '' }}
                            {{ $publicHoliday ? 'bg-red-50 border-red-200' : '' }}
                            hover:shadow-md hover:border-primary hover:scale-[1.01] active:scale-[0.98] transition-all duration-200 relative overflow-hidden">

                            {{-- Public Holiday Badge --}}
                            @if ($publicHoliday)
                                <div
                                    class="absolute top-0 left-0 right-0 bg-red-500 text-white text-[8px] md:text-[10px] text-center py-0.5 font-medium truncate px-1">
                                    {{ $publicHoliday->nama }}
                                </div>
                            @endif

                            {{-- Date Number --}}
                            <div class="text-right mb-1 {{ $publicHoliday ? 'mt-3 md:mt-4' : '' }}">
                                <span
                                    class="inline-flex items-center justify-center w-6 h-6 md:w-7 md:h-7 rounded-full text-xs md:text-sm font-medium
                                    {{ $isToday ? 'bg-primary text-white font-bold' : ($publicHoliday ? 'text-red-600' : 'text-gray-700') }}">
                                    {{ $day }}
                                </span>
                            </div>

                            {{-- Content --}}
                            @if ($dayData && $dayData['total_absen'] > 0)
                                {{-- Desktop View --}}
                                <div class="hidden md:block">
                                    <div class="text-xs font-semibold text-primary mb-1 text-center">
                                        {{ $dayData['total_absen'] }} Absen
                                    </div>
                                    <div class="flex flex-wrap justify-center gap-1 text-[10px]">
                                        @if ($dayData['hadir_tepat_waktu'] > 0)
                                            <span class="px-1.5 py-0.5 bg-green-100 text-green-700 rounded-full"
                                                title="Tepat Waktu">
                                                ✓ {{ $dayData['hadir_tepat_waktu'] }}
                                            </span>
                                        @endif
                                        @if ($dayData['hadir_terlambat'] > 0)
                                            <span class="px-1.5 py-0.5 bg-yellow-100 text-yellow-700 rounded-full"
                                                title="Terlambat">
                                                ⚠ {{ $dayData['hadir_terlambat'] }}
                                            </span>
                                        @endif
                                        @if ($dayData['izin'] > 0)
                                            <span class="px-1.5 py-0.5 bg-yellow-100 text-yellow-700 rounded-full"
                                                title="Izin">
                                                📝 {{ $dayData['izin'] }}
                                            </span>
                                        @endif
                                        @if ($dayData['libur'] > 0)
                                            <span class="px-1.5 py-0.5 bg-blue-500 text-white rounded-full"
                                                title="Libur">
                                                🌴 {{ $dayData['libur'] }}
                                            </span>
                                        @endif
                                        @if ($dayData['tidak_hadir'] > 0)
                                            <span class="px-1.5 py-0.5 bg-gray-500 text-white rounded-full"
                                                title="Tidak Hadir">
                                                ✗ {{ $dayData['tidak_hadir'] }}
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                {{-- Mobile View (Dots) --}}
                                <div class="flex md:hidden justify-center gap-1 mt-auto pb-1">
                                    @if ($dayData['hadir_tepat_waktu'] > 0)
                                        <div class="w-2 h-2 rounded-full bg-green-500"></div>
                                    @endif
                                    @if ($dayData['hadir_terlambat'] > 0)
                                        <div class="w-2 h-2 rounded-full bg-red-500"></div>
                                    @endif
                                    @if ($dayData['izin'] > 0)
                                        <div class="w-2 h-2 rounded-full bg-yellow-500"></div>
                                    @endif
                                    @if ($dayData['libur'] > 0)
                                        <div class="w-2 h-2 rounded-full bg-blue-500"></div>
                                    @endif
                                </div>
                            @else
                                <div class="flex-1"></div>
                            @endif
                        </div>
                    </a>
                @endfor
            </div>

            {{-- Legend --}}
            <div class="mt-6 p-4 bg-gray-50 rounded-xl">
                <h3 class="text-sm font-semibold text-gray-700 mb-3">Keterangan:</h3>
                <div class="flex flex-wrap gap-4 text-xs">
                    <div class="flex items-center gap-2">
                        <div class="w-3 h-3 rounded-full bg-green-500"></div>
                        <span class="text-gray-600">Tepat Waktu</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="w-3 h-3 rounded-full bg-yellow-500"></div>
                        <span class="text-gray-600">Terlambat/Izin</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="w-3 h-3 rounded-full bg-blue-500"></div>
                        <span class="text-gray-600">Libur</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="w-3 h-3 rounded-full bg-gray-500"></div>
                        <span class="text-gray-600">Tidak Hadir</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="w-3 h-3 rounded-full bg-red-500"></div>
                        <span class="text-gray-600">Hari Libur Nasional</span>
                    </div>
                </div>
            </div>
        </x-ui.section-card>
    </div>
</x-app-layout>
