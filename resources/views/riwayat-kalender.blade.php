<x-app-layout>
    <x-slot name="header">Kalender Absensi</x-slot>
    <x-slot name="subtle">Lihat riwayat absensi Anda dalam format kalender</x-slot>

    <div class="space-y-6">
        {{-- Header Section --}}
        <div class="relative overflow-hidden bg-gradient-to-br from-primary via-primaryDark to-primary rounded-3xl shadow-2xl p-6 md:p-8 text-white animate-slide-up">
            {{-- Background Pattern --}}
            <div class="absolute inset-0 opacity-10">
                <div class="absolute -top-10 -right-10 w-40 h-40 bg-white rounded-full"></div>
                <div class="absolute -bottom-10 -left-10 w-32 h-32 bg-white rounded-full"></div>
                <div class="absolute top-1/2 left-1/3 w-20 h-20 bg-white rounded-full"></div>
            </div>

            <div class="relative flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
                <div class="flex items-center gap-4">
                    <div class="p-4 bg-white/20 backdrop-blur-sm rounded-2xl">
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-2xl md:text-3xl font-bold mb-1">Kalender Absensi</h2>
                        <p class="text-white/80 text-sm md:text-base flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            {{ auth()->user()->name }}
                        </p>
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    <a href="{{ route('absen.riwayat') }}" 
                       class="group flex items-center gap-2 px-4 py-2.5 bg-white/20 hover:bg-white/30 backdrop-blur-sm rounded-xl transition-all duration-300">
                        <svg class="w-5 h-5 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path>
                        </svg>
                        <span class="font-medium">Tampilan List</span>
                    </a>
                </div>
            </div>
        </div>

        {{-- Stats Summary --}}
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 animate-slide-up-delay-1">
            {{-- Hadir --}}
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-4 hover:shadow-xl transition-all duration-300">
                <div class="flex items-center gap-3">
                    <div class="p-3 bg-gradient-to-br from-emerald-500 to-green-600 rounded-xl shadow-lg">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-gray-800">{{ $totalHadir }}</p>
                        <p class="text-xs text-gray-500 uppercase tracking-wider">Hadir</p>
                    </div>
                </div>
            </div>

            {{-- Terlambat --}}
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-4 hover:shadow-xl transition-all duration-300">
                <div class="flex items-center gap-3">
                    <div class="p-3 bg-gradient-to-br from-red-500 to-rose-600 rounded-xl shadow-lg">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-gray-800">{{ $totalTelat }}</p>
                        <p class="text-xs text-gray-500 uppercase tracking-wider">Terlambat</p>
                    </div>
                </div>
            </div>

            {{-- Izin --}}
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-4 hover:shadow-xl transition-all duration-300">
                <div class="flex items-center gap-3">
                    <div class="p-3 bg-gradient-to-br from-amber-500 to-yellow-600 rounded-xl shadow-lg">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-gray-800">{{ $totalIzin }}</p>
                        <p class="text-xs text-gray-500 uppercase tracking-wider">Izin</p>
                    </div>
                </div>
            </div>

            {{-- Total Jam Kerja --}}
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-4 hover:shadow-xl transition-all duration-300">
                <div class="flex items-center gap-3">
                    <div class="p-3 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl shadow-lg">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-xl font-bold text-gray-800">{{ $totalJam }}j {{ $sisaMenit }}m</p>
                        <p class="text-xs text-gray-500 uppercase tracking-wider">Total Kerja</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Calendar Section --}}
        <div class="bg-white rounded-2xl shadow-xl p-4 md:p-6 border border-gray-100 animate-slide-up-delay-1">
            {{-- Navigation Bulan/Tahun --}}
            <div class="flex flex-col md:flex-row items-center justify-between mb-6 gap-4">
                <h2 class="text-xl md:text-2xl font-bold text-gray-800 flex items-center gap-2">
                    <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    {{ \Carbon\Carbon::create($tahun, $bulan)->locale('id')->isoFormat('MMMM Y') }}
                </h2>
                <div class="flex flex-col sm:flex-row gap-4 w-full md:w-auto items-center">
                    {{-- Month/Year Selector --}}
                    <form method="GET" action="{{ route('absen.riwayatKalender') }}"
                        class="flex flex-col md:flex-row gap-2 w-full sm:w-auto">
                        <div class="flex gap-2 w-full sm:w-auto">
                            <select name="bulan"
                                class="flex-1 sm:flex-none px-4 py-2.5 rounded-xl border-2 border-gray-200 focus:border-primary focus:ring-4 focus:ring-primary/20 transition-all min-w-[140px] text-center sm:text-left font-medium">
                                @for($m = 1; $m <= 12; $m++)
                                    <option value="{{ $m }}" {{ $m == $bulan ? 'selected' : '' }}>
                                        {{ \Carbon\Carbon::create(null, $m)->locale('id')->isoFormat('MMMM') }}
                                    </option>
                                @endfor
                            </select>
                            <select name="tahun"
                                class="flex-1 sm:flex-none px-4 py-2.5 rounded-xl border-2 border-gray-200 focus:border-primary focus:ring-4 focus:ring-primary/20 transition-all min-w-[100px] text-center sm:text-left font-medium">
                                @for($y = date('Y') - 2; $y <= date('Y') + 2; $y++)
                                    <option value="{{ $y }}" {{ $y == $tahun ? 'selected' : '' }}>
                                        {{ $y }}
                                    </option>
                                @endfor
                            </select>
                        </div>
                        <button type="submit"
                            class="group w-full sm:w-auto px-6 py-2.5 bg-gradient-to-r from-primary to-primaryDark hover:from-primaryDark hover:to-primary text-white font-bold rounded-xl transition-all duration-300 shadow-lg hover:shadow-xl flex items-center justify-center gap-2">
                            <svg class="w-5 h-5 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                            Tampilkan
                        </button>
                    </form>
                </div>
            </div>

            {{-- Kalender Grid --}}
            <div class="grid grid-cols-7 gap-1 md:gap-2">
                {{-- Header Hari --}}
                @foreach(['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'] as $index => $hari)
                    <div class="p-2 md:p-3 text-center font-bold rounded-xl text-xs md:text-sm
                                {{ $index == 0 ? 'text-red-500 bg-red-50' : ($index == 6 ? 'text-red-500 bg-red-50' : 'text-gray-600 bg-gray-50') }}">
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
                    <div class="p-2 md:p-3 bg-gray-50/50 rounded-xl"></div>
                @endfor

                {{-- Days of month --}}
                @for($day = 1; $day <= $endOfMonth->day; $day++)
                    @php
                        $currentDate = \Carbon\Carbon::create($tahun, $bulan, $day);
                        $dateKey = $currentDate->format('Y-m-d');
                        $dayData = $kalenderData[$dateKey] ?? null;
                        $isToday = $currentDate->isToday();
                        $isWeekend = $currentDate->isWeekend();
                        $publicHoliday = $dayData['public_holiday'] ?? null;
                        $isPersonalHoliday = $dayData['is_personal_holiday'] ?? false;
                        $absen = $dayData['absen'] ?? null;
                        $status = $dayData['status'] ?? null;
                        $statusColor = $dayData['status_color'] ?? 'gray';
                        $statusIcon = $dayData['status_icon'] ?? '';
                    @endphp

                    <div class="group h-full min-h-[80px] md:min-h-[100px] p-1.5 md:p-2 rounded-xl border-2 flex flex-col transition-all duration-300 relative overflow-hidden cursor-default
                                {{ $isToday ? 'border-primary bg-primaryExtraLight shadow-lg ring-2 ring-primary/20' : 'border-gray-100 bg-white hover:border-primary/30 hover:shadow-md' }}
                                {{ $isWeekend && !$isToday ? 'bg-gray-50/50' : '' }}
                                {{ $publicHoliday && !$isToday ? 'bg-red-50/50 border-red-200' : '' }}">

                        {{-- Public Holiday Badge --}}
                        @if($publicHoliday)
                            <div class="absolute top-0 left-0 right-0 bg-gradient-to-r from-red-500 to-rose-500 text-white text-[7px] md:text-[9px] text-center py-0.5 font-bold truncate px-1">
                                {{ $publicHoliday->nama }}
                            </div>
                        @endif

                        {{-- Date Number --}}
                        <div class="text-right mb-1 {{ $publicHoliday ? 'mt-3 md:mt-4' : '' }}">
                            <span class="inline-flex items-center justify-center w-6 h-6 md:w-7 md:h-7 rounded-full text-xs md:text-sm font-bold transition-all
                                            {{ $isToday ? 'bg-gradient-to-br from-primary to-primaryDark text-white shadow-lg' : ($publicHoliday ? 'text-red-600' : ($isWeekend ? 'text-red-400' : 'text-gray-700')) }}">
                                {{ $day }}
                            </span>
                        </div>

                        {{-- Status Content --}}
                        <div class="flex-1 flex flex-col justify-end">
                            @if($status)
                                {{-- Desktop View --}}
                                <div class="hidden md:block">
                                    @if($status === 'hadir')
                                        <div class="p-2 bg-gradient-to-br from-green-50 to-emerald-50 rounded-lg border border-green-200">
                                            <div class="flex items-center gap-1 mb-1">
                                                <span class="text-lg">✓</span>
                                                <span class="text-[10px] font-bold text-green-700">Hadir</span>
                                            </div>
                                            @if($absen && $absen->jam_masuk)
                                                <p class="text-[10px] text-green-600 font-medium">{{ $absen->jam_masuk->format('H:i') }}</p>
                                            @endif
                                        </div>
                                    @elseif($status === 'telat')
                                        <div class="p-2 bg-gradient-to-br from-red-50 to-rose-50 rounded-lg border border-red-200">
                                            <div class="flex items-center gap-1 mb-1">
                                                <span class="text-lg">⚠</span>
                                                <span class="text-[10px] font-bold text-red-700">Terlambat</span>
                                            </div>
                                            @if($absen)
                                                <p class="text-[10px] text-red-600 font-medium">
                                                    {{ $absen->jam_masuk ? $absen->jam_masuk->format('H:i') : '' }}
                                                    @if($absen->menit_telat)
                                                        (+{{ $absen->menit_telat }}m)
                                                    @endif
                                                </p>
                                            @endif
                                        </div>
                                    @elseif($status === 'izin')
                                        <div class="p-2 bg-gradient-to-br from-amber-50 to-yellow-50 rounded-lg border border-amber-200">
                                            <div class="flex items-center gap-1">
                                                <span class="text-lg">📝</span>
                                                <span class="text-[10px] font-bold text-amber-700">Izin</span>
                                            </div>
                                        </div>
                                    @elseif($status === 'libur')
                                        <div class="p-2 bg-gradient-to-br from-blue-50 to-indigo-50 rounded-lg border border-blue-200">
                                            <div class="flex items-center gap-1">
                                                <span class="text-lg">🌴</span>
                                                <span class="text-[10px] font-bold text-blue-700">Libur</span>
                                            </div>
                                        </div>
                                    @elseif($status === 'tidak_hadir')
                                        <div class="p-2 bg-gradient-to-br from-gray-100 to-gray-200 rounded-lg border border-gray-300">
                                            <div class="flex items-center gap-1">
                                                <span class="text-lg">✗</span>
                                                <span class="text-[10px] font-bold text-gray-600">Tidak Hadir</span>
                                            </div>
                                        </div>
                                    @endif
                                </div>

                                {{-- Mobile View (Icon Only) --}}
                                <div class="flex md:hidden justify-center items-center mt-auto pb-1">
                                    @if($status === 'hadir')
                                        <div class="w-8 h-8 rounded-full bg-gradient-to-br from-green-500 to-emerald-600 flex items-center justify-center shadow-sm">
                                            <span class="text-white text-sm">✓</span>
                                        </div>
                                    @elseif($status === 'telat')
                                        <div class="w-8 h-8 rounded-full bg-gradient-to-br from-red-500 to-rose-600 flex items-center justify-center shadow-sm">
                                            <span class="text-white text-sm">⚠</span>
                                        </div>
                                    @elseif($status === 'izin')
                                        <div class="w-8 h-8 rounded-full bg-gradient-to-br from-amber-500 to-yellow-600 flex items-center justify-center shadow-sm">
                                            <span class="text-white text-sm">📝</span>
                                        </div>
                                    @elseif($status === 'libur')
                                        <div class="w-8 h-8 rounded-full bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center shadow-sm">
                                            <span class="text-white text-sm">🌴</span>
                                        </div>
                                    @elseif($status === 'tidak_hadir')
                                        <div class="w-8 h-8 rounded-full bg-gradient-to-br from-gray-400 to-gray-500 flex items-center justify-center shadow-sm">
                                            <span class="text-white text-sm">✗</span>
                                        </div>
                                    @endif
                                </div>
                            @elseif($currentDate->lt(\Carbon\Carbon::today()))
                                {{-- Past date with no record --}}
                                <div class="flex justify-center items-center mt-auto pb-2">
                                    <span class="text-gray-300 text-sm">—</span>
                                </div>
                            @else
                                {{-- Future date --}}
                                <div class="flex justify-center items-center mt-auto pb-2">
                                    <span class="text-gray-200 text-lg">•</span>
                                </div>
                            @endif
                        </div>

                        {{-- Hover overlay for details --}}
                        @if($absen && ($absen->jam_masuk || $absen->jam_pulang))
                            <div class="absolute inset-0 bg-white/95 backdrop-blur-sm rounded-xl opacity-0 group-hover:opacity-100 transition-all duration-300 p-2 flex flex-col justify-center items-center z-10 pointer-events-none">
                                <p class="text-xs font-bold text-gray-800 mb-1">{{ $currentDate->locale('id')->isoFormat('D MMM') }}</p>
                                @if($absen->jam_masuk)
                                    <p class="text-[10px] text-gray-600">
                                        <span class="text-green-600 font-medium">Masuk:</span> {{ $absen->jam_masuk->format('H:i') }}
                                    </p>
                                @endif
                                @if($absen->jam_pulang)
                                    <p class="text-[10px] text-gray-600">
                                        <span class="text-blue-600 font-medium">Pulang:</span> {{ $absen->jam_pulang->format('H:i') }}
                                    </p>
                                @endif
                                @if($absen->menit_kerja)
                                    <p class="text-[10px] text-primary font-bold mt-1">
                                        {{ floor($absen->menit_kerja / 60) }}j {{ $absen->menit_kerja % 60 }}m
                                    </p>
                                @endif
                            </div>
                        @endif
                    </div>
                @endfor
            </div>
        </div>

        {{-- Legend --}}
        <div class="bg-white rounded-2xl shadow-xl p-6 border border-gray-100 animate-slide-up-delay-1">
            <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
                <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                Keterangan
            </h3>
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
                <div class="flex items-center gap-3 p-3 bg-gradient-to-br from-green-50 to-emerald-50 rounded-xl border border-green-200">
                    <span class="text-xl">✓</span>
                    <span class="text-sm font-medium text-green-700">Hadir Tepat Waktu</span>
                </div>
                <div class="flex items-center gap-3 p-3 bg-gradient-to-br from-red-50 to-rose-50 rounded-xl border border-red-200">
                    <span class="text-xl">⚠</span>
                    <span class="text-sm font-medium text-red-700">Terlambat</span>
                </div>
                <div class="flex items-center gap-3 p-3 bg-gradient-to-br from-amber-50 to-yellow-50 rounded-xl border border-amber-200">
                    <span class="text-xl">📝</span>
                    <span class="text-sm font-medium text-amber-700">Izin</span>
                </div>
                <div class="flex items-center gap-3 p-3 bg-gradient-to-br from-blue-50 to-indigo-50 rounded-xl border border-blue-200">
                    <span class="text-xl">🌴</span>
                    <span class="text-sm font-medium text-blue-700">Libur</span>
                </div>
                <div class="flex items-center gap-3 p-3 bg-gradient-to-br from-gray-100 to-gray-200 rounded-xl border border-gray-300">
                    <span class="text-xl">✗</span>
                    <span class="text-sm font-medium text-gray-600">Tidak Hadir</span>
                </div>
                <div class="flex items-center gap-3 p-3 bg-gradient-to-br from-primary/10 to-primary/20 rounded-xl border-2 border-primary">
                    <span class="w-6 h-6 rounded-full bg-primary"></span>
                    <span class="text-sm font-medium text-primary">Hari Ini</span>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
