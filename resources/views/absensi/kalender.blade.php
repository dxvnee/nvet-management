<x-app-layout>
    <x-slot name="header">Kalender Absensi</x-slot>
    <x-slot name="subtle">Pantau absensi pegawai dalam format kalender</x-slot>

    <div class="space-y-6">
        {{-- Navigation Bulan/Tahun --}}
        <div class="bg-white rounded-2xl shadow-xl p-4 md:p-6">
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
                                @for($m = 1; $m <= 12; $m++)
                                    <option value="{{ $m }}" {{ $m == $bulan ? 'selected' : '' }}>
                                        {{ \Carbon\Carbon::create(null, $m)->format('F') }}
                                    </option>
                                @endfor
                            </select>
                            <select name="tahun"
                                class="flex-1 sm:flex-none px-3 py-2 rounded-lg border border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all min-w-[100px] text-center sm:text-left">
                                @for($y = date('Y') - 2; $y <= date('Y') + 2; $y++)
                                    <option value="{{ $y }}" {{ $y == $tahun ? 'selected' : '' }}>
                                        {{ $y }}
                                    </option>
                                @endfor
                            </select>
                        </div>
                        <button type="submit"
                            class="w-full sm:w-auto px-4 py-2 bg-primary hover:bg-primaryDark text-white font-semibold rounded-lg transition-all whitespace-nowrap">
                            Tampilkan
                        </button>
                    </form>
                </div>
            </div>

            {{-- Kalender Grid --}}
            <div class="grid grid-cols-7 gap-1 md:gap-2">
                {{-- Header Hari --}}
                @foreach(['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'] as $hari)
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
                    $startDayOfWeek = $startOfMonth->dayOfWeek; // 0 = Sunday, 1 = Monday, etc.
                @endphp

                {{-- Empty cells before first day --}}
                @for($i = 0; $i < $startDayOfWeek; $i++)
                    <div class="p-2 md:p-3 bg-gray-50 rounded-lg"></div>
                @endfor

                {{-- Days of month --}}
                @for($day = 1; $day <= $endOfMonth->day; $day++)
                    @php
                        $currentDate = \Carbon\Carbon::create($tahun, $bulan, $day);
                        $dateKey = $currentDate->format('Y-m-d');
                        $dayData = $kalenderData[$dateKey] ?? null;
                        $isToday = $currentDate->isToday();
                        $isWeekend = $currentDate->isWeekend();
                    @endphp

                    <a href="{{ route('absen.detailHari', $dateKey) }}" class="block group h-full">
                        <div
                            class="h-full min-h-[80px] md:min-h-[100px] p-1 md:p-2 rounded-lg border flex flex-col justify-between
                                        {{ $isToday ? 'border-primary bg-primaryExtraLight' : 'border-gray-200 bg-white' }}
                                        {{ $isWeekend ? 'bg-gray-50' : '' }}
                                        hover:shadow-md hover:border-primary hover:scale-[1.01] active:scale-[0.98] transition-all duration-200 relative overflow-hidden">

                            {{-- Date Number --}}
                            <div class="text-right mb-1">
                                <span class="inline-flex items-center justify-center w-6 h-6 md:w-7 md:h-7 rounded-full text-xs md:text-sm font-medium
                                                {{ $isToday ? 'bg-primary text-white font-bold' : 'text-gray-700' }}">
                                    {{ $day }}
                                </span>
                            </div>

                            {{-- Content --}}
                            @if($dayData && $dayData['total_absen'] > 0)
                                {{-- Desktop View --}}
                                <div class="hidden md:block">
                                    <div class="text-xs font-semibold text-primary mb-1 text-center">
                                        {{ $dayData['total_absen'] }} Absen
                                    </div>
                                    <div class="flex flex-wrap justify-center gap-1 text-[10px]">
                                        @if($dayData['hadir_tepat_waktu'] > 0)
                                            <span class="px-1.5 py-0.5 bg-green-100 text-green-700 rounded-full"
                                                title="Tepat Waktu">
                                                ✓ {{ $dayData['hadir_tepat_waktu'] }}
                                            </span>
                                        @endif
                                        @if($dayData['hadir_terlambat'] > 0)
                                            <span class="px-1.5 py-0.5 bg-yellow-100 text-yellow-700 rounded-full"
                                                title="Terlambat">
                                                ⚠ {{ $dayData['hadir_terlambat'] }}
                                            </span>
                                        @endif
                                        @if($dayData['izin'] > 0)
                                            <span class="px-1.5 py-0.5 bg-yellow-100 text-yellow-700 rounded-full" title="Izin">
                                                📝 {{ $dayData['izin'] }}
                                            </span>
                                        @endif
                                        @if($dayData['libur'] > 0)
                                            <span class="px-1.5 py-0.5 bg-blue-500 text-white rounded-full" title="Libur">
                                                🌴 {{ $dayData['libur'] }}
                                            </span>
                                        @endif
                                        @if($dayData['tidak_hadir'] > 0)
                                            <span class="px-1.5 py-0.5 bg-gray-700 text-white rounded-full" title="Tidak Hadir">
                                                ✗ {{ $dayData['tidak_hadir'] }}
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                {{-- Mobile View (Dots) --}}
                                <div class="flex md:hidden justify-center gap-1 mt-auto pb-1">
                                    @if($dayData['hadir_tepat_waktu'] > 0)
                                        <div class="w-2 h-2 rounded-full bg-green-500"></div>
                                    @endif
                                    @if($dayData['hadir_terlambat'] > 0)
                                        <div class="w-2 h-2 rounded-full bg-red-500"></div>
                                    @endif
                                    @if($dayData['izin'] > 0)
                                        <div class="w-2 h-2 rounded-full bg-yellow-500"></div>
                                    @endif
                                    @if($dayData['libur'] > 0)
                                        <div class="w-2 h-2 rounded-full bg-blue-500"></div>
                                    @endif
                                    @if($dayData['tidak_hadir'] > 0)
                                        <div class="w-2 h-2 rounded-full bg-gray-700"></div>
                                    @endif
                                </div>
                            @else
                                <div class="text-center text-xs text-gray-300 mt-auto pb-2">
                                    -
                                </div>
                            @endif
                        </div>
                    </a>
                @endfor
            </div>
        </div>


        {{-- Legend --}}
        <div class="bg-white rounded-2xl shadow-xl p-6">
            <h3 class="text-lg font-semibold mb-4">Legenda</h3>
            <div class="grid grid-cols-2 md:grid-cols-6 gap-4">
                <div class="flex items-center gap-2">
                    <span class="px-2 py-1 bg-green-100 text-green-700 rounded text-xs">✓</span>
                    <span class="text-sm">Hadir Tepat Waktu</span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="px-2 py-1 bg-red-100 text-red-700 rounded text-xs">⚠</span>
                    <span class="text-sm">Hadir Terlambat</span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="px-2 py-1 bg-yellow-100 text-yellow-700 rounded text-xs">📝</span>
                    <span class="text-sm">Izin</span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="px-2 py-1 bg-blue-500 text-white rounded text-xs">🌴</span>
                    <span class="text-sm">Libur</span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="px-2 py-1 bg-gray-700 text-white rounded text-xs">✗</span>
                    <span class="text-sm">Tidak Hadir</span>
                </div>
                <div class="flex items-center gap-2">
                    <span
                        class="px-2 py-1 bg-primaryExtraLight border border-primary rounded text-xs font-bold">-</span>
                    <span class="text-sm">Hari Ini</span>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
