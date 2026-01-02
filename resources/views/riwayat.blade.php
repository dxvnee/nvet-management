<x-app-layout>
    <x-slot name="header">Riwayat Absensi</x-slot>
    <x-slot name="subtle">Pantau dan kelola riwayat absensi karyawan</x-slot>

    <div class="space-y-6">
        {{-- Header Section --}}
        <div class="relative overflow-hidden bg-gradient-to-br from-primary via-primaryDark to-primary rounded-3xl shadow-2xl p-6 md:p-8 text-white animate-slide-up">
            {{-- Background Pattern --}}
            <div class="absolute inset-0 opacity-10">
                <div class="absolute -top-10 -right-10 w-40 h-40 bg-white rounded-full"></div>
                <div class="absolute -bottom-10 -left-10 w-32 h-32 bg-white rounded-full"></div>
                <div class="absolute top-1/2 left-1/3 w-20 h-20 bg-white rounded-full"></div>
            </div>

            <div class="relative flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
                <div class="flex items-center gap-4">
                    <div class="p-4 bg-white/20 backdrop-blur-sm rounded-2xl">
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-2xl md:text-3xl font-bold mb-1">Riwayat Absensi</h2>
                        <p class="text-white/80 text-sm md:text-base flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            {{ now()->locale('id')->isoFormat('dddd, D MMMM Y') }}
                        </p>
                    </div>
                </div>
                <div class="flex items-center gap-4">
                    <div class="hidden md:flex flex-col items-center bg-white/10 backdrop-blur-sm rounded-2xl px-4 py-3">
                        <span class="text-xs text-white/70 uppercase tracking-wider">Total Data</span>
                        <span class="text-lg font-semibold">{{ $riwayat->total() }}</span>
                    </div>
                    <a href="{{ route('absen.riwayatKalender') }}" 
                       class="group flex items-center gap-2 px-4 py-2.5 bg-white/20 hover:bg-white/30 backdrop-blur-sm rounded-xl transition-all duration-300">
                        <svg class="w-5 h-5 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <span class="font-medium">Tampilan Kalender</span>
                    </a>
                </div>
            </div>
        </div>

        {{-- Riwayat Absen --}}
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6 animate-slide-up-delay-1">

            @if($riwayat->count() > 0)
                {{-- Filter & Sort Controls --}}
                <div class="flex flex-col sm:flex-row gap-4 mb-6 p-4 bg-gray-50 rounded-xl border border-gray-100">
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                        </svg>
                        <span class="text-sm font-medium text-gray-700">Urutkan:</span>
                    </div>
                    <div class="flex flex-wrap gap-2">
                        <a href="{{ request()->fullUrlWithQuery(['sort_by' => 'tanggal', 'sort_direction' => (request('sort_by') === 'tanggal' && request('sort_direction') === 'asc') ? 'desc' : 'asc']) }}"
                           class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-medium rounded-lg transition-all
                                  {{ request('sort_by') === 'tanggal' ? 'bg-primary text-white shadow-sm' : 'bg-white text-gray-600 hover:bg-gray-100 border border-gray-200' }}">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            Tanggal
                            @if(request('sort_by') === 'tanggal')
                                @if(request('sort_direction') === 'asc')
                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M14.707 12.707a1 1 0 01-1.414 0L10 9.414l-3.293 3.293a1 1 0 01-1.414-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 010 1.414z" clip-rule="evenodd"></path>
                                    </svg>
                                @else
                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 010-1.414l-4-4a1 1 0 01-1.414 0l-4 4a1 1 0 111.414 1.414z" clip-rule="evenodd"></path>
                                    </svg>
                                @endif
                            @endif
                        </a>
                        <a href="{{ request()->fullUrlWithQuery(['sort_by' => 'jam_masuk', 'sort_direction' => (request('sort_by') === 'jam_masuk' && request('sort_direction') === 'asc') ? 'desc' : 'asc']) }}"
                           class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-medium rounded-lg transition-all
                                  {{ request('sort_by') === 'jam_masuk' ? 'bg-primary text-white shadow-sm' : 'bg-white text-gray-600 hover:bg-gray-100 border border-gray-200' }}">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Jam Masuk
                            @if(request('sort_by') === 'jam_masuk')
                                @if(request('sort_direction') === 'asc')
                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M14.707 12.707a1 1 0 01-1.414 0L10 9.414l-3.293 3.293a1 1 0 01-1.414-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 010 1.414z" clip-rule="evenodd"></path>
                                    </svg>
                                @else
                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 010-1.414l-4-4a1 1 0 01-1.414 0l-4 4a1 1 0 111.414 1.414z" clip-rule="evenodd"></path>
                                    </svg>
                                @endif
                            @endif
                        </a>
                        <a href="{{ request()->fullUrlWithQuery(['sort_by' => 'menit_kerja', 'sort_direction' => (request('sort_by') === 'menit_kerja' && request('sort_direction') === 'asc') ? 'desc' : 'asc']) }}"
                           class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-medium rounded-lg transition-all
                                  {{ request('sort_by') === 'menit_kerja' ? 'bg-primary text-white shadow-sm' : 'bg-white text-gray-600 hover:bg-gray-100 border border-gray-200' }}">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Total Kerja
                            @if(request('sort_by') === 'menit_kerja')
                                @if(request('sort_direction') === 'asc')
                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M14.707 12.707a1 1 0 01-1.414 0L10 9.414l-3.293 3.293a1 1 0 01-1.414-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 010 1.414z" clip-rule="evenodd"></path>
                                    </svg>
                                @else
                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 010-1.414l-4-4a1 1 0 01-1.414 0l-4 4a1 1 0 111.414 1.414z" clip-rule="evenodd"></path>
                                    </svg>
                                @endif
                            @endif
                        </a>
                    </div>
                </div>

                {{-- Riwayat Cards --}}
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach($riwayat as $absen)
                        <div class="group bg-gradient-to-br from-white to-gray-50/50 rounded-2xl shadow-sm hover:shadow-xl border border-gray-100 hover:border-primary/20 transition-all duration-300 p-5 hover:transform hover:scale-[1.02]">
                            {{-- Header --}}
                            <div class="flex items-center justify-between mb-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-xl flex items-center justify-center shadow-sm
                                                @if($absen->libur) bg-gradient-to-br from-blue-100 to-indigo-100
                                                @elseif($absen->tidak_hadir) bg-gradient-to-br from-gray-100 to-gray-200
                                                @elseif($absen->izin) bg-gradient-to-br from-amber-100 to-yellow-100
                                                @elseif($absen->telat) bg-gradient-to-br from-rose-100 to-red-100
                                                @elseif($absen->jam_masuk) bg-gradient-to-br from-emerald-100 to-green-100
                                                @else bg-gradient-to-br from-gray-100 to-gray-200
                                                @endif">
                                        @if($absen->libur)
                                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                            </svg>
                                        @elseif($absen->tidak_hadir)
                                            <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                            </svg>
                                        @elseif($absen->izin)
                                            <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                            </svg>
                                        @elseif($absen->telat)
                                            <svg class="w-5 h-5 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                        @elseif($absen->jam_masuk)
                                            <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                            </svg>
                                        @else
                                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                                            </svg>
                                        @endif
                                    </div>
                                    <div>
                                        <h3 class="font-bold text-gray-800 text-lg">{{ $absen->tanggal->locale('id')->isoFormat('dddd') }}</h3>
                                        <p class="text-sm text-gray-500">{{ $absen->tanggal->format('d M Y') }}</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    @if($absen->libur)
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-blue-50 text-blue-600 ring-1 ring-blue-200">
                                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                                            Libur
                                        </span>
                                    @elseif($absen->tidak_hadir)
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-gray-50 text-gray-600 ring-1 ring-gray-200">
                                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/></svg>
                                            Tidak Hadir
                                        </span>
                                    @elseif($absen->izin)
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-amber-50 text-amber-600 ring-1 ring-amber-200">
                                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                                            Izin
                                        </span>
                                    @elseif($absen->telat)
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-rose-50 text-rose-600 ring-1 ring-rose-200">
                                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm.75-11.25a.75.75 0 00-1.5 0v2.5h-2.5a.75.75 0 000 1.5h2.5v2.5a.75.75 0 001.5 0v-2.5h2.5a.75.75 0 000-1.5h-2.5v-2.5z" clip-rule="evenodd"/></svg>
                                            Telat {{ $absen->menit_telat }}m
                                        </span>
                                    @elseif($absen->jam_masuk)
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-600 ring-1 ring-emerald-200">
                                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                                            Tepat Waktu
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-gray-50 text-gray-600 ring-1 ring-gray-200">
                                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 018 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                                            -
                                        </span>
                                    @endif
                                </div>
                            </div>

                            {{-- Content --}}
                            <div class="space-y-3">
                                {{-- Jam Masuk --}}
                                <div class="flex items-center justify-between p-3 bg-white rounded-xl border border-gray-100">
                                    <div class="flex items-center gap-2">
                                        <div class="w-8 h-8 rounded-lg bg-emerald-100 flex items-center justify-center">
                                            <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                            </svg>
                                        </div>
                                        <span class="text-sm font-medium text-gray-600">Masuk</span>
                                    </div>
                                    <span class="text-lg font-bold text-gray-800">{{ $absen->jam_masuk ? $absen->jam_masuk->format('H:i') : '—' }}</span>
                                </div>

                                {{-- Jam Pulang --}}
                                <div class="flex items-center justify-between p-3 bg-white rounded-xl border border-gray-100">
                                    <div class="flex items-center gap-2">
                                        <div class="w-8 h-8 rounded-lg bg-blue-100 flex items-center justify-center">
                                            <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                            </svg>
                                        </div>
                                        <span class="text-sm font-medium text-gray-600">Pulang</span>
                                    </div>
                                    <span class="text-lg font-bold text-gray-800">{{ $absen->jam_pulang ? $absen->jam_pulang->format('H:i') : '—' }}</span>
                                </div>

                                {{-- Total Kerja --}}
                                <div class="flex items-center justify-between p-3 bg-white rounded-xl border border-gray-100">
                                    <div class="flex items-center gap-2">
                                        <div class="w-8 h-8 rounded-lg bg-purple-100 flex items-center justify-center">
                                            <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                        </div>
                                        <span class="text-sm font-medium text-gray-600">Total Kerja</span>
                                    </div>
                                    <span class="text-lg font-bold text-gray-800">
                                        @if($absen->menit_kerja)
                                            {{ floor($absen->menit_kerja / 60) }}j {{ $absen->menit_kerja % 60 }}m
                                        @else
                                            —
                                        @endif
                                    </span>
                                </div>

                                {{-- Keterangan --}}
                                @if($absen->izin_keterangan)
                                    <div class="p-3 bg-amber-50 rounded-xl border border-amber-100">
                                        <div class="flex items-start gap-2">
                                            <svg class="w-4 h-4 text-amber-600 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                                            </svg>
                                            <div>
                                                <p class="text-xs font-medium text-amber-700 uppercase tracking-wider mb-1">Keterangan</p>
                                                <p class="text-sm text-amber-800">{{ $absen->izin_keterangan }}</p>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                {{-- Enhanced Empty State --}}
                <div class="text-center py-16">
                    <div class="relative mb-8">
                        <div class="w-24 h-24 mx-auto bg-gradient-to-br from-gray-100 to-gray-200 rounded-3xl flex items-center justify-center shadow-lg">
                            <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                            </svg>
                        </div>
                        <div class="absolute -top-2 -right-2 w-8 h-8 bg-primary rounded-full flex items-center justify-center shadow-lg">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="max-w-md mx-auto">
                        <h3 class="text-xl font-bold text-gray-800 mb-2">Belum Ada Riwayat Absensi</h3>
                        <p class="text-gray-600 mb-6 leading-relaxed">
                            Riwayat absensi Anda akan muncul di sini setelah Anda mulai melakukan absensi masuk dan pulang kerja.
                        </p>
                        <div class="flex flex-col sm:flex-row gap-3 justify-center">
                            <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-primary text-white font-medium rounded-xl hover:bg-primary/90 transition-all shadow-lg hover:shadow-xl">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5a2 2 0 012-2h4a2 2 0 012 2v2H8V5z"></path>
                                </svg>
                                Lihat Dashboard
                            </a>
                            <a href="{{ route('absen.create') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-white text-gray-700 font-medium rounded-xl border border-gray-200 hover:border-primary hover:text-primary transition-all shadow-sm hover:shadow-md">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                </svg>
                                Absen Sekarang
                            </a>
                        </div>
                    </div>
                </div>
            @endif

            @if($riwayat->hasPages())
                {{-- Modern Pagination --}}
                <div class="mt-8 flex flex-col sm:flex-row items-center justify-between gap-4">
                    <div class="text-sm text-gray-600">
                        Menampilkan <span class="font-semibold text-gray-800">{{ $riwayat->firstItem() }}</span> sampai <span class="font-semibold text-gray-800">{{ $riwayat->lastItem() }}</span> dari <span class="font-semibold text-gray-800">{{ $riwayat->total() }}</span> hasil
                    </div>
                    <div class="flex items-center gap-2">
                        {{-- Previous Button --}}
                        @if($riwayat->onFirstPage())
                            <button disabled class="flex items-center gap-2 px-4 py-2 text-sm font-medium text-gray-400 bg-gray-100 rounded-xl cursor-not-allowed">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                                </svg>
                                Sebelumnya
                            </button>
                        @else
                            <a href="{{ $riwayat->previousPageUrl() }}" class="flex items-center gap-2 px-4 py-2 text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 border border-gray-200 rounded-xl transition-all hover:shadow-sm hover:border-primary/30">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                                </svg>
                                Sebelumnya
                            </a>
                        @endif

                        {{-- Page Numbers --}}
                        <div class="flex items-center gap-1">
                            @foreach($riwayat->getUrlRange(1, $riwayat->lastPage()) as $page => $url)
                                @if($page == $riwayat->currentPage())
                                    <span class="flex items-center justify-center w-10 h-10 text-sm font-bold text-white bg-primary rounded-xl shadow-sm">{{ $page }}</span>
                                @elseif($page == 1 || $page == $riwayat->lastPage() || abs($page - $riwayat->currentPage()) <= 2)
                                    <a href="{{ $url }}" class="flex items-center justify-center w-10 h-10 text-sm font-medium text-gray-700 bg-white hover:bg-primary hover:text-white border border-gray-200 rounded-xl transition-all hover:shadow-sm">{{ $page }}</a>
                                @elseif($page == $riwayat->currentPage() - 3 || $page == $riwayat->currentPage() + 3)
                                    <span class="flex items-center justify-center w-6 h-10 text-sm text-gray-400">...</span>
                                @endif
                            @endforeach
                        </div>

                        {{-- Next Button --}}
                        @if($riwayat->hasMorePages())
                            <a href="{{ $riwayat->nextPageUrl() }}" class="flex items-center gap-2 px-4 py-2 text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 border border-gray-200 rounded-xl transition-all hover:shadow-sm hover:border-primary/30">
                                Selanjutnya
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </a>
                        @else
                            <button disabled class="flex items-center gap-2 px-4 py-2 text-sm font-medium text-gray-400 bg-gray-100 rounded-xl cursor-not-allowed">
                                Selanjutnya
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </button>
                        @endif
                    </div>
                </div>
            @endif
        </div>

</x-app-layout>
