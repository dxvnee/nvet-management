{{-- Absensi Table Row Component --}}
@props(['absen', 'tanggal' => null, 'showActions' => true])

<tr class="border-b border-gray-100 hover:bg-gray-50 transition-colors">
    {{-- User Info --}}
    <td class="py-3 px-4">
        <x-ui.user-avatar :user="$absen->user" size="md" :showInfo="true" />
    </td>

    {{-- Jam Masuk --}}
    <td class="text-center py-3 px-4">
        @if ($absen->jam_masuk)
            <div class="text-sm text-gray-900">{{ $absen->jam_masuk->format('H:i') }}</div>
            @if ($absen->status === 'telat')
                <div class="text-xs text-red-600">Terlambat {{ $absen->menit_telat }} menit</div>
            @endif
        @else
            <span class="text-gray-400">-</span>
        @endif
    </td>

    {{-- Jam Pulang --}}
    <td class="text-center py-3 px-4">
        @if ($absen->jam_pulang)
            <div class="text-sm text-gray-900">{{ $absen->jam_pulang->format('H:i') }}</div>
            @if ($absen->menit_kerja)
                <div class="text-xs text-green-600">{{ floor($absen->menit_kerja / 60) }}j
                    {{ $absen->menit_kerja % 60 }}m</div>
            @endif
        @else
            <span class="text-gray-400">-</span>
        @endif
    </td>

    {{-- Status --}}
    <td class="text-center py-3 px-4">
        @if ($absen->libur)
            <x-ui.status-badge type="info" size="md">Libur</x-ui.status-badge>
        @elseif($absen->tidak_hadir)
            <x-ui.status-badge type="default" size="md">Tidak Hadir</x-ui.status-badge>
        @elseif($absen->izin)
            <x-ui.status-badge type="warning" size="md">Izin</x-ui.status-badge>
        @elseif($absen->jam_masuk)
            @if ($absen->telat == 0)
                <x-ui.status-badge type="success" size="md">Tepat Waktu</x-ui.status-badge>
            @else
                <x-ui.status-badge type="danger" size="md">Terlambat</x-ui.status-badge>
            @endif
        @else
            <x-ui.status-badge type="default" size="md">Belum Absen</x-ui.status-badge>
        @endif
    </td>

    {{-- Lokasi --}}
    <td class="text-center py-3 px-4 text-gray-700">
        @if ($absen->lat_masuk && $absen->lng_masuk)
            <div class="text-xs">Masuk: {{ number_format($absen->lat_masuk, 6) }},
                {{ number_format($absen->lng_masuk, 6) }}</div>
        @endif
        @if ($absen->lat_pulang && $absen->lng_pulang)
            <div class="text-xs">Pulang: {{ number_format($absen->lat_pulang, 6) }},
                {{ number_format($absen->lng_pulang, 6) }}</div>
        @endif
        @if (!$absen->lat_masuk && !$absen->lat_pulang)
            <span class="text-gray-400">-</span>
        @endif
    </td>

    {{-- Foto --}}
    <td class="text-center py-3 px-4">
        <div class="flex flex-wrap gap-1 justify-center">
            @if ($absen->foto_masuk)
                <x-absensi.photo-button type="masuk" :photoUrl="asset('storage/' . $absen->foto_masuk)" :userName="$absen->user->name" :timestamp="$absen->jam_masuk ? $absen->jam_masuk->format('d/m/Y H:i') : ''" />
            @endif
            @if ($absen->foto_pulang)
                <x-absensi.photo-button type="pulang" :photoUrl="asset('storage/' . $absen->foto_pulang)" :userName="$absen->user->name" :timestamp="$absen->jam_pulang ? $absen->jam_pulang->format('d/m/Y H:i') : ''" />
            @endif
            @if ($absen->foto_izin)
                <x-absensi.photo-button type="izin" :photoUrl="asset('storage/' . $absen->foto_izin)" :userName="$absen->user->name" :timestamp="$absen->tanggal->format('d/m/Y')" />
            @endif
            @if (!$absen->foto_masuk && !$absen->foto_pulang && !$absen->foto_izin)
                <span class="text-xs text-gray-400">-</span>
            @endif
        </div>
    </td>

    {{-- Keterangan --}}
    <td class="text-center py-3 px-4 text-gray-700">
        {{ $absen->izin && $absen->izin_keterangan ? $absen->izin_keterangan : '-' }}
    </td>

    {{-- Actions --}}
    @if ($showActions)
        <td class="flex items-center justify-center py-3 px-4">
            <div class="flex items-center gap-2">
                @if ($absen->exists)
                    <a href="{{ route('absen.edit', $absen) }}"
                        class="p-2 bg-blue-100 hover:bg-blue-200 text-blue-600 rounded-lg transition-colors"
                        title="Edit">
                        <x-icons.pencil class="w-5 h-5" />
                    </a>
                    <form method="POST" action="{{ route('absen.destroy', $absen) }}"
                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus absensi {{ $absen->user->name }}? Tindakan ini tidak dapat dibatalkan.')"
                        class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="p-2 bg-red-100 hover:bg-red-200 text-red-600 rounded-lg transition-colors"
                            title="Hapus">
                            <x-icons.trash class="w-5 h-5" />
                        </button>
                    </form>
                @else
                    <a href="{{ route('absen.create', ['tanggal' => $tanggal ?? now()->format('Y-m-d'), 'user' => $absen->user_id]) }}"
                        class="p-2 bg-green-100 hover:bg-green-200 text-green-600 rounded-lg transition-colors"
                        title="Tambah Absen Manual">
                        <x-icons.plus class="w-5 h-5" />
                    </a>
                @endif
            </div>
        </td>
    @endif
</tr>
