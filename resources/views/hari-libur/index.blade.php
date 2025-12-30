<x-app-layout>
    <x-slot name="header">Hari Libur & Hari Khusus</x-slot>
    <x-slot name="subtle">Kelola hari libur nasional, perusahaan, dan hari kerja khusus</x-slot>

    <div class="space-y-6">
        {{-- Actions --}}
        <div class="flex flex-col sm:flex-row justify-between gap-4">
            {{-- Year Filter --}}
            <form method="GET" action="{{ route('hari-libur.index') }}" class="flex gap-2">
                <select name="tahun"
                    class="px-3 py-2 rounded-lg border border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all">
                    @for($y = date('Y') - 2; $y <= date('Y') + 2; $y++)
                        <option value="{{ $y }}" {{ $y == $tahun ? 'selected' : '' }}>{{ $y }}</option>
                    @endfor
                </select>
                <button type="submit"
                    class="px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white font-semibold rounded-lg transition-all">
                    Filter
                </button>
            </form>

            {{-- Add Button --}}
            <a href="{{ route('hari-libur.create') }}"
                class="inline-flex items-center gap-2 px-4 py-2 bg-primary hover:bg-primaryDark text-white font-semibold rounded-lg transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Tambah Hari Libur / Hari Khusus
            </a>
        </div>

        {{-- Flash Messages --}}
        @if(session('success'))
            <div class="p-4 rounded-lg bg-green-100 text-green-700 border border-green-300">
                {{ session('success') }}
            </div>
        @endif

        {{-- Table --}}
        <div class="bg-white rounded-2xl shadow-xl p-6">
            <div class="flex items-center gap-3 mb-6">
                <div class="p-3 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl shadow-lg">
                    <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <h2 class="text-xl font-bold text-gray-800">Daftar Hari Libur & Hari Khusus {{ $tahun }}</h2>
            </div>

            @if($hariLiburs->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b border-gray-200">
                                <th class="text-left py-3 px-4 font-semibold text-gray-600">Tanggal</th>
                                <th class="text-left py-3 px-4 font-semibold text-gray-600">Tipe</th>
                                <th class="text-left py-3 px-4 font-semibold text-gray-600">Nama</th>
                                <th class="text-left py-3 px-4 font-semibold text-gray-600">Detail</th>
                                <th class="text-center py-3 px-4 font-semibold text-gray-600">Status</th>
                                <th class="text-center py-3 px-4 font-semibold text-gray-600">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($hariLiburs as $libur)
                                <tr class="border-b border-gray-100 hover:bg-gray-50 transition-colors">
                                    <td class="py-3 px-4">
                                        <div class="flex items-center gap-2">
                                            <div class="p-2 {{ ($libur->tipe ?? 'libur') === 'hari_khusus' ? 'bg-blue-100' : 'bg-red-100' }} rounded-lg">
                                                @if(($libur->tipe ?? 'libur') === 'hari_khusus')
                                                    <svg class="h-5 w-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                    </svg>
                                                @else
                                                    <svg class="h-5 w-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path>
                                                    </svg>
                                                @endif
                                            </div>
                                            <div>
                                                <p class="font-semibold text-gray-900">
                                                    {{ $libur->tanggal->format('d M Y') }}
                                                </p>
                                                <p class="text-sm text-gray-500">
                                                    {{ $libur->tanggal->translatedFormat('l') }}
                                                </p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-3 px-4">
                                        @if(($libur->tipe ?? 'libur') === 'hari_khusus')
                                            <span class="px-2 py-1 rounded-lg text-xs font-medium bg-blue-100 text-blue-700">
                                                Hari Khusus
                                            </span>
                                        @else
                                            <span class="px-2 py-1 rounded-lg text-xs font-medium bg-red-100 text-red-700">
                                                Hari Libur
                                            </span>
                                        @endif
                                    </td>
                                    <td class="py-3 px-4">
                                        <div>
                                            <span class="font-medium text-gray-900">{{ $libur->nama }}</span>
                                            @if($libur->keterangan)
                                                <p class="text-sm text-gray-500 truncate max-w-xs">{{ $libur->keterangan }}</p>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="py-3 px-4">
                                        <div class="space-y-1">
                                            @if(($libur->tipe ?? 'libur') === 'hari_khusus' && $libur->is_masuk)
                                                <div class="flex items-center gap-1 text-xs text-gray-600">
                                                    <svg class="w-3.5 h-3.5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                                    </svg>
                                                    Tetap Masuk
                                                </div>
                                                @if($libur->is_lembur)
                                                    <span class="inline-flex items-center px-1.5 py-0.5 rounded text-xs bg-orange-100 text-orange-700">
                                                        Lembur
                                                    </span>
                                                @else
                                                    <span class="inline-flex items-center px-1.5 py-0.5 rounded text-xs bg-green-100 text-green-700">
                                                        Kerja Biasa
                                                    </span>
                                                @endif
                                                @if($libur->jam_masuk && $libur->jam_keluar)
                                                    <div class="text-xs text-gray-500">
                                                        {{ \Carbon\Carbon::parse($libur->jam_masuk)->format('H:i') }} - {{ \Carbon\Carbon::parse($libur->jam_keluar)->format('H:i') }}
                                                    </div>
                                                @endif
                                                @if($libur->is_shift_enabled)
                                                    <span class="inline-flex items-center px-1.5 py-0.5 rounded text-xs bg-purple-100 text-purple-700">
                                                        Shift
                                                    </span>
                                                @endif
                                                @if($libur->is_lembur && $libur->upah_multiplier && $libur->upah_multiplier != 1)
                                                    <span class="inline-flex items-center px-1.5 py-0.5 rounded text-xs bg-yellow-100 text-yellow-700">
                                                        {{ $libur->upah_multiplier }}× Upah
                                                    </span>
                                                @endif
                                                @if($libur->pegawai_hadir && count($libur->pegawai_hadir) > 0)
                                                    <span class="inline-flex items-center px-1.5 py-0.5 rounded text-xs bg-gray-100 text-gray-700">
                                                        {{ count($libur->pegawai_hadir) }} Pegawai
                                                    </span>
                                                @endif
                                            @else
                                                <span class="text-xs text-gray-400">-</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="text-center py-3 px-4">
                                        <div class="flex flex-col items-center gap-1">
                                            @if($libur->is_recurring)
                                                <span class="px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-700">
                                                    Berulang
                                                </span>
                                            @endif
                                            @if($libur->is_wajib)
                                                <span class="px-2 py-0.5 rounded-full text-xs font-medium bg-orange-100 text-orange-700">
                                                    Wajib
                                                </span>
                                            @endif
                                            @if($libur->libur_tetap_masuk)
                                                <span class="px-2 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-700">
                                                    Libur Masuk
                                                </span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="text-center py-3 px-4">
                                        <div class="flex items-center justify-center gap-2">
                                            <a href="{{ route('hari-libur.edit', $libur) }}"
                                                class="p-2 text-blue-600 hover:bg-blue-100 rounded-lg transition-colors"
                                                title="Edit">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                                    </path>
                                                </svg>
                                            </a>
                                            <form action="{{ route('hari-libur.destroy', $libur) }}" method="POST"
                                                onsubmit="return confirm('Hapus hari ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="p-2 text-red-600 hover:bg-red-100 rounded-lg transition-colors"
                                                    title="Hapus">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                        </path>
                                                    </svg>
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
                <div class="text-center py-12 text-gray-500">
                    <svg class="h-16 w-16 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    <p class="text-lg font-medium">Belum ada hari libur atau hari khusus</p>
                    <p class="text-sm mt-1">Klik tombol "Tambah Hari Libur / Hari Khusus" untuk menambahkan</p>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
