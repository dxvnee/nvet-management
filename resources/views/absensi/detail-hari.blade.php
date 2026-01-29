<x-app-layout>
    <x-slot name="header">Detail Absensi - {{ \Carbon\Carbon::parse($tanggal)->format('d F Y') }}</x-slot>
    <x-slot name="subtle">Rincian absensi pegawai pada tanggal tersebut</x-slot>

    <div class="space-y-6">
        {{-- Back Button --}}
        <x-ui.back-button label="Kembali" />

        {{-- Absensi List --}}
        <x-ui.section-card animation="animate-slide-up-delay-1">
            <x-slot:iconSlot>
                <x-icons.calendar class="h-6 w-6 text-white" />
            </x-slot:iconSlot>
            <x-slot:header>
                <h2 class="text-xl font-bold text-gray-800">Detail Absensi</h2>
            </x-slot:header>

            @if ($absensiHari->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b border-gray-200">
                                <x-ui.sortable-header column="name" label="Pegawai" :currentSort="request('sort_by')" :currentDirection="request('sort_direction')"
                                    align="center" />
                                <x-ui.sortable-header column="jam_masuk" label="Jam Masuk" :currentSort="request('sort_by')"
                                    :currentDirection="request('sort_direction')" align="center" />
                                <x-ui.sortable-header column="jam_pulang" label="Jam Pulang" :currentSort="request('sort_by')"
                                    :currentDirection="request('sort_direction')" align="center" />
                                <x-ui.sortable-header column="status" label="Status" :currentSort="request('sort_by')" :currentDirection="request('sort_direction')"
                                    align="center" />
                                <th class="text-center py-3 px-4 font-semibold text-gray-600">Lokasi</th>
                                <th class="text-center py-3 px-4 font-semibold text-gray-600">Foto</th>
                                <th class="text-center py-3 px-4 font-semibold text-gray-600">Keterangan</th>
                                <th class="text-center py-3 px-4 font-semibold text-gray-600">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($absensiHari as $absen)
                                <x-absensi.table-row :absen="$absen" :tanggal="$tanggal" />
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <x-dashboard.empty-state title="Belum Ada Data" message="Belum ada data absensi">
                    <x-slot:icon>
                        <x-icons.calendar class="w-12 h-12" />
                    </x-slot:icon>
                </x-dashboard.empty-state>
            @endif
        </x-ui.section-card>

        {{-- Photo Modal --}}
        <x-absensi.photo-modal />
    </div>
</x-app-layout>
