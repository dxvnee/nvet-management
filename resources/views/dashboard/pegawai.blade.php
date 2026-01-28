<x-app-layout>
    <x-slot name="header">Dashboard</x-slot>
    <x-slot name="subtle">Selamat datang kembali, {{ $user->name }}!</x-slot>

    <div class="space-y-6">
        {{-- Welcome Section Pegawai --}}
        <div
            class="relative overflow-hidden bg-gradient-to-br from-primary via-primaryDark to-primary rounded-3xl shadow-2xl p-6 md:p-8 text-white animate-slide-up">
            {{-- Background Pattern --}}
            <div class="absolute inset-0 opacity-10">
                <div class="absolute -top-10 -right-10 w-40 h-40 bg-white rounded-full"></div>
                <div class="absolute -bottom-10 -left-10 w-32 h-32 bg-white rounded-full"></div>
            </div>

            <div class="relative flex flex-col md:flex-row items-center gap-5">
                <div class="relative">
                    <img src="{{ $user->avatar ? asset('storage/' . $user->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&size=80&background=ffffff&color=0D9488' }}"
                        class="w-20 h-20 md:w-24 md:h-24 rounded-2xl border-4 border-white/30 shadow-xl">
                    <span
                        class="absolute -bottom-1 -right-1 w-6 h-6 bg-emerald-400 rounded-full border-2 border-white flex items-center justify-center">
                        <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                clip-rule="evenodd" />
                        </svg>
                    </span>
                </div>
                <div class="text-center md:text-left flex-1">
                    <h2 class="text-2xl md:text-3xl font-bold mb-1">Halo, {{ $user->name }}! 👋</h2>
                    <div class="flex flex-wrap items-center justify-center md:justify-start gap-3 mt-2">
                        <span
                            class="inline-flex items-center gap-1.5 px-3 py-1 bg-white/20 backdrop-blur-sm rounded-full text-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                </path>
                            </svg>
                            {{ $user->jabatan }}
                        </span>
                        <span
                            class="inline-flex items-center gap-1.5 px-3 py-1 bg-white/20 backdrop-blur-sm rounded-full text-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                </path>
                            </svg>
                            {{ now()->locale('id')->isoFormat('dddd, D MMMM Y') }}
                        </span>
                    </div>
                </div>
                <div class="hidden lg:block bg-white/10 backdrop-blur-sm rounded-2xl px-5 py-3 text-center">
                    <p class="text-xs text-white/70 uppercase tracking-wider mb-1">Waktu</p>
                    <p class="text-2xl font-bold font-mono" x-data="{ time: '' }" x-init="setInterval(() => time = new Date().toLocaleTimeString('id-ID'), 1000)"
                        x-text="time"></p>
                </div>
            </div>
        </div>

        {{-- Status Absensi Hari Ini --}}
        <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100 animate-slide-up-delay-1">
            <div class="flex items-center gap-3 mb-6">
                <div class="p-3 bg-gradient-to-br from-primary to-primaryDark rounded-xl shadow-lg">
                    <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-gray-800">Status Absensi Hari Ini</h3>
                    <p class="text-xs text-gray-500">{{ now()->locale('id')->isoFormat('dddd, D MMMM Y') }}</p>
                </div>
            </div>

            @if (isset($absensiToday) &&
                    ($absensiToday->jam_masuk != null || $absensiToday->izin != false || $absensiToday->libur != false))
                @if ($absensiToday->libur)
                    {{-- Status Libur --}}
                    <div
                        class="flex flex-col md:flex-row items-center gap-6 p-6 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-2xl border border-blue-100">
                        <div
                            class="w-20 h-20 rounded-2xl bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center shadow-lg">
                            <svg class="h-10 w-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z">
                                </path>
                            </svg>
                        </div>
                        <div class="flex-1 text-center md:text-left">
                            <h4 class="text-xl font-bold text-blue-700 mb-1">Hari Libur 🎉</h4>
                            <p class="text-gray-600">Hari ini adalah hari libur anda!</p>
                            @if ($absensiToday->libur_keterangan)
                                <p class="text-sm text-blue-600 mt-2 bg-blue-100 inline-block px-3 py-1 rounded-full">
                                    {{ $absensiToday->libur_keterangan }}</p>
                            @endif
                        </div>
                    </div>
                @elseif($absensiToday->izin)
                    {{-- Status Izin --}}
                    <div
                        class="flex flex-col md:flex-row items-center gap-6 p-6 bg-gradient-to-r from-amber-50 to-yellow-50 rounded-2xl border border-amber-100">
                        <div
                            class="w-20 h-20 rounded-2xl bg-gradient-to-br from-amber-500 to-yellow-500 flex items-center justify-center shadow-lg">
                            <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                </path>
                            </svg>
                        </div>
                        <div class="flex-1 text-center md:text-left">
                            <h4 class="text-xl font-bold text-amber-700 mb-1">Izin Hari Ini 📝</h4>
                            @if ($absensiToday->izin_keterangan)
                                <p class="text-gray-600">{{ $absensiToday->izin_keterangan }}</p>
                            @else
                                <p class="text-gray-500">Izin tanpa keterangan</p>
                            @endif
                        </div>
                    </div>
                @else
                    {{-- Status Absen Normal --}}
                    <div
                        class="flex flex-col md:flex-row items-center gap-6 p-6 bg-gradient-to-r from-emerald-50 to-green-50 rounded-2xl border border-emerald-100">
                        <div
                            class="w-20 h-20 rounded-2xl bg-gradient-to-br from-emerald-500 to-green-600 flex items-center justify-center shadow-lg">
                            <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <div class="flex-1 text-center md:text-left">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="bg-white rounded-xl p-4 shadow-sm border border-emerald-100">
                                    <div class="flex items-center gap-2 mb-1">
                                        <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1">
                                            </path>
                                        </svg>
                                        <span
                                            class="text-xs font-medium text-gray-500 uppercase tracking-wider">Masuk</span>
                                    </div>
                                    <span
                                        class="text-2xl font-bold text-gray-800">{{ $absensiToday->jam_masuk ? $absensiToday->jam_masuk->format('H:i') : '-' }}</span>
                                    @if (!$absensiToday->telat)
                                        <span
                                            class="ml-2 text-xs px-2 py-0.5 bg-emerald-100 text-emerald-700 rounded-full font-medium">✓
                                            Tepat</span>
                                    @else
                                        <span
                                            class="ml-2 text-xs px-2 py-0.5 bg-rose-100 text-rose-700 rounded-full font-medium">{{ $absensiToday->menit_telat }}m
                                            telat</span>
                                    @endif
                                </div>
                                <div class="bg-white rounded-xl p-4 shadow-sm border border-emerald-100">
                                    <div class="flex items-center gap-2 mb-1">
                                        <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                                            </path>
                                        </svg>
                                        <span
                                            class="text-xs font-medium text-gray-500 uppercase tracking-wider">Keluar</span>
                                    </div>
                                    <span
                                        class="text-2xl font-bold text-gray-800">{{ $absensiToday->jam_pulang ? $absensiToday->jam_pulang->format('H:i') : '—' }}</span>
                                    @if ($absensiToday->jam_pulang)
                                        <span
                                            class="ml-2 text-xs px-2 py-0.5 bg-blue-100 text-blue-700 rounded-full font-medium">✓
                                            Selesai</span>
                                    @else
                                        <span
                                            class="ml-2 text-xs px-2 py-0.5 bg-amber-100 text-amber-700 rounded-full font-medium">Belum</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @if (!$absensiToday->jam_pulang)
                            <a href="{{ route('absen.index') }}"
                                class="shrink-0 px-6 py-3 bg-gradient-to-r from-primary to-primaryDark text-white font-bold rounded-xl hover:shadow-lg transition-all hover:scale-105 flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                                    </path>
                                </svg>
                                Absen Pulang
                            </a>
                        @endif
                    </div>
                @endif
            @else
                <div
                    class="text-center py-10 px-4 bg-gradient-to-r from-amber-50 to-yellow-50 rounded-2xl border border-amber-100">
                    <div
                        class="w-24 h-24 bg-gradient-to-br from-amber-400 to-yellow-500 rounded-2xl flex items-center justify-center mx-auto mb-5 shadow-lg">
                        <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h4 class="text-2xl font-bold text-amber-700 mb-2">Belum Absen Hari Ini</h4>
                    <p class="text-gray-600 mb-6">Jangan lupa untuk melakukan absensi!</p>
                    <a href="{{ route('absen.index') }}"
                        class="inline-flex items-center gap-2 px-8 py-4 bg-gradient-to-r from-primary to-primaryDark text-white font-bold rounded-xl hover:shadow-xl transition-all hover:scale-105">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Absen Sekarang
                    </a>
                </div>
            @endif
        </div>

        {{-- Stats Pegawai --}}
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
            <div
                class="group bg-white rounded-2xl shadow-lg p-5 border border-gray-100 hover:border-emerald-200 transition-all hover:shadow-xl animate-slide-up-delay-2">
                <div class="flex items-center gap-3 mb-3">
                    <div
                        class="p-2.5 bg-gradient-to-br from-emerald-500 to-green-600 rounded-xl shadow-md group-hover:scale-110 transition-transform">
                        <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <span
                        class="text-2xl lg:text-3xl font-bold bg-gradient-to-r from-emerald-500 to-green-600 bg-clip-text text-transparent">{{ $totalHadir }}</span>
                </div>
                <p class="text-sm text-gray-500 font-medium">Hadir Bulan Ini</p>
            </div>
            <div
                class="group bg-white rounded-2xl shadow-lg p-5 border border-gray-100 hover:border-rose-200 transition-all hover:shadow-xl animate-slide-up-delay-2">
                <div class="flex items-center gap-3 mb-3">
                    <div
                        class="p-2.5 bg-gradient-to-br from-rose-500 to-red-600 rounded-xl shadow-md group-hover:scale-110 transition-transform">
                        <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </div>
                    <span
                        class="text-2xl lg:text-3xl font-bold bg-gradient-to-r from-rose-500 to-red-600 bg-clip-text text-transparent">{{ $totalTidakHadir }}</span>
                </div>
                <p class="text-sm text-gray-500 font-medium">Tidak Hadir</p>
            </div>
            <div
                class="group bg-white rounded-2xl shadow-lg p-5 border border-gray-100 hover:border-amber-200 transition-all hover:shadow-xl animate-slide-up-delay-3">
                <div class="flex items-center gap-3 mb-3">
                    <div
                        class="p-2.5 bg-gradient-to-br from-amber-500 to-yellow-500 rounded-xl shadow-md group-hover:scale-110 transition-transform">
                        <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <span
                        class="text-2xl lg:text-3xl font-bold bg-gradient-to-r from-amber-500 to-yellow-600 bg-clip-text text-transparent">{{ $totalMenitTelat }}</span>
                </div>
                <p class="text-sm text-gray-500 font-medium">Total Menit Telat</p>
            </div>
            <div
                class="group bg-white rounded-2xl shadow-lg p-5 border border-gray-100 hover:border-orange-200 transition-all hover:shadow-xl animate-slide-up-delay-3">
                <div class="flex items-center gap-3 mb-3">
                    <div
                        class="p-2.5 bg-gradient-to-br from-orange-500 to-red-500 rounded-xl shadow-md group-hover:scale-110 transition-transform">
                        <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                            </path>
                        </svg>
                    </div>
                    <span
                        class="text-2xl lg:text-3xl font-bold {{ $totalLupaPulang > 2 ? 'text-rose-500' : 'text-gray-800' }}">{{ $totalLupaPulang }}</span>
                </div>
                <p class="text-sm text-gray-500 font-medium">Lupa Pulang</p>
                @if ($totalLupaPulang > 2)
                    <span
                        class="text-xs px-2 py-0.5 bg-rose-50 text-rose-600 rounded-full mt-2 inline-flex items-center gap-1 font-medium ring-1 ring-rose-200">⚠️
                        Potong Gaji</span>
                @elseif($totalLupaPulang > 0)
                    <span
                        class="text-xs px-2 py-0.5 bg-amber-50 text-amber-600 rounded-full mt-2 inline-flex items-center gap-1 font-medium ring-1 ring-amber-200">⚡
                        Perhatian</span>
                @endif
            </div>
        </div>

        {{-- Riwayat Absensi Terakhir --}}
        <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100 animate-slide-up-delay-4">
            <div class="flex items-center justify-between mb-6">
                <div class="flex items-center gap-3">
                    <div class="p-3 bg-gradient-to-br from-primary to-primaryDark rounded-xl shadow-lg">
                        <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                            </path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-800">Riwayat Absensi</h3>
                        <p class="text-xs text-gray-500">Terakhir bulan ini</p>
                    </div>
                </div>
                <a href="{{ route('absen.riwayat') }}"
                    class="inline-flex items-center gap-1 text-primary hover:text-primaryDark text-sm font-medium transition-colors group">
                    Lihat Semua
                    <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                        </path>
                    </svg>
                </a>
            </div>

            @if (count($riwayatAbsensi) > 0)
                <div class="space-y-3">
                    @foreach ($riwayatAbsensi as $absen)
                        <div
                            class="flex items-center justify-between p-4 bg-gradient-to-r from-gray-50 to-white rounded-xl border border-gray-100 hover:border-primary/30 hover:shadow-sm transition-all group">
                            <div class="flex items-center gap-4">
                                <div
                                    class="w-12 h-12 rounded-xl flex items-center justify-center shadow-sm
                                                @if ($absen->izin) bg-gradient-to-br from-blue-100 to-blue-200
                                                @elseif($absen->libur) bg-gradient-to-br from-indigo-100 to-purple-200
                                                @else bg-gradient-to-br from-emerald-100 to-green-200 @endif">
                                    @if ($absen->izin)
                                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                            </path>
                                        </svg>
                                    @elseif($absen->libur)
                                        <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z">
                                            </path>
                                        </svg>
                                    @else
                                        <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 13l4 4L19 7"></path>
                                        </svg>
                                    @endif
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-800">
                                        {{ \Carbon\Carbon::parse($absen->tanggal)->locale('id')->isoFormat('dddd, D MMM Y') }}
                                    </p>
                                    <p class="text-sm text-gray-500">
                                        @if ($absen->izin)
                                            <span class="text-blue-600">Izin:
                                                {{ $absen->izin_keterangan ?: 'Tanpa keterangan' }}</span>
                                        @elseif($absen->libur)
                                            <span class="text-indigo-600">Libur</span>
                                        @else
                                            <span
                                                class="text-emerald-600">{{ $absen->jam_masuk ? $absen->jam_masuk->format('H:i') : '-' }}</span>
                                            @if ($absen->jam_pulang)
                                                <span class="text-gray-400 mx-1">→</span>
                                                <span
                                                    class="text-blue-600">{{ $absen->jam_pulang->format('H:i') }}</span>
                                            @endif
                                        @endif
                                    </p>
                                </div>
                            </div>
                            <div>
                                @if ($absen->izin)
                                    <span
                                        class="text-xs px-3 py-1 bg-blue-50 text-blue-600 rounded-lg font-medium ring-1 ring-blue-200">📝
                                        Izin</span>
                                @elseif($absen->libur)
                                    <span
                                        class="text-xs px-3 py-1 bg-indigo-50 text-indigo-600 rounded-lg font-medium ring-1 ring-indigo-200">🌴
                                        Libur</span>
                                @elseif($absen->telat)
                                    <span
                                        class="text-xs px-3 py-1 bg-rose-50 text-rose-600 rounded-lg font-medium ring-1 ring-rose-200">⏰
                                        Telat</span>
                                @else
                                    <span
                                        class="text-xs px-3 py-1 bg-emerald-50 text-emerald-600 rounded-lg font-medium ring-1 ring-emerald-200">✓
                                        Tepat</span>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-10">
                    <div
                        class="w-20 h-20 bg-gradient-to-br from-gray-100 to-gray-200 rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-inner">
                        <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                            </path>
                        </svg>
                    </div>
                    <h4 class="font-semibold text-gray-800 mb-1">Belum Ada Riwayat</h4>
                    <p class="text-sm text-gray-500">Riwayat absensi akan muncul di sini</p>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
