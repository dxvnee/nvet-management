<x-app-layout>
    <x-slot name="header">Absen</x-slot>
    <x-slot name="subtle">Halaman absensi karyawan</x-slot>

    <!-- Riwayat Absen -->
        <div class="bg-white rounded-2xl shadow-xl p-6 animate-slide-up-delay-1">
            <div class="flex items-center gap-3 mb-6">
                <div class="p-3 bg-gradient-to-br from-primary to-primaryDark rounded-xl shadow-lg">
                    <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                </div>
                <h2 class="text-xl font-bold text-gray-800">Riwayat Absensi</h2>
            </div>

            @if($riwayat->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b border-gray-200">
                                <th class="text-left py-3 px-4 font-semibold text-gray-600">
                                    <a href="{{ request()->fullUrlWithQuery(['sort_by' => 'tanggal', 'sort_direction' => (request('sort_by') === 'tanggal' && request('sort_direction') === 'asc') ? 'desc' : 'asc']) }}"
                                       class="flex items-center space-x-1 hover:text-primary transition-colors">
                                        <span>Tanggal</span>
                                        @if(request('sort_by') === 'tanggal')
                                            @if(request('sort_direction') === 'asc')
                                                <svg class="w-4 h-4 text-primary" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M14.707 12.707a1 1 0 01-1.414 0L10 9.414l-3.293 3.293a1 1 0 01-1.414-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 010 1.414z" clip-rule="evenodd"></path>
                                                </svg>
                                            @else
                                                <svg class="w-4 h-4 text-primary" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 010-1.414l-4-4a1 1 0 01-1.414 0l-4 4a1 1 0 111.414 1.414z" clip-rule="evenodd"></path>
                                                </svg>
                                            @endif
                                        @else
                                            <svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 3a1 1 0 01.707.293l3 3a1 1 0 01-1.414 1.414L10 5.414 7.707 7.707a1 1 0 01-1.414-1.414l3-3A1 1 0 0110 3zm-3.707 9.293a1 1 0 011.414 0L10 14.586l2.293-2.293a1 1 0 011.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 01.707-1.707z" clip-rule="evenodd"></path>
                                            </svg>
                                        @endif
                                    </a>
                                </th>
                                <th class="text-left py-3 px-4 font-semibold text-gray-600">
                                    <a href="{{ request()->fullUrlWithQuery(['sort_by' => 'izin', 'sort_direction' => (request('sort_by') === 'izin' && request('sort_direction') === 'asc') ? 'desc' : 'asc']) }}"
                                       class="flex items-center space-x-1 hover:text-primary transition-colors">
                                        <span>Status</span>
                                        @if(request('sort_by') === 'izin')
                                            @if(request('sort_direction') === 'asc')
                                                <svg class="w-4 h-4 text-primary" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M14.707 12.707a1 1 0 01-1.414 0L10 9.414l-3.293 3.293a1 1 0 01-1.414-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 010 1.414z" clip-rule="evenodd"></path>
                                                </svg>
                                            @else
                                                <svg class="w-4 h-4 text-primary" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 010-1.414l-4-4a1 1 0 01-1.414 0l-4 4a1 1 0 111.414 1.414z" clip-rule="evenodd"></path>
                                                </svg>
                                            @endif
                                        @else
                                            <svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 3a1 1 0 01.707.293l3 3a1 1 0 01-1.414 1.414L10 5.414 7.707 7.707a1 1 0 01-1.414-1.414l3-3A1 1 0 0110 3zm-3.707 9.293a1 1 0 011.414 0L10 14.586l2.293-2.293a1 1 0 011.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 01.707-1.707z" clip-rule="evenodd"></path>
                                            </svg>
                                        @endif
                                    </a>
                                </th>
                                <th class="text-left py-3 px-4 font-semibold text-gray-600">
                                    <a href="{{ request()->fullUrlWithQuery(['sort_by' => 'jam_masuk', 'sort_direction' => (request('sort_by') === 'jam_masuk' && request('sort_direction') === 'asc') ? 'desc' : 'asc']) }}"
                                       class="flex items-center space-x-1 hover:text-primary transition-colors">
                                        <span>Jam Masuk</span>
                                        @if(request('sort_by') === 'jam_masuk')
                                            @if(request('sort_direction') === 'asc')
                                                <svg class="w-4 h-4 text-primary" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M14.707 12.707a1 1 0 01-1.414 0L10 9.414l-3.293 3.293a1 1 0 01-1.414-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 010 1.414z" clip-rule="evenodd"></path>
                                                </svg>
                                            @else
                                                <svg class="w-4 h-4 text-primary" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 010-1.414l-4-4a1 1 0 01-1.414 0l-4 4a1 1 0 111.414 1.414z" clip-rule="evenodd"></path>
                                                </svg>
                                            @endif
                                        @else
                                            <svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 3a1 1 0 01.707.293l3 3a1 1 0 01-1.414 1.414L10 5.414 7.707 7.707a1 1 0 01-1.414-1.414l3-3A1 1 0 0110 3zm-3.707 9.293a1 1 0 011.414 0L10 14.586l2.293-2.293a1 1 0 011.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 01.707-1.707z" clip-rule="evenodd"></path>
                                            </svg>
                                        @endif
                                    </a>
                                </th>
                                <th class="text-left py-3 px-4 font-semibold text-gray-600">
                                    <a href="{{ request()->fullUrlWithQuery(['sort_by' => 'jam_pulang', 'sort_direction' => (request('sort_by') === 'jam_pulang' && request('sort_direction') === 'asc') ? 'desc' : 'asc']) }}"
                                       class="flex items-center space-x-1 hover:text-primary transition-colors">
                                        <span>Jam Pulang</span>
                                        @if(request('sort_by') === 'jam_pulang')
                                            @if(request('sort_direction') === 'asc')
                                                <svg class="w-4 h-4 text-primary" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M14.707 12.707a1 1 0 01-1.414 0L10 9.414l-3.293 3.293a1 1 0 01-1.414-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 010 1.414z" clip-rule="evenodd"></path>
                                                </svg>
                                            @else
                                                <svg class="w-4 h-4 text-primary" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 010-1.414l-4-4a1 1 0 01-1.414 0l-4 4a1 1 0 111.414 1.414z" clip-rule="evenodd"></path>
                                                </svg>
                                            @endif
                                        @else
                                            <svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 3a1 1 0 01.707.293l3 3a1 1 0 01-1.414 1.414L10 5.414 7.707 7.707a1 1 0 01-1.414-1.414l3-3A1 1 0 0110 3zm-3.707 9.293a1 1 0 011.414 0L10 14.586l2.293-2.293a1 1 0 011.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 01.707-1.707z" clip-rule="evenodd"></path>
                                            </svg>
                                        @endif
                                    </a>
                                </th>
                                <th class="text-left py-3 px-4 font-semibold text-gray-600">
                                    <a href="{{ request()->fullUrlWithQuery(['sort_by' => 'menit_kerja', 'sort_direction' => (request('sort_by') === 'menit_kerja' && request('sort_direction') === 'asc') ? 'desc' : 'asc']) }}"
                                       class="flex items-center space-x-1 hover:text-primary transition-colors">
                                        <span>Total Kerja</span>
                                        @if(request('sort_by') === 'menit_kerja')
                                            @if(request('sort_direction') === 'asc')
                                                <svg class="w-4 h-4 text-primary" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M14.707 12.707a1 1 0 01-1.414 0L10 9.414l-3.293 3.293a1 1 0 01-1.414-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 010 1.414z" clip-rule="evenodd"></path>
                                                </svg>
                                            @else
                                                <svg class="w-4 h-4 text-primary" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 010-1.414l-4-4a1 1 0 01-1.414 0l-4 4a1 1 0 111.414 1.414z" clip-rule="evenodd"></path>
                                                </svg>
                                            @endif
                                        @else
                                            <svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 3a1 1 0 01.707.293l3 3a1 1 0 01-1.414 1.414L10 5.414 7.707 7.707a1 1 0 01-1.414-1.414l3-3A1 1 0 0110 3zm-3.707 9.293a1 1 0 011.414 0L10 14.586l2.293-2.293a1 1 0 011.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 01.707-1.707z" clip-rule="evenodd"></path>
                                            </svg>
                                        @endif
                                    </a>
                                </th>
                                <th class="text-left py-3 px-4 font-semibold text-gray-600">Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($riwayat as $absen)
                                <tr class="border-b border-gray-100 hover:bg-gray-50 transition-colors">
                                    <td class="py-3 px-4 text-gray-700">{{ $absen->tanggal->format('d M Y') }}</td>
                                    <td class="py-3 px-4">
                                        @if($absen->libur)
                                            <span class="px-3 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-700">Libur</span>
                                        @elseif($absen->tidak_hadir)
                                            <span class="px-3 py-1 rounded-full text-xs font-semibold bg-gray-700 text-white">Tidak Hadir</span>
                                        @elseif($absen->izin)
                                            <span class="px-3 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-700">Izin</span>
                                        @elseif($absen->telat)
                                            <span class="px-3 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-700">Telat {{ $absen->menit_telat }} menit</span>
                                        @elseif($absen->jam_masuk)
                                            <span class="px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700">Tepat Waktu</span>
                                        @else
                                            <span class="px-3 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-700">-</span>
                                        @endif
                                    </td>
                                    <td class="py-3 px-4 text-gray-700">{{ $absen->jam_masuk ? $absen->jam_masuk->format('H:i') : '-' }}</td>
                                    <td class="py-3 px-4 text-gray-700">{{ $absen->jam_pulang ? $absen->jam_pulang->format('H:i') : '-' }}</td>
                                    <td class="py-3 px-4 text-gray-700">
                                        @if($absen->menit_kerja)
                                            {{ floor($absen->menit_kerja / 60) }} jam {{ $absen->menit_kerja % 60 }} menit
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td class="py-3 px-4 text-gray-500 text-sm">{{ $absen->izin_keterangan ?? '-' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-8 text-gray-500">
                    <svg class="h-12 w-12 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                    <p>Belum ada riwayat absensi</p>
                </div>
            @endif

            @if($riwayat->hasPages())
                <div class="mt-6">
                    <div class="flex justify-center">
                        <div class="flex space-x-1">
                            {{-- Previous Page Link --}}
                            @if ($riwayat->onFirstPage())
                                <span class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-not-allowed leading-5 rounded-l-xl">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                    </svg>
                                </span>
                            @else
                                <a href="{{ $riwayat->previousPageUrl() }}" class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 leading-5 rounded-l-xl hover:bg-primaryUltraLight hover:border-primary transition-colors duration-200">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                    </svg>
                                </a>
                            @endif

                            {{-- Pagination Elements --}}
                            @foreach ($riwayat->getUrlRange(1, $riwayat->lastPage()) as $page => $url)
                                @if ($page == $riwayat->currentPage())
                                    <span class="relative inline-flex items-center px-4 py-2 text-sm font-bold text-white bg-gradient-to-r from-primary to-primaryDark border border-primary leading-5 rounded-xl shadow-lg">
                                        {{ $page }}
                                    </span>
                                @else
                                    <a href="{{ $url }}" class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 leading-5 hover:bg-primaryUltraLight hover:border-primary hover:text-primary transition-all duration-200 rounded-xl">
                                        {{ $page }}
                                    </a>
                                @endif
                            @endforeach

                            {{-- Next Page Link --}}
                            @if ($riwayat->hasMorePages())
                                <a href="{{ $riwayat->nextPageUrl() }}" class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 leading-5 rounded-r-xl hover:bg-primaryUltraLight hover:border-primary transition-colors duration-200">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                                    </svg>
                                </a>
                            @else
                                <span class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-not-allowed leading-5 rounded-r-xl">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                                    </svg>
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            @endif
        </div>

</x-app-layout>
