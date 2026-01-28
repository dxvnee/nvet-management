@props(['absen'])

@php
    $isIzin = $absen->izin;
    $isLibur = $absen->libur;
    $isTelat = $absen->telat;

    $iconBg = $isIzin
        ? 'bg-gradient-to-br from-blue-100 to-blue-200'
        : ($isLibur
            ? 'bg-gradient-to-br from-indigo-100 to-purple-200'
            : 'bg-gradient-to-br from-emerald-100 to-green-200');

    $iconColor = $isIzin ? 'text-blue-600' : ($isLibur ? 'text-indigo-600' : 'text-emerald-600');
@endphp

<div
    class="flex items-center justify-between p-4 bg-gradient-to-r from-gray-50 to-white rounded-xl border border-gray-100 hover:border-primary/30 hover:shadow-sm transition-all group">
    <div class="flex items-center gap-4">
        <div class="w-12 h-12 rounded-xl flex items-center justify-center shadow-sm {{ $iconBg }}">
            @if ($isIzin)
                <x-icons.document-text class="w-6 h-6 {{ $iconColor }}" />
            @elseif($isLibur)
                <x-icons.sun class="w-6 h-6 {{ $iconColor }}" />
            @else
                <x-icons.check class="w-6 h-6 {{ $iconColor }}" />
            @endif
        </div>
        <div>
            <p class="font-semibold text-gray-800">
                {{ \Carbon\Carbon::parse($absen->tanggal)->locale('id')->isoFormat('dddd, D MMM Y') }}</p>
            <p class="text-sm text-gray-500">
                @if ($isIzin)
                    <span class="text-blue-600">Izin: {{ $absen->izin_keterangan ?: 'Tanpa keterangan' }}</span>
                @elseif($isLibur)
                    <span class="text-indigo-600">Libur</span>
                @else
                    <span
                        class="text-emerald-600">{{ $absen->jam_masuk ? $absen->jam_masuk->format('H:i') : '-' }}</span>
                    @if ($absen->jam_pulang)
                        <span class="text-gray-400 mx-1">→</span>
                        <span class="text-blue-600">{{ $absen->jam_pulang->format('H:i') }}</span>
                    @endif
                @endif
            </p>
        </div>
    </div>
    <div>
        @if ($isIzin)
            <span class="text-xs px-3 py-1 bg-blue-50 text-blue-600 rounded-lg font-medium ring-1 ring-blue-200">📝
                Izin</span>
        @elseif($isLibur)
            <span
                class="text-xs px-3 py-1 bg-indigo-50 text-indigo-600 rounded-lg font-medium ring-1 ring-indigo-200">🌴
                Libur</span>
        @elseif($isTelat)
            <span class="text-xs px-3 py-1 bg-rose-50 text-rose-600 rounded-lg font-medium ring-1 ring-rose-200">⏰
                Telat</span>
        @else
            <span
                class="text-xs px-3 py-1 bg-emerald-50 text-emerald-600 rounded-lg font-medium ring-1 ring-emerald-200">✓
                Tepat</span>
        @endif
    </div>
</div>
