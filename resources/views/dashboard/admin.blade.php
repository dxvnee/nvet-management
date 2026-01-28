<x-app-layout>
    <x-slot name="header">Dashboard Admin</x-slot>
    <x-slot name="subtle">Selamat datang kembali, {{ $user->name }}!</x-slot>

    <div class="space-y-6">
        {{-- Welcome Section Admin --}}
        <div
            class="relative overflow-hidden bg-gradient-to-br from-primary via-primaryDark to-primary rounded-3xl shadow-2xl p-8 text-white animate-slide-up">
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
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                            </path>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-2xl md:text-3xl font-bold mb-1">NVet Clinic & Lab</h2>
                        <p class="text-white/80 text-sm md:text-base flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                </path>
                            </svg>
                            {{ now()->locale('id')->isoFormat('dddd, D MMMM Y') }}
                        </p>
                    </div>
                </div>
                <div class="flex items-center gap-6">
                    <div class="hidden md:block text-right bg-white/10 backdrop-blur-sm rounded-2xl px-6 py-3">
                        <p class="text-white/70 text-xs uppercase tracking-wider mb-1">Waktu Sekarang</p>
                        <p class="text-3xl font-bold font-mono" x-data="{ time: '' }" x-init="setInterval(() => time = new Date().toLocaleTimeString('id-ID'), 1000)"
                            x-text="time"></p>
                    </div>
                    <div
                        class="hidden lg:flex flex-col items-center bg-white/10 backdrop-blur-sm rounded-2xl px-4 py-3">
                        <span class="text-xs text-white/70 uppercase tracking-wider">Status</span>
                        <span class="text-sm font-semibold flex items-center gap-1">
                            <span class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></span>
                            Online
                        </span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Stats Cards Admin --}}
        <div class="grid grid-cols-2 lg:grid-cols-5 gap-4 lg:gap-6">
            {{-- Total Pegawai --}}
            <div
                class="group bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-500 p-5 lg:p-6 border border-gray-100 hover:border-primary/20 animate-slide-up-delay-1">
                <div class="flex items-center justify-between mb-4">
                    <div
                        class="p-3 bg-gradient-to-br from-primary to-primaryDark rounded-xl shadow-lg group-hover:scale-110 transition-transform duration-300">
                        <svg class="h-5 w-5 lg:h-6 lg:w-6 text-white" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z">
                            </path>
                        </svg>
                    </div>
                    <div class="text-right">
                        <span
                            class="text-3xl lg:text-4xl font-bold bg-gradient-to-r from-primary to-primaryDark bg-clip-text text-transparent">{{ $totalPegawai }}</span>
                    </div>
                </div>
                <h3 class="text-xs lg:text-sm font-semibold text-gray-500 uppercase tracking-wider">Total Pegawai</h3>
                <div class="mt-3 flex flex-wrap gap-1">
                    @foreach ($pegawaiByJabatan as $jabatan => $total)
                        <span
                            class="text-xs px-2 py-0.5 rounded-full font-medium
                                    {{ $jabatan === 'Dokter' ? 'bg-purple-50 text-purple-600 ring-1 ring-purple-200' : '' }}
                                    {{ $jabatan === 'Paramedis' ? 'bg-blue-50 text-blue-600 ring-1 ring-blue-200' : '' }}
                                    {{ $jabatan === 'Tech' ? 'bg-green-50 text-green-600 ring-1 ring-green-200' : '' }}
                                    {{ $jabatan === 'FO' ? 'bg-orange-50 text-orange-600 ring-1 ring-orange-200' : '' }}">
                            {{ $jabatan }}: {{ $total }}
                        </span>
                    @endforeach
                </div>
            </div>

            {{-- Absensi Hari Ini --}}
            <div
                class="group bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-500 p-5 lg:p-6 border border-gray-100 hover:border-green-200 animate-slide-up-delay-2">
                <div class="flex items-center justify-between mb-4">
                    <div
                        class="p-3 bg-gradient-to-br from-emerald-500 to-green-600 rounded-xl shadow-lg group-hover:scale-110 transition-transform duration-300">
                        <svg class="h-5 w-5 lg:h-6 lg:w-6 text-white" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="text-right">
                        <span
                            class="text-3xl lg:text-4xl font-bold bg-gradient-to-r from-emerald-500 to-green-600 bg-clip-text text-transparent">{{ $absensiHariIni }}</span>
                    </div>
                </div>
                <h3 class="text-xs lg:text-sm font-semibold text-gray-500 uppercase tracking-wider">Hadir Hari Ini</h3>
                <div class="mt-3 flex flex-wrap gap-2">
                    <span
                        class="text-xs px-2 py-1 bg-emerald-50 text-emerald-600 rounded-full font-medium ring-1 ring-emerald-200 flex items-center gap-1">
                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                clip-rule="evenodd" />
                        </svg>
                        {{ $tepatWaktuHariIni }}
                    </span>
                    <span
                        class="text-xs px-2 py-1 bg-red-50 text-red-600 rounded-full font-medium ring-1 ring-red-200 flex items-center gap-1">
                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                clip-rule="evenodd" />
                        </svg>
                        {{ $telatHariIni }}
                    </span>
                </div>
            </div>

            {{-- Total Gaji Bulan Ini --}}
            <div
                class="group bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-500 p-5 lg:p-6 border border-gray-100 hover:border-blue-200 animate-slide-up-delay-3">
                <div class="flex items-center justify-between mb-4">
                    <div
                        class="p-3 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl shadow-lg group-hover:scale-110 transition-transform duration-300">
                        <svg class="h-5 w-5 lg:h-6 lg:w-6 text-white" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                            </path>
                        </svg>
                    </div>
                </div>
                <p class="text-lg lg:text-xl font-bold text-gray-800">Rp
                    {{ number_format($totalGajiBulanIni, 0, ',', '.') }}</p>
                <h3 class="text-xs lg:text-sm font-semibold text-gray-500 uppercase tracking-wider mt-1">Gaji Bulan Ini
                </h3>
                @if ($penggajianDraft > 0)
                    <span
                        class="text-xs px-2 py-1 bg-amber-50 text-amber-600 rounded-full mt-2 inline-flex items-center gap-1 font-medium ring-1 ring-amber-200">
                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                clip-rule="evenodd" />
                        </svg>
                        {{ $penggajianDraft }} Draft
                    </span>
                @endif
            </div>

            {{-- Belum Absen --}}
            <div
                class="group bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-500 p-5 lg:p-6 border border-gray-100 hover:border-orange-200 animate-slide-up-delay-4">
                <div class="flex items-center justify-between mb-4">
                    <div
                        class="p-3 bg-gradient-to-br from-amber-500 to-orange-500 rounded-xl shadow-lg group-hover:scale-110 transition-transform duration-300 {{ count($belumAbsen) > 0 ? 'animate-pulse' : '' }}">
                        <svg class="h-5 w-5 lg:h-6 lg:w-6 text-white" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="text-right">
                        <span
                            class="text-3xl lg:text-4xl font-bold {{ count($belumAbsen) > 0 ? 'text-orange-500' : 'text-green-500' }}">{{ count($belumAbsen) }}</span>
                    </div>
                </div>
                <h3 class="text-xs lg:text-sm font-semibold text-gray-500 uppercase tracking-wider">Belum Absen</h3>
                @if (count($belumAbsen) > 0)
                    <div class="mt-3 flex -space-x-2">
                        @foreach ($belumAbsen->take(4) as $pegawai)
                            <img src="{{ $pegawai->avatar ? asset('storage/' . $pegawai->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($pegawai->name) . '&size=32&background=f97316&color=ffffff' }}"
                                class="w-8 h-8 rounded-full border-2 border-white shadow-sm hover:scale-110 transition-transform cursor-pointer"
                                title="{{ $pegawai->name }}">
                        @endforeach
                        @if (count($belumAbsen) > 4)
                            <span
                                class="w-8 h-8 rounded-full bg-gradient-to-br from-orange-100 to-orange-200 border-2 border-white flex items-center justify-center text-xs font-bold text-orange-600 shadow-sm">+{{ count($belumAbsen) - 4 }}</span>
                        @endif
                    </div>
                @else
                    <p class="text-xs text-green-500 mt-2 font-medium">✓ Semua sudah absen</p>
                @endif
            </div>

            {{-- Lupa Pulang Bulan Ini --}}
            <div
                class="group bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-500 p-5 lg:p-6 border border-gray-100 hover:border-rose-200 animate-slide-up-delay-4">
                <div class="flex items-center justify-between mb-4">
                    <div
                        class="p-3 bg-gradient-to-br from-rose-500 to-pink-600 rounded-xl shadow-lg group-hover:scale-110 transition-transform duration-300">
                        <svg class="h-5 w-5 lg:h-6 lg:w-6 text-white" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                            </path>
                        </svg>
                    </div>
                    <div class="text-right">
                        <span
                            class="text-3xl lg:text-4xl font-bold {{ $totalLupaPulangBulanIni > 3 ? 'text-rose-500' : 'text-gray-800' }}">{{ $totalLupaPulangBulanIni }}</span>
                    </div>
                </div>
                <h3 class="text-xs lg:text-sm font-semibold text-gray-500 uppercase tracking-wider">Lupa Pulang</h3>
                <div class="mt-3">
                    @if ($totalLupaPulangBulanIni > 3)
                        <span
                            class="text-xs px-2 py-1 bg-rose-50 text-rose-600 rounded-full font-medium ring-1 ring-rose-200">⚠️
                            Potong Gaji</span>
                    @elseif($totalLupaPulangBulanIni > 0)
                        <span
                            class="text-xs px-2 py-1 bg-amber-50 text-amber-600 rounded-full font-medium ring-1 ring-amber-200">⚡
                            Perhatian</span>
                    @else
                        <span
                            class="text-xs px-2 py-1 bg-green-50 text-green-600 rounded-full font-medium ring-1 ring-green-200">✓
                            Baik</span>
                    @endif
                </div>
            </div>
        </div>

        {{-- Grafik & Detail Section --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            {{-- Grafik Absensi 7 Hari --}}
            <div
                class="lg:col-span-2 bg-white rounded-2xl shadow-lg p-6 border border-gray-100 animate-slide-up-delay-5">
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center gap-3">
                        <div class="p-2.5 bg-gradient-to-br from-primary to-primaryDark rounded-xl shadow-md">
                            <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                                </path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-gray-800">Statistik Absensi</h3>
                            <p class="text-xs text-gray-500">7 hari terakhir</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-4">
                        <div class="flex items-center gap-2">
                            <span class="w-3 h-3 bg-gradient-to-r from-primary to-primaryDark rounded-full"></span>
                            <span class="text-xs text-gray-500">Tepat</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="w-3 h-3 bg-gradient-to-r from-rose-500 to-red-500 rounded-full"></span>
                            <span class="text-xs text-gray-500">Telat</span>
                        </div>
                    </div>
                </div>
                <div class="grid grid-cols-7 gap-2 lg:gap-3">
                    @foreach ($grafikAbsensi as $data)
                        <div class="text-center group">
                            <div
                                class="h-28 lg:h-36 bg-gradient-to-t from-gray-50 to-gray-100/50 rounded-xl relative overflow-hidden flex flex-col justify-end border border-gray-100 group-hover:border-primary/30 transition-colors">
                                @php
                                    $maxHadir = max(array_column($grafikAbsensi, 'hadir')) ?: 1;
                                    $heightHadir = ($data['hadir'] / $maxHadir) * 100;
                                @endphp
                                <div class="bg-gradient-to-t from-primary to-primary/60 transition-all duration-500 relative rounded-t-lg group-hover:from-primaryDark"
                                    style="height: {{ $heightHadir }}%">
                                    @if ($data['telat'] > 0)
                                        <div class="bg-gradient-to-t from-rose-500 to-rose-400 w-full absolute top-0 rounded-t-lg"
                                            style="height: {{ ($data['telat'] / max($data['hadir'], 1)) * 100 }}%">
                                        </div>
                                    @endif
                                    <div
                                        class="absolute -top-6 left-1/2 -translate-x-1/2 bg-gray-800 text-white text-xs px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap">
                                        {{ $data['hadir'] }} hadir
                                    </div>
                                </div>
                            </div>
                            <p class="text-xs font-semibold text-gray-700 mt-2">{{ $data['tanggal'] }}</p>
                            <p class="text-[10px] text-gray-400">{{ $data['hadir'] }}</p>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Top Telat --}}
            <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100 animate-slide-up-delay-5">
                <div class="flex items-center gap-3 mb-6">
                    <div class="p-2.5 bg-gradient-to-br from-rose-500 to-red-600 rounded-xl shadow-md">
                        <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-800">Top Keterlambatan</h3>
                        <p class="text-xs text-gray-500">Bulan ini</p>
                    </div>
                </div>
                @if (count($topTelat) > 0)
                    <div class="space-y-3">
                        @foreach ($topTelat as $index => $telat)
                            <div
                                class="flex items-center gap-3 p-3 bg-gradient-to-r from-gray-50 to-white rounded-xl border border-gray-100 hover:border-rose-200 hover:shadow-sm transition-all group">
                                <span
                                    class="w-7 h-7 flex items-center justify-center rounded-lg text-xs font-bold shadow-sm
                                                {{ $index === 0 ? 'bg-gradient-to-br from-rose-500 to-red-600 text-white' : '' }}
                                                {{ $index === 1 ? 'bg-gradient-to-br from-orange-400 to-orange-500 text-white' : '' }}
                                                {{ $index === 2 ? 'bg-gradient-to-br from-amber-400 to-yellow-500 text-white' : '' }}
                                                {{ $index > 2 ? 'bg-gray-100 text-gray-600' : '' }}">
                                    {{ $index + 1 }}
                                </span>
                                <img src="{{ $telat->user->avatar ? asset('storage/' . $telat->user->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($telat->user->name) . '&size=32&background=fee2e2&color=ef4444' }}"
                                    class="w-9 h-9 rounded-xl border-2 border-white shadow-sm group-hover:scale-105 transition-transform">
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-semibold text-gray-800 truncate">{{ $telat->user->name }}
                                    </p>
                                    <p class="text-xs text-gray-500">{{ $telat->total_telat }}x terlambat</p>
                                </div>
                                <span
                                    class="text-xs px-2.5 py-1 bg-rose-50 text-rose-600 rounded-lg font-semibold ring-1 ring-rose-200">
                                    {{ $telat->total_menit }}m
                                </span>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8">
                        <div
                            class="w-20 h-20 bg-gradient-to-br from-emerald-100 to-green-100 rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-inner">
                            <svg class="w-10 h-10 text-emerald-500" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <h4 class="font-semibold text-gray-800 mb-1">Luar Biasa! 🎉</h4>
                        <p class="text-sm text-gray-500">Tidak ada keterlambatan bulan ini</p>
                    </div>
                @endif
            </div>
        </div>

        {{-- Aktivitas Terbaru --}}
        <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100 animate-slide-up-delay-5">
            <div class="flex items-center justify-between mb-6">
                <div class="flex items-center gap-3">
                    <div class="p-2.5 bg-gradient-to-br from-primary to-primaryDark rounded-xl shadow-md">
                        <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-800">Aktivitas Terbaru</h3>
                        <p class="text-xs text-gray-500">Absensi hari ini</p>
                    </div>
                </div>
                <a href="{{ route('absen.detailHari', $today) }}"
                    class="inline-flex items-center gap-1 text-primary hover:text-primaryDark text-sm font-medium transition-colors group">
                    Lihat Semua
                    <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                        </path>
                    </svg>
                </a>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                @forelse($aktivitasTerbaru as $aktivitas)
                    <div
                        class="flex items-center gap-4 p-4 bg-gradient-to-r from-gray-50 to-white rounded-xl border border-gray-100 hover:border-primary/30 hover:shadow-md transition-all group">
                        <div class="relative">
                            <img src="{{ $aktivitas->user->avatar ? asset('storage/' . $aktivitas->user->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($aktivitas->user->name) . '&size=40' }}"
                                class="w-11 h-11 rounded-xl border-2 shadow-sm group-hover:scale-105 transition-transform
                                        @if ($aktivitas->izin) border-blue-300
                                        @elseif(!$aktivitas->telat) border-emerald-300
                                        @else border-rose-300 @endif">
                            <span
                                class="absolute -bottom-1 -right-1 w-5 h-5 rounded-full flex items-center justify-center text-[10px] shadow-sm
                                @if ($aktivitas->izin) bg-blue-100 text-blue-600
                                @elseif(!$aktivitas->telat) bg-emerald-100 text-emerald-600
                                @else bg-rose-100 text-rose-600 @endif">
                                @if ($aktivitas->izin)
                                    📝
                                @elseif(!$aktivitas->telat)
                                    ✓
                                @else
                                    ⚠
                                @endif
                            </span>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-semibold text-gray-800 truncate">{{ $aktivitas->user->name }}</p>
                            <p class="text-xs text-gray-500">
                                @if ($aktivitas->izin)
                                    <span class="text-blue-600">Izin hari ini</span>
                                @elseif(!$aktivitas->telat)
                                    <span class="text-emerald-600">Tepat waktu</span>
                                @else
                                    <span class="text-rose-600">Terlambat {{ $aktivitas->menit_telat }} menit</span>
                                @endif
                            </p>
                        </div>
                        <div class="text-right">
                            <p class="text-sm font-bold text-gray-800">
                                {{ $aktivitas->jam_masuk ? $aktivitas->jam_masuk->format('H:i') : '-' }}</p>
                            <p class="text-[10px] text-gray-400 uppercase tracking-wider">
                                {{ \Carbon\Carbon::parse($aktivitas->tanggal)->format('d M') }}
                            </p>
                        </div>
                    </div>
                @empty
                    <div class="col-span-2 text-center py-8">
                        <div class="w-16 h-16 bg-gray-100 rounded-2xl flex items-center justify-center mx-auto mb-3">
                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <p class="text-gray-500">Belum ada aktivitas hari ini</p>
                    </div>
                @endforelse
            </div>
        </div>

        {{-- Quick Actions Admin --}}
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 py-6">
            <a href="{{ route('users.index') }}"
                class="group relative overflow-hidden bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 p-6 border border-gray-100 hover:border-primary/30">
                <div
                    class="absolute top-0 right-0 w-20 h-20 bg-gradient-to-br from-primary/10 to-transparent rounded-bl-full">
                </div>
                <div class="relative">
                    <div
                        class="p-3 bg-gradient-to-br from-primary to-primaryDark rounded-xl w-fit mb-4 shadow-lg group-hover:scale-110 group-hover:rotate-3 transition-all duration-300">
                        <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z">
                            </path>
                        </svg>
                    </div>
                    <h4 class="font-bold text-gray-800 group-hover:text-primary transition-colors">Kelola Pegawai</h4>
                    <p class="text-sm text-gray-500 mt-1">Tambah, edit, hapus</p>
                </div>
            </a>
            <a href="{{ route('penggajian.index') }}"
                class="group relative overflow-hidden bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 p-6 border border-gray-100 hover:border-emerald-300">
                <div
                    class="absolute top-0 right-0 w-20 h-20 bg-gradient-to-br from-emerald-500/10 to-transparent rounded-bl-full">
                </div>
                <div class="relative">
                    <div
                        class="p-3 bg-gradient-to-br from-emerald-500 to-green-600 rounded-xl w-fit mb-4 shadow-lg group-hover:scale-110 group-hover:rotate-3 transition-all duration-300">
                        <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z">
                            </path>
                        </svg>
                    </div>
                    <h4 class="font-bold text-gray-800 group-hover:text-emerald-600 transition-colors">Penggajian</h4>
                    <p class="text-sm text-gray-500 mt-1">Kelola gaji pegawai</p>
                </div>
            </a>
            <a href="{{ route('absen.riwayat') }}"
                class="group relative overflow-hidden bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 p-6 border border-gray-100 hover:border-blue-300">
                <div
                    class="absolute top-0 right-0 w-20 h-20 bg-gradient-to-br from-blue-500/10 to-transparent rounded-bl-full">
                </div>
                <div class="relative">
                    <div
                        class="p-3 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl w-fit mb-4 shadow-lg group-hover:scale-110 group-hover:rotate-3 transition-all duration-300">
                        <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                            </path>
                        </svg>
                    </div>
                    <h4 class="font-bold text-gray-800 group-hover:text-blue-600 transition-colors">Riwayat Absensi
                    </h4>
                    <p class="text-sm text-gray-500 mt-1">Lihat semua absensi</p>
                </div>
            </a>
            <a href="{{ route('users.create') }}"
                class="group relative overflow-hidden bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 p-6 border border-gray-100 hover:border-purple-300">
                <div
                    class="absolute top-0 right-0 w-20 h-20 bg-gradient-to-br from-purple-500/10 to-transparent rounded-bl-full">
                </div>
                <div class="relative">
                    <div
                        class="p-3 bg-gradient-to-br from-purple-500 to-violet-600 rounded-xl w-fit mb-4 shadow-lg group-hover:scale-110 group-hover:rotate-3 transition-all duration-300">
                        <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z">
                            </path>
                        </svg>
                    </div>
                    <h4 class="font-bold text-gray-800 group-hover:text-purple-600 transition-colors">Tambah Pegawai
                    </h4>
                    <p class="text-sm text-gray-500 mt-1">Daftarkan pegawai baru</p>
                </div>
            </a>
        </div>
    </div>
</x-app-layout>
