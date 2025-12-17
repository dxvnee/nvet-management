<x-app-layout>
    <x-slot name="header">Kalender Absensi</x-slot>
    <x-slot name="subtle">Pantau absensi pegawai dalam format kalender</x-slot>

    <div class="space-y-6">
        {{-- Navigation Bulan/Tahun --}}
        <div class="bg-white rounded-2xl shadow-xl p-6">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-2xl font-bold text-gray-800">
                    {{ \Carbon\Carbon::create($tahun, $bulan)->format('F Y') }}
                </h2>
                <div class="flex gap-2">
                    <a href="{{ route('absen.kalender', ['bulan' => $bulan == 1 ? 12 : $bulan - 1, 'tahun' => $bulan == 1 ? $tahun - 1 : $tahun]) }}"
                        class="btn-secondary px-4 py-2 rounded-lg hover:bg-primary hover:text-white transition-colors">
                        ← Bulan Sebelumnya
                    </a>
                    <a href="{{ route('absen.kalender', ['bulan' => $bulan == 12 ? 1 : $bulan + 1, 'tahun' => $bulan == 12 ? $tahun + 1 : $tahun]) }}"
                        class="btn-secondary px-4 py-2 rounded-lg hover:bg-primary hover:text-white transition-colors">
                        Bulan Selanjutnya →
                    </a>
                </div>
            </div>

            {{-- Kalender Grid --}}
            <div class="grid grid-cols-7 gap-2">
                {{-- Header Hari --}}
                @foreach(['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'] as $hari)
                    <div class="p-3 text-center font-semibold text-gray-600 bg-gray-50 rounded-lg">
                        {{ $hari }}
                    </div>
                @endforeach

                {{-- Days --}}
                @php
                    $startOfMonth = \Carbon\Carbon::create($tahun, $bulan, 1);
                    $endOfMonth = \Carbon\Carbon::create($tahun, $bulan)->endOfMonth();
                    $startDayOfWeek = $startOfMonth->dayOfWeek; // 0 = Sunday, 1 = Monday, etc.

                    // Adjust for Monday start (1 = Monday, 7 = Sunday)
                    $startDayOfWeek = $startDayOfWeek == 0 ? 6 : $startDayOfWeek - 1;
                @endphp

                {{-- Empty cells before first day --}}
                @for($i = 0; $i < $startDayOfWeek; $i++)
                    <div class="p-3 bg-gray-50 rounded-lg"></div>
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


                    <a href="{{ route('absen.detailHari', $dateKey) }}" class="block text-center">

                        <div
                            class="p-3 rounded-lg border {{ $isToday ? 'border-primary bg-primaryExtraLight' : 'border-gray-200 bg-white' }}
                                                        {{ $isWeekend ? 'bg-gray-50' : '' }} hover:shadow-md transition-all duration-200">
                            <div class="text-right mb-1">
                                <span
                                    class="text-sm font-medium {{ $isToday ? 'text-primary font-bold' : 'text-gray-700' }}">
                                    {{ $day }}
                                </span>
                            </div>

                            @if($dayData && $dayData['total_absen'] > 0)

                                <div class="text-xs font-semibold text-primary mb-1">
                                    {{ $dayData['total_absen'] }} Absen
                                </div>
                                <div class="flex justify-center gap-1 text-xs">
                                    @if($dayData['hadir_tepat_waktu'] > 0)
                                        <span class="px-1 py-0.5 bg-green-100 text-green-700 rounded">
                                            ✓ {{ $dayData['hadir_tepat_waktu'] }}
                                        </span>
                                    @endif
                                    @if($dayData['hadir_terlambat'] > 0)
                                        <span class="px-1 py-0.5 bg-yellow-100 text-yellow-700 rounded">
                                            ⚠ {{ $dayData['hadir_terlambat'] }}
                                        </span>
                                    @endif
                                    @if($dayData['izin'] > 0)
                                        <span class="px-1 py-0.5 bg-blue-100 text-blue-700 rounded">
                                            📝 {{ $dayData['izin'] }}
                                        </span>
                                    @endif
                                </div>
                            @else
                                <div class="text-center text-xs text-gray-400">
                                    -
                                </div>
                            @endif


                        </div>
                @endfor
            </div>
        </div>
        </a>


        {{-- Legend --}}
        <div class="bg-white rounded-2xl shadow-xl p-6">
            <h3 class="text-lg font-semibold mb-4">Legenda</h3>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div class="flex items-center gap-2">
                    <span class="px-2 py-1 bg-green-100 text-green-700 rounded text-xs">✓</span>
                    <span class="text-sm">Hadir Tepat Waktu</span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="px-2 py-1 bg-yellow-100 text-yellow-700 rounded text-xs">⚠</span>
                    <span class="text-sm">Hadir Terlambat</span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="px-2 py-1 bg-blue-100 text-blue-700 rounded text-xs">📝</span>
                    <span class="text-sm">Izin</span>
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
