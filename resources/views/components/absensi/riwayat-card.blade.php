{{-- Riwayat Card Component --}}
@props(['absen', 'showActions' => false])

@php
    $bgClass = match (true) {
        $absen->libur => 'from-blue-100 to-indigo-100',
        $absen->tidak_hadir => 'from-gray-100 to-gray-200',
        $absen->izin => 'from-amber-100 to-yellow-100',
        $absen->telat => 'from-rose-100 to-red-100',
        $absen->jam_masuk != null => 'from-emerald-100 to-green-100',
        default => 'from-gray-100 to-gray-200',
    };
@endphp

<div
    {{ $attributes->merge(['class' => 'group bg-gradient-to-br from-white to-gray-50/50 rounded-2xl shadow-sm hover:shadow-xl border border-gray-100 hover:border-primary/20 transition-all duration-300 p-5 hover:transform hover:scale-[1.01]']) }}>
    {{-- Header --}}
    <div class="flex items-center justify-between mb-4">
        <div class="flex items-center gap-3">
            <div
                class="w-10 h-10 rounded-xl flex items-center justify-center shadow-sm bg-gradient-to-br {{ $bgClass }}">
                @if ($absen->libur)
                    <x-icons.sun class="w-5 h-5 text-blue-600" />
                @elseif($absen->tidak_hadir)
                    <x-icons.x-mark class="w-5 h-5 text-gray-600" />
                @elseif($absen->izin)
                    <x-icons.document-text class="w-5 h-5 text-amber-600" />
                @elseif($absen->telat)
                    <x-icons.clock class="w-5 h-5 text-rose-600" />
                @elseif($absen->jam_masuk)
                    <x-icons.check class="w-5 h-5 text-emerald-600" />
                @else
                    <x-icons.chat-bubble class="w-5 h-5 text-gray-400" />
                @endif
            </div>
            <div>
                <h3 class="font-bold text-gray-800 text-lg">{{ $absen->tanggal->format('d M Y') }}</h3>
                <p class="text-sm text-gray-500">{{ $absen->tanggal->locale('id')->isoFormat('dddd') }}</p>
            </div>
        </div>
        <div class="text-right">
            @if ($absen->libur)
                <x-ui.status-badge type="libur">Libur</x-ui.status-badge>
            @elseif($absen->tidak_hadir)
                <x-ui.status-badge type="tidak_hadir">Tidak Hadir</x-ui.status-badge>
            @elseif($absen->izin)
                <x-ui.status-badge type="izin">Izin</x-ui.status-badge>
            @elseif($absen->telat)
                <x-ui.status-badge type="telat">Telat {{ $absen->menit_telat }}m</x-ui.status-badge>
            @elseif($absen->jam_masuk)
                <x-ui.status-badge type="hadir">Tepat Waktu</x-ui.status-badge>
            @else
                <x-ui.status-badge type="default">-</x-ui.status-badge>
            @endif
        </div>
    </div>

    {{-- Content --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
        {{-- Jam Masuk --}}
        <div class="flex items-center justify-between p-3 bg-white rounded-xl border border-gray-100">
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 rounded-lg bg-emerald-100 flex items-center justify-center">
                    <x-icons.arrow-left-on-rectangle class="w-4 h-4 text-emerald-600" />
                </div>
                <span class="text-sm font-medium text-gray-600">Masuk</span>
            </div>
            <span
                class="text-lg font-bold text-gray-800">{{ $absen->jam_masuk ? $absen->jam_masuk->format('H:i') : '—' }}</span>
        </div>

        {{-- Jam Pulang --}}
        <div class="flex items-center justify-between p-3 bg-white rounded-xl border border-gray-100">
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 rounded-lg bg-blue-100 flex items-center justify-center">
                    <x-icons.arrow-right-on-rectangle class="w-4 h-4 text-blue-600" />
                </div>
                <span class="text-sm font-medium text-gray-600">Pulang</span>
            </div>
            <span
                class="text-lg font-bold text-gray-800">{{ $absen->jam_pulang ? $absen->jam_pulang->format('H:i') : '—' }}</span>
        </div>

        {{-- Total Kerja --}}
        <div class="flex items-center justify-between p-3 bg-white rounded-xl border border-gray-100">
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 rounded-lg bg-purple-100 flex items-center justify-center">
                    <x-icons.clock class="w-4 h-4 text-purple-600" />
                </div>
                <span class="text-sm font-medium text-gray-600">Total Kerja</span>
            </div>
            <span class="text-lg font-bold text-gray-800">
                @if ($absen->menit_kerja)
                    {{ floor($absen->menit_kerja / 60) }}j {{ $absen->menit_kerja % 60 }}m
                @else
                    —
                @endif
            </span>
        </div>
    </div>

    {{-- Keterangan --}}
    @if ($absen->izin_keterangan)
        <div class="mt-3 p-3 bg-amber-50 rounded-xl border border-amber-100">
            <div class="flex items-start gap-2">
                <x-icons.chat-bubble class="w-4 h-4 text-amber-600 mt-0.5 flex-shrink-0" />
                <div>
                    <p class="text-xs font-medium text-amber-700 uppercase tracking-wider mb-1">Keterangan</p>
                    <p class="text-sm text-amber-800">{{ $absen->izin_keterangan }}</p>
                </div>
            </div>
        </div>
    @endif
</div>
