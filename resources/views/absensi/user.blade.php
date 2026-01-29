<x-app-layout>
    <x-slot name="header">Absensi Per Pegawai</x-slot>
    <x-slot name="subtle">Lihat rincian absensi pegawai tertentu</x-slot>

    <div class="space-y-6">
        {{-- Filter Form --}}
        <x-ui.section-card>
            <form method="GET" action="{{ route('absen.user') }}" class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <x-ui.form-select name="user_id" label="Pilih Pegawai" :value="$userId"
                        placeholder="-- Pilih Pegawai --">
                        @foreach ($users as $pegawai)
                            <option value="{{ $pegawai->id }}" {{ $userId == $pegawai->id ? 'selected' : '' }}>
                                {{ $pegawai->name }} - {{ $pegawai->jabatan }}
                            </option>
                        @endforeach
                    </x-ui.form-select>

                    <x-ui.form-select name="bulan" label="Bulan" :value="$bulan">
                        @for ($m = 1; $m <= 12; $m++)
                            <option value="{{ $m }}" {{ $bulan == $m ? 'selected' : '' }}>
                                {{ \Carbon\Carbon::create(null, $m)->format('F') }}
                            </option>
                        @endfor
                    </x-ui.form-select>

                    <x-ui.form-select name="tahun" label="Tahun" :value="$tahun">
                        @for ($y = 2024; $y <= 2026; $y++)
                            <option value="{{ $y }}" {{ $tahun == $y ? 'selected' : '' }}>
                                {{ $y }}</option>
                        @endfor
                    </x-ui.form-select>
                </div>

                <div class="flex gap-2">
                    <x-ui.action-button type="submit" variant="primary">
                        Tampilkan Absensi
                    </x-ui.action-button>
                    @if ($userId)
                        <x-ui.action-button type="link" :href="route('absen.user')" variant="secondary">
                            Reset
                        </x-ui.action-button>
                    @endif
                </div>
            </form>
        </x-ui.section-card>

        @if ($user)
            {{-- User Info --}}
            <x-absensi.user-info-card :user="$user" />

            {{-- Absensi Table --}}
            <x-ui.section-card class="overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 -mx-6 -mt-6 mb-6">
                    <h3 class="text-lg font-semibold text-gray-800">
                        Riwayat Absensi - {{ \Carbon\Carbon::create($tahun, $bulan)->format('F Y') }}
                    </h3>
                    <p class="text-sm text-gray-600">Total: {{ $absensi->count() }} hari absen</p>
                </div>

                @if ($absensi->count() > 0)
                    <div class="overflow-x-auto -mx-6">
                        <table class="w-full">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th
                                        class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Tanggal</th>
                                    <th
                                        class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Jam Masuk</th>
                                    <th
                                        class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Jam Pulang</th>
                                    <th
                                        class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Status</th>
                                    <th
                                        class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Lokasi</th>
                                    <th
                                        class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Keterangan</th>
                                    <th
                                        class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($absensi as $absen)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">
                                                {{ $absen->tanggal->format('d/m/Y') }}
                                            </div>
                                            <div class="text-sm text-gray-500">
                                                {{ $absen->tanggal->format('l') }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if ($absen->jam_masuk)
                                                <div class="text-sm text-gray-900">
                                                    {{ $absen->jam_masuk->format('H:i') }}</div>
                                                @if ($absen->status === 'telat')
                                                    <div class="text-xs text-red-600">Terlambat
                                                        {{ $absen->menit_telat }} menit</div>
                                                @endif
                                            @else
                                                <span class="text-gray-400">-</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if ($absen->jam_pulang)
                                                <div class="text-sm text-gray-900">
                                                    {{ $absen->jam_pulang->format('H:i') }}</div>
                                                @if ($absen->menit_kerja)
                                                    <div class="text-xs text-green-600">
                                                        {{ floor($absen->menit_kerja / 60) }}j
                                                        {{ $absen->menit_kerja % 60 }}m</div>
                                                @endif
                                            @else
                                                <span class="text-gray-400">-</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if ($absen->izin)
                                                <x-ui.status-badge type="info">Izin</x-ui.status-badge>
                                            @elseif($absen->jam_masuk)
                                                @if ($absen->status === 'tepat_waktu')
                                                    <x-ui.status-badge type="hadir">Tepat Waktu</x-ui.status-badge>
                                                @else
                                                    <x-ui.status-badge type="telat">Terlambat</x-ui.status-badge>
                                                @endif
                                            @else
                                                <x-ui.status-badge type="default">-</x-ui.status-badge>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4">
                                            @if ($absen->lat_masuk && $absen->lng_masuk)
                                                <div class="text-xs text-gray-600">Masuk:
                                                    {{ number_format($absen->lat_masuk, 4) }},
                                                    {{ number_format($absen->lng_masuk, 4) }}</div>
                                            @endif
                                            @if ($absen->lat_pulang && $absen->lng_pulang)
                                                <div class="text-xs text-gray-600">Pulang:
                                                    {{ number_format($absen->lat_pulang, 4) }},
                                                    {{ number_format($absen->lng_pulang, 4) }}</div>
                                            @endif
                                            @if (!$absen->lat_masuk && !$absen->lat_pulang)
                                                <span class="text-gray-400">-</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="text-sm text-gray-700">
                                                {{ $absen->izin_keterangan ?? '-' }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center gap-2">
                                                <a href="{{ route('absen.edit', $absen) }}"
                                                    class="p-2 bg-blue-100 hover:bg-blue-200 text-blue-600 rounded-lg transition-colors"
                                                    title="Edit">
                                                    <x-icons.pencil class="w-4 h-4" />
                                                </a>
                                                <form method="POST" action="{{ route('absen.destroy', $absen) }}"
                                                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus absensi ini?')"
                                                    class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="p-2 bg-red-100 hover:bg-red-200 text-red-600 rounded-lg transition-colors"
                                                        title="Hapus">
                                                        <x-icons.trash class="w-4 h-4" />
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <x-dashboard.empty-state title="Tidak Ada Data"
                        message="Tidak ada data absensi untuk pegawai ini pada periode yang dipilih.">
                        <x-slot:icon>
                            <x-icons.calendar class="w-12 h-12" />
                        </x-slot:icon>
                    </x-dashboard.empty-state>
                @endif
            </x-ui.section-card>
        @else
            {{-- No User Selected --}}
            <x-ui.section-card>
                <x-dashboard.empty-state title="Pilih Pegawai"
                    message="Silakan pilih pegawai terlebih dahulu untuk melihat riwayat absensi.">
                    <x-slot:icon>
                        <x-icons.users class="w-12 h-12" />
                    </x-slot:icon>
                </x-dashboard.empty-state>
            </x-ui.section-card>
        @endif
    </div>
</x-app-layout>
