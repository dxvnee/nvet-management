<x-app-layout>
    <x-slot name="header">Kalender Absensi</x-slot>
    <x-slot name="subtle">Lihat riwayat absensi Anda dalam format kalender</x-slot>

    <div class="space-y-6">
        {{-- Header Section --}}
        <x-ui.page-hero title="Kalender Absensi">
            <x-slot:icon>
                <x-icons.calendar class="w-10 h-10 text-white" />
            </x-slot:icon>
            <x-slot:subtitle>
                <x-icons.user class="w-4 h-4" />
                {{ auth()->user()->name }}
            </x-slot:subtitle>
            <x-slot:actions>
                <a href="{{ route('absen.riwayat') }}"
                    class="group flex items-center gap-2 px-4 py-2.5 bg-white/20 hover:bg-white/30 backdrop-blur-sm rounded-xl transition-all duration-300">
                    <x-icons.list class="w-5 h-5 group-hover:scale-110 transition-transform" />
                    <span class="font-medium">Tampilan List</span>
                </a>
            </x-slot:actions>
        </x-ui.page-hero>

        {{-- Stats Summary --}}
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 animate-slide-up-delay-1">
            <x-ui.summary-stat :value="$totalHadir" label="Hadir" color="success">
                <x-slot:iconSlot>
                    <x-icons.check class="w-6 h-6 text-white" />
                </x-slot:iconSlot>
            </x-ui.summary-stat>

            <x-ui.summary-stat :value="$totalTelat" label="Terlambat" color="danger">
                <x-slot:iconSlot>
                    <x-icons.clock class="w-6 h-6 text-white" />
                </x-slot:iconSlot>
            </x-ui.summary-stat>

            <x-ui.summary-stat :value="$totalIzin" label="Izin" color="warning">
                <x-slot:iconSlot>
                    <x-icons.document-text class="w-6 h-6 text-white" />
                </x-slot:iconSlot>
            </x-ui.summary-stat>

            <x-ui.summary-stat :value="$totalJam . 'j ' . $sisaMenit . 'm'" label="Total Kerja" color="info">
                <x-slot:iconSlot>
                    <x-icons.clock class="w-6 h-6 text-white" />
                </x-slot:iconSlot>
            </x-ui.summary-stat>
        </div>

        {{-- Calendar Section --}}
        <x-ui.section-card class="border border-gray-100 animate-slide-up-delay-1">
            {{-- Navigation Bulan/Tahun --}}
            <div class="flex flex-col md:flex-row items-center justify-between mb-6 gap-4">
                <h2 class="text-xl md:text-2xl font-bold text-gray-800 flex items-center gap-2">
                    <x-icons.calendar class="w-6 h-6 text-primary" />
                    {{ \Carbon\Carbon::create($tahun, $bulan)->locale('id')->isoFormat('MMMM Y') }}
                </h2>
                <div class="flex flex-col sm:flex-row gap-4 w-full md:w-auto items-center">
                    <form method="GET" action="{{ route('absen.riwayatKalender') }}"
                        class="flex flex-col md:flex-row gap-2 w-full sm:w-auto">
                        <div class="flex gap-2 w-full sm:w-auto">
                            <select name="bulan"
                                class="flex-1 sm:flex-none px-4 py-2.5 rounded-xl border-2 border-gray-200 focus:border-primary focus:ring-4 focus:ring-primary/20 transition-all min-w-[140px] text-center sm:text-left font-medium">
                                @for ($m = 1; $m <= 12; $m++)
                                    <option value="{{ $m }}" {{ $m == $bulan ? 'selected' : '' }}>
                                        {{ \Carbon\Carbon::create(null, $m)->locale('id')->isoFormat('MMMM') }}
                                    </option>
                                @endfor
                            </select>
                            <select name="tahun"
                                class="flex-1 sm:flex-none px-4 py-2.5 rounded-xl border-2 border-gray-200 focus:border-primary focus:ring-4 focus:ring-primary/20 transition-all min-w-[100px] text-center sm:text-left font-medium">
                                @for ($y = date('Y') - 2; $y <= date('Y') + 2; $y++)
                                    <option value="{{ $y }}" {{ $y == $tahun ? 'selected' : '' }}>
                                        {{ $y }}
                                    </option>
                                @endfor
                            </select>
                        </div>
                        <x-ui.action-button type="submit" variant="primary" class="group w-full sm:w-auto">
                            <x-icons.search class="w-5 h-5 group-hover:scale-110 transition-transform" />
                            Tampilkan
                        </x-ui.action-button>
                    </form>
                </div>
            </div>

            {{-- Kalender Grid --}}
            <div class="grid grid-cols-7 gap-1 md:gap-2">
                {{-- Header Hari --}}
                @foreach (['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'] as $index => $hari)
                    <div
                        class="p-2 md:p-3 text-center font-bold rounded-xl text-xs md:text-sm
                                {{ $index == 0 || $index == 6 ? 'text-red-500 bg-red-50' : 'text-gray-600 bg-gray-50' }}">
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
                    <div class="p-2 md:p-3 bg-gray-50/50 rounded-xl"></div>
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
                        $isPersonalHoliday = $dayData['is_personal_holiday'] ?? false;
                        $absen = $dayData['absen'] ?? null;
                        $status = $dayData['status'] ?? null;
                        $statusColor = $dayData['status_color'] ?? 'gray';
                        $statusIcon = $dayData['status_icon'] ?? '';
                    @endphp

                    <div
                        class="group h-full min-h-[80px] md:min-h-[100px] p-1.5 md:p-2 rounded-xl border-2 flex flex-col transition-all duration-300 relative overflow-hidden cursor-default
                                {{ $isToday ? 'border-primary bg-primaryExtraLight shadow-lg ring-2 ring-primary/20' : 'border-gray-100 bg-white hover:border-primary/30 hover:shadow-md' }}
                                {{ $isWeekend && !$isToday ? 'bg-gray-50/50' : '' }}
                                {{ $publicHoliday && !$isToday ? 'bg-red-50/50 border-red-200' : '' }}">

                        {{-- Public Holiday Badge --}}
                        @if ($publicHoliday)
                            <div
                                class="absolute top-0 left-0 right-0 bg-gradient-to-r from-red-500 to-rose-500 text-white text-[7px] md:text-[9px] text-center py-0.5 font-bold truncate px-1">
                                {{ $publicHoliday->nama }}
                            </div>
                        @endif

                        {{-- Date Number --}}
                        <div class="text-right {{ $publicHoliday ? 'mt-3 md:mt-4' : '' }}">
                            <span
                                class="inline-flex items-center justify-center w-6 h-6 md:w-7 md:h-7 rounded-full text-xs md:text-sm font-bold
                                        {{ $isToday ? 'bg-primary text-white shadow-md' : ($publicHoliday ? 'text-red-600' : ($isWeekend ? 'text-red-500' : 'text-gray-700')) }}">
                                {{ $day }}
                            </span>
                        </div>

                        {{-- Content --}}
                        <div class="flex-1 flex flex-col justify-end">
                            @if ($status)
                                {{-- Desktop View --}}
                                <div class="hidden md:flex flex-col items-center gap-1 pb-1">
                                    <span class="text-lg">{{ $statusIcon }}</span>
                                    <span
                                        class="text-[10px] font-bold px-2 py-0.5 rounded-full
                                        {{ $statusColor === 'green' ? 'bg-green-100 text-green-700' : '' }}
                                        {{ $statusColor === 'red' ? 'bg-red-100 text-red-700' : '' }}
                                        {{ $statusColor === 'yellow' ? 'bg-yellow-100 text-yellow-700' : '' }}
                                        {{ $statusColor === 'blue' ? 'bg-blue-100 text-blue-700' : '' }}
                                        {{ $statusColor === 'gray' ? 'bg-gray-100 text-gray-700' : '' }}">
                                        {{ $status }}
                                    </span>
                                    @if ($absen && $absen->jam_masuk)
                                        <span class="text-[9px] text-gray-500 font-mono">
                                            {{ $absen->jam_masuk->format('H:i') }}
                                            @if ($absen->jam_pulang)
                                                - {{ $absen->jam_pulang->format('H:i') }}
                                            @endif
                                        </span>
                                    @endif
                                </div>

                                {{-- Mobile View (Dot) --}}
                                <div class="flex md:hidden justify-center items-center pb-1">
                                    <div
                                        class="w-3 h-3 rounded-full
                                        {{ $statusColor === 'green' ? 'bg-green-500' : '' }}
                                        {{ $statusColor === 'red' ? 'bg-red-500' : '' }}
                                        {{ $statusColor === 'yellow' ? 'bg-yellow-500' : '' }}
                                        {{ $statusColor === 'blue' ? 'bg-blue-500' : '' }}
                                        {{ $statusColor === 'gray' ? 'bg-gray-400' : '' }}">
                                    </div>
                                </div>
                            @elseif($currentDate->lte(now()) && !$isWeekend && !$publicHoliday && !$isPersonalHoliday)
                                <div class="hidden md:flex justify-center pb-1">
                                    <span
                                        class="text-[10px] font-medium text-gray-400 px-2 py-0.5 bg-gray-50 rounded-full">-</span>
                                </div>
                            @endif
                        </div>
                    </div>
                @endfor
            </div>

            {{-- Legend --}}
            <div class="mt-6 p-4 bg-gradient-to-r from-gray-50 to-gray-100 rounded-xl border border-gray-200">
                <h3 class="text-sm font-bold text-gray-700 mb-3 flex items-center gap-2">
                    <x-icons.information-circle class="w-4 h-4" />
                    Keterangan:
                </h3>
                <div class="flex flex-wrap gap-x-6 gap-y-2 text-xs">
                    <div class="flex items-center gap-2">
                        <div class="w-3 h-3 rounded-full bg-green-500 shadow-sm"></div>
                        <span class="text-gray-600 font-medium">Tepat Waktu</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="w-3 h-3 rounded-full bg-red-500 shadow-sm"></div>
                        <span class="text-gray-600 font-medium">Terlambat</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="w-3 h-3 rounded-full bg-yellow-500 shadow-sm"></div>
                        <span class="text-gray-600 font-medium">Izin</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="w-3 h-3 rounded-full bg-blue-500 shadow-sm"></div>
                        <span class="text-gray-600 font-medium">Libur</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="w-3 h-3 rounded-full bg-gray-400 shadow-sm"></div>
                        <span class="text-gray-600 font-medium">Tidak Hadir</span>
                    </div>
                </div>
            </div>
        </x-ui.section-card>
    </div>
</x-app-layout>
