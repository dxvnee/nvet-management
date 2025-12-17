<x-app-layout>
    <x-slot name="header">Detail Absensi - {{ \Carbon\Carbon::parse($tanggal)->format('d F Y') }}</x-slot>
    <x-slot name="subtle">Rincian absensi pegawai pada tanggal tersebut</x-slot>

    <div class="space-y-6">
        {{-- Back Button --}}
        <a href="{{ url()->previous() }}"
            class="inline-flex items-center gap-2 text-gray-600 hover:text-primary transition-colors animate-slide-up">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18">
                </path>
            </svg>
            Kembali
        </a>
        {{-- Absensi List --}}
        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
            @if($absensiHari->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pegawai</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jam Masuk</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jam Pulang</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Lokasi</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Keterangan</th>
                                <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($absensiHari as $absen)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10">
                                                <img class="h-10 w-10 rounded-full"
                                                    src="{{ $absen->user->avatar ? asset('storage/' . $absen->user->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($absen->user->name) . '&color=7F9CF5&background=EBF4FF&size=40' }}"
                                                    alt="Avatar">
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">
                                                    {{ $absen->user->name }}
                                                </div>
                                                <div class="text-sm text-gray-500">
                                                    {{ $absen->user->jabatan }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($absen->jam_masuk)
                                            <div class="text-sm text-gray-900">
                                                {{ $absen->jam_masuk->format('H:i') }}
                                            </div>
                                            @if($absen->status === 'telat')
                                                <div class="text-xs text-red-600">
                                                    Terlambat {{ $absen->menit_telat }} menit
                                                </div>
                                            @endif
                                        @else
                                            <span class="text-gray-400">-</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($absen->jam_pulang)
                                            <div class="text-sm text-gray-900">
                                                {{ $absen->jam_pulang->format('H:i') }}
                                            </div>
                                            @if($absen->menit_kerja)
                                                <div class="text-xs text-green-600">
                                                    {{ floor($absen->menit_kerja / 60) }}j {{ $absen->menit_kerja % 60 }}m
                                                </div>
                                            @endif
                                        @else
                                            <span class="text-gray-400">-</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($absen->izin)
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                                Izin
                                            </span>
                                        @elseif($absen->jam_masuk)
                                            @if($absen->status === 'tepat_waktu')
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                    Tepat Waktu
                                                </span>
                                            @else
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                    Terlambat
                                                </span>
                                            @endif
                                        @else
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                                Belum Absen
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        @if($absen->lat_masuk && $absen->lng_masuk)
                                            <div class="text-xs">
                                                Masuk: {{ number_format($absen->lat_masuk, 6) }}, {{ number_format($absen->lng_masuk, 6) }}
                                            </div>
                                        @endif
                                        @if($absen->lat_pulang && $absen->lng_pulang)
                                            <div class="text-xs">
                                                Pulang: {{ number_format($absen->lat_pulang, 6) }}, {{ number_format($absen->lng_pulang, 6) }}
                                            </div>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        @if($absen->izin && $absen->izin_keterangan)
                                            {{ $absen->izin_keterangan }}
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        @if($absen->exists)
                                            <a href="{{ route('absen.edit', $absen) }}"
                                                class="text-primary hover:text-primaryDark transition-colors">
                                                Edit
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="p-12 text-center">
                    <div class="text-gray-400 mb-4">
                        <svg class="mx-auto h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Tidak ada absensi</h3>
                    <p class="text-gray-500">Belum ada pegawai yang melakukan absensi pada tanggal ini.</p>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
