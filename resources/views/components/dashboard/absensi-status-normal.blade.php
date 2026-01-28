@props(['absensi'])

<div
    class="flex flex-col md:flex-row items-center gap-6 p-6 bg-gradient-to-r from-emerald-50 to-green-50 rounded-2xl border border-emerald-100">
    <div
        class="w-20 h-20 rounded-2xl bg-gradient-to-br from-emerald-500 to-green-600 flex items-center justify-center shadow-lg">
        <x-icons.check class="w-10 h-10 text-white" />
    </div>
    <div class="flex-1 text-center md:text-left">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            {{-- Jam Masuk --}}
            <div class="bg-white rounded-xl p-4 shadow-sm border border-emerald-100">
                <div class="flex items-center gap-2 mb-1">
                    <x-icons.arrow-left-on-rectangle class="w-4 h-4 text-emerald-500" />
                    <span class="text-xs font-medium text-gray-500 uppercase tracking-wider">Masuk</span>
                </div>
                <span
                    class="text-2xl font-bold text-gray-800">{{ $absensi->jam_masuk ? $absensi->jam_masuk->format('H:i') : '-' }}</span>
                @if (!$absensi->telat)
                    <span class="ml-2 text-xs px-2 py-0.5 bg-emerald-100 text-emerald-700 rounded-full font-medium">✓
                        Tepat</span>
                @else
                    <span
                        class="ml-2 text-xs px-2 py-0.5 bg-rose-100 text-rose-700 rounded-full font-medium">{{ $absensi->menit_telat }}m
                        telat</span>
                @endif
            </div>
            {{-- Jam Pulang --}}
            <div class="bg-white rounded-xl p-4 shadow-sm border border-emerald-100">
                <div class="flex items-center gap-2 mb-1">
                    <x-icons.arrow-right-on-rectangle class="w-4 h-4 text-blue-500" />
                    <span class="text-xs font-medium text-gray-500 uppercase tracking-wider">Keluar</span>
                </div>
                <span
                    class="text-2xl font-bold text-gray-800">{{ $absensi->jam_pulang ? $absensi->jam_pulang->format('H:i') : '—' }}</span>
                @if ($absensi->jam_pulang)
                    <span class="ml-2 text-xs px-2 py-0.5 bg-blue-100 text-blue-700 rounded-full font-medium">✓
                        Selesai</span>
                @else
                    <span
                        class="ml-2 text-xs px-2 py-0.5 bg-amber-100 text-amber-700 rounded-full font-medium">Belum</span>
                @endif
            </div>
        </div>
    </div>
    @if (!$absensi->jam_pulang)
        <a href="{{ route('absen.index') }}"
            class="shrink-0 px-6 py-3 bg-gradient-to-r from-primary to-primaryDark text-white font-bold rounded-xl hover:shadow-lg transition-all hover:scale-105 flex items-center gap-2">
            <x-icons.arrow-right-on-rectangle class="w-5 h-5" />
            Absen Pulang
        </a>
    @endif
</div>
