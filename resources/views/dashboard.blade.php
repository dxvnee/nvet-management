<x-app-layout>
    <x-slot name="header">Dashboard</x-slot>
    <x-slot name="subtle">Selamat datang kembali, {{ $user->name }}!</x-slot>

    <div class="space-y-8">
        {{-- Dashboard untuk Admin/Owner --}}
        @if($user->role === 'admin' && $adminData)
            {{-- Welcome Section Admin --}}
            <div class="bg-gradient-to-r from-primary to-primaryDark rounded-2xl shadow-xl p-8 text-white animate-slide-up">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-3xl font-bold mb-2">🏥 NVet Clinic & Lab</h2>
                        <p class="text-white/80 text-lg">Panel Administrator - {{ now()->format('l, d F Y') }}</p>
                    </div>
                    <div class="hidden md:flex items-center gap-4">
                        <div class="text-right">
                            <p class="text-white/70 text-sm">Jam Sekarang</p>
                            <p class="text-2xl font-bold" x-data="{ time: '' }"
                                x-init="setInterval(() => time = new Date().toLocaleTimeString('id-ID'), 1000)"
                                x-text="time"></p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Stats Cards Admin --}}
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-6">
                {{-- Total Pegawai --}}
                <div
                    class="bg-white rounded-2xl shadow-xl p-6 hover:shadow-2xl transition-all duration-300 animate-slide-up-delay-1 hover:transform hover:scale-105">
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-3 bg-gradient-to-br from-primary to-primaryDark rounded-xl shadow-lg">
                            <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z">
                                </path>
                            </svg>
                        </div>
                        <span class="text-3xl font-bold text-gray-800">{{ $adminData['totalPegawai'] }}</span>
                    </div>
                    <h3 class="text-sm font-semibold text-gray-600 uppercase tracking-wide">Total Pegawai</h3>
                    <div class="mt-3 flex flex-wrap gap-1">
                        @foreach($adminData['pegawaiByJabatan'] as $jabatan => $total)
                            <span class="text-xs px-2 py-1 rounded-full
                                        {{ $jabatan === 'Dokter' ? 'bg-purple-100 text-purple-700' : '' }}
                                        {{ $jabatan === 'Paramedis' ? 'bg-blue-100 text-blue-700' : '' }}
                                        {{ $jabatan === 'Tech' ? 'bg-green-100 text-green-700' : '' }}
                                        {{ $jabatan === 'FO' ? 'bg-orange-100 text-orange-700' : '' }}">
                                {{ $jabatan }}: {{ $total }}
                            </span>
                        @endforeach
                    </div>
                </div>

                {{-- Absensi Hari Ini --}}
                <div
                    class="bg-white rounded-2xl shadow-xl p-6 hover:shadow-2xl transition-all duration-300 animate-slide-up-delay-2 hover:transform hover:scale-105">
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-3 bg-gradient-to-br from-green-500 to-green-600 rounded-xl shadow-lg">
                            <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <span class="text-3xl font-bold text-gray-800">{{ $adminData['absensiHariIni'] }}</span>
                    </div>
                    <h3 class="text-sm font-semibold text-gray-600 uppercase tracking-wide">Hadir Hari Ini</h3>
                    <div class="mt-3 flex gap-2">
                        <span class="text-xs px-2 py-1 bg-green-100 text-green-700 rounded-full">Tepat:
                            {{ $adminData['tepatWaktuHariIni'] }}</span>
                        <span class="text-xs px-2 py-1 bg-red-100 text-red-700 rounded-full">Telat:
                            {{ $adminData['telatHariIni'] }}</span>
                    </div>
                </div>

                {{-- Total Gaji Bulan Ini --}}
                <div
                    class="bg-white rounded-2xl shadow-xl p-6 hover:shadow-2xl transition-all duration-300 animate-slide-up-delay-3 hover:transform hover:scale-105">
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-3 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl shadow-lg">
                            <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                </path>
                            </svg>
                        </div>
                    </div>
                    <p class="text-xl font-bold text-gray-800">Rp
                        {{ number_format($adminData['totalGajiBulanIni'], 0, ',', '.') }}</p>
                    <h3 class="text-sm font-semibold text-gray-600 uppercase tracking-wide mt-1">Gaji Bulan Ini</h3>
                    @if($adminData['penggajianDraft'] > 0)
                        <span
                            class="text-xs px-2 py-1 bg-yellow-100 text-yellow-700 rounded-full mt-2 inline-block">{{ $adminData['penggajianDraft'] }}
                            Draft</span>
                    @endif
                </div>

                {{-- Belum Absen --}}
                <div
                    class="bg-white rounded-2xl shadow-xl p-6 hover:shadow-2xl transition-all duration-300 animate-slide-up-delay-4 hover:transform hover:scale-105">
                    <div class="flex items-center justify-between mb-4">
                        <div
                            class="p-3 bg-gradient-to-br from-yellow-500 to-orange-500 rounded-xl shadow-lg {{ count($adminData['belumAbsen']) > 0 ? 'animate-pulse' : '' }}">
                            <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <span
                            class="text-3xl font-bold {{ count($adminData['belumAbsen']) > 0 ? 'text-orange-600' : 'text-green-600' }}">{{ count($adminData['belumAbsen']) }}</span>
                    </div>
                    <h3 class="text-sm font-semibold text-gray-600 uppercase tracking-wide">Belum Absen</h3>
                    @if(count($adminData['belumAbsen']) > 0)
                        <div class="mt-2 flex -space-x-2">
                            @foreach($adminData['belumAbsen']->take(4) as $pegawai)
                                <img src="{{ $pegawai->avatar ? asset('storage/' . $pegawai->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($pegawai->name) . '&size=32' }}"
                                    class="w-8 h-8 rounded-full border-2 border-white" title="{{ $pegawai->name }}">
                            @endforeach
                            @if(count($adminData['belumAbsen']) > 4)
                                <span
                                    class="w-8 h-8 rounded-full bg-gray-200 border-2 border-white flex items-center justify-center text-xs font-bold text-gray-600">+{{ count($adminData['belumAbsen']) - 4 }}</span>
                            @endif
                        </div>
                    @endif
                </div>
            </div>

            {{-- Grafik & Detail Section --}}
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                {{-- Grafik Absensi 7 Hari --}}
                <div class="lg:col-span-2 bg-white rounded-2xl shadow-xl p-6 animate-slide-up-delay-5">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="p-2 bg-gradient-to-br from-primary to-primaryDark rounded-lg">
                            <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                                </path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-gray-800">Statistik Absensi 7 Hari Terakhir</h3>
                    </div>
                    <div class="grid grid-cols-7 gap-2">
                        @foreach($adminData['grafikAbsensi'] as $data)
                            <div class="text-center">
                                <div class="h-32 bg-gray-100 rounded-lg relative overflow-hidden flex flex-col justify-end">
                                    @php
                                        $maxHadir = max(array_column($adminData['grafikAbsensi'], 'hadir')) ?: 1;
                                        $heightHadir = ($data['hadir'] / $maxHadir) * 100;
                                    @endphp
                                    <div class="bg-gradient-to-t from-primary to-primary/70 transition-all duration-500 relative"
                                        style="height: {{ $heightHadir }}%">
                                        @if($data['telat'] > 0)
                                            <div class="bg-red-500 w-full absolute top-0"
                                                style="height: {{ ($data['telat'] / max($data['hadir'], 1)) * 100 }}%"></div>
                                        @endif
                                    </div>
                                </div>
                                <p class="text-xs font-medium text-gray-600 mt-2">{{ $data['tanggal'] }}</p>
                                <p class="text-xs text-gray-500">{{ $data['hadir'] }} hadir</p>
                            </div>
                        @endforeach
                    </div>
                    <div class="flex justify-center gap-6 mt-4">
                        <div class="flex items-center gap-2">
                            <div class="w-3 h-3 bg-primary rounded-full"></div>
                            <span class="text-sm text-gray-600">Tepat Waktu</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <div class="w-3 h-3 bg-red-500 rounded-full"></div>
                            <span class="text-sm text-gray-600">Terlambat</span>
                        </div>
                    </div>
                </div>

                {{-- Top Telat --}}
                <div class="bg-white rounded-2xl shadow-xl p-6 animate-slide-up-delay-5">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="p-2 bg-gradient-to-br from-red-500 to-red-600 rounded-lg">
                            <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-gray-800">Top Keterlambatan</h3>
                    </div>
                    @if(count($adminData['topTelat']) > 0)
                        <div class="space-y-3">
                            @foreach($adminData['topTelat'] as $index => $telat)
                                <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-xl">
                                    <span class="w-6 h-6 flex items-center justify-center rounded-full text-xs font-bold
                                                    {{ $index === 0 ? 'bg-red-500 text-white' : '' }}
                                                    {{ $index === 1 ? 'bg-orange-500 text-white' : '' }}
                                                    {{ $index === 2 ? 'bg-yellow-500 text-white' : '' }}
                                                    {{ $index > 2 ? 'bg-gray-300 text-gray-700' : '' }}">
                                        {{ $index + 1 }}
                                    </span>
                                    <img src="{{ $telat->user->avatar ? asset('storage/' . $telat->user->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($telat->user->name) . '&size=32' }}"
                                        class="w-8 h-8 rounded-full">
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-medium text-gray-800 truncate">{{ $telat->user->name }}</p>
                                        <p class="text-xs text-gray-500">{{ $telat->total_telat }}x telat</p>
                                    </div>
                                    <span class="text-xs px-2 py-1 bg-red-100 text-red-700 rounded-full">{{ $telat->total_menit }}
                                        menit</span>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8">
                            <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-3">
                                <svg class="w-8 h-8 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                                    </path>
                                </svg>
                            </div>
                            <p class="text-gray-500">Tidak ada keterlambatan bulan ini! 🎉</p>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Aktivitas Terbaru --}}
            <div class="bg-white rounded-2xl shadow-xl p-6 animate-slide-up-delay-5">
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center gap-3">
                        <div class="p-2 bg-gradient-to-br from-primary to-primaryDark rounded-lg">
                            <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-gray-800">Aktivitas Absensi Terbaru</h3>
                    </div>
                    <a href="{{ route('absen.detailHari', $today) }}"
                        class="text-primary hover:text-primaryDark text-sm font-medium">Lihat Semua →</a>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach($adminData['aktivitasTerbaru'] as $aktivitas)
                        <div class="flex items-center gap-4 p-4 bg-gray-50 rounded-xl hover:bg-gray-100 transition-colors">
                            <img src="{{ $aktivitas->user->avatar ? asset('storage/' . $aktivitas->user->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($aktivitas->user->name) . '&size=40' }}"
                                class="w-10 h-10 rounded-full border-2
                                        @if($aktivitas->izin) border-blue-400
                                        @elseif(!$aktivitas->telat) border-green-400
                                        @else border-red-400
                                        @endif">
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-800 truncate">{{ $aktivitas->user->name }}</p>
                                <p class="text-xs text-gray-500">
                                    @if($aktivitas->izin)
                                        Izin hari ini
                                    @elseif(!$aktivitas->telat)
                                        Tepat waktu
                                    @else
                                        Terlambat {{ $aktivitas->menit_telat }} menit
                                    @endif
                                    • {{ $aktivitas->jam_masuk ? $aktivitas->jam_masuk->format('H:i') : '-' }}
                                </p>
                            </div>
                            <div class="text-right">
                                <span class="text-xs px-2 py-1 rounded-full
                                            @if($aktivitas->izin) bg-blue-100 text-blue-700
                                            @elseif(!$aktivitas->telat) bg-green-100 text-green-700
                                            @else bg-red-100 text-red-700
                                            @endif">
                                    @if($aktivitas->izin)
                                        📝
                                    @elseif(!$aktivitas->telat)
                                        ✓
                                    @else
                                        ⚠
                                    @endif
                                </span>
                                <p class="text-xs text-gray-400 mt-1">
                                    {{ \Carbon\Carbon::parse($aktivitas->tanggal)->format('d M') }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Quick Actions Admin --}}
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <a href="{{ route('users.index') }}"
                    class="bg-white rounded-2xl shadow-lg p-6 hover:shadow-xl transition-all duration-300 hover:transform hover:scale-105 group">
                    <div
                        class="p-3 bg-gradient-to-br from-primary to-primaryDark rounded-xl w-fit mb-4 group-hover:scale-110 transition-transform">
                        <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z">
                            </path>
                        </svg>
                    </div>
                    <h4 class="font-bold text-gray-800">Kelola Pegawai</h4>
                    <p class="text-sm text-gray-500">Tambah, edit, hapus pegawai</p>
                </a>
                <a href="{{ route('penggajian.index') }}"
                    class="bg-white rounded-2xl shadow-lg p-6 hover:shadow-xl transition-all duration-300 hover:transform hover:scale-105 group">
                    <div
                        class="p-3 bg-gradient-to-br from-green-500 to-green-600 rounded-xl w-fit mb-4 group-hover:scale-110 transition-transform">
                        <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z">
                            </path>
                        </svg>
                    </div>
                    <h4 class="font-bold text-gray-800">Penggajian</h4>
                    <p class="text-sm text-gray-500">Kelola gaji pegawai</p>
                </a>
                <a href="{{ route('absen.riwayat') }}"
                    class="bg-white rounded-2xl shadow-lg p-6 hover:shadow-xl transition-all duration-300 hover:transform hover:scale-105 group">
                    <div
                        class="p-3 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl w-fit mb-4 group-hover:scale-110 transition-transform">
                        <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                            </path>
                        </svg>
                    </div>
                    <h4 class="font-bold text-gray-800">Riwayat Absensi</h4>
                    <p class="text-sm text-gray-500">Lihat semua absensi</p>
                </a>
                <a href="{{ route('users.create') }}"
                    class="bg-white rounded-2xl shadow-lg p-6 hover:shadow-xl transition-all duration-300 hover:transform hover:scale-105 group">
                    <div
                        class="p-3 bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl w-fit mb-4 group-hover:scale-110 transition-transform">
                        <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z">
                            </path>
                        </svg>
                    </div>
                    <h4 class="font-bold text-gray-800">Tambah Pegawai</h4>
                    <p class="text-sm text-gray-500">Daftarkan pegawai baru</p>
                </a>
            </div>

        @else
            {{-- Dashboard untuk Pegawai Biasa --}}

            {{-- Welcome Section Pegawai --}}
            <div class="bg-gradient-to-r from-primary to-primaryDark rounded-2xl shadow-xl p-8 text-white animate-slide-up">
                <div class="flex items-center gap-4">
                    <img src="{{ $user->avatar ? asset('storage/' . $user->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&size=80&background=ffffff&color=0D9488' }}"
                        class="w-20 h-20 rounded-full border-4 border-white/30 shadow-lg">
                    <div>
                        <h2 class="text-2xl font-bold mb-1">Halo, {{ $user->name }}! 👋</h2>
                        <p class="text-white/80">{{ $user->jabatan }} • {{ now()->format('l, d F Y') }}</p>
                    </div>
                </div>
            </div>

            {{-- Status Absensi Hari Ini --}}
            <div class="bg-white rounded-2xl shadow-xl p-6 animate-slide-up-delay-1">
                <div class="flex items-center gap-3 mb-6">
                    <div class="p-3 bg-gradient-to-br from-primary to-primaryDark rounded-xl shadow-lg">
                        <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-800">Status Absensi Hari Ini</h3>
                </div>

                @if($userAbsensiToday)
                    @if($userAbsensiToday->izin)
                        {{-- Status Izin --}}
                        <div class="flex flex-col md:flex-row items-center gap-6">
                            <div class="w-24 h-24 rounded-full bg-blue-100 flex items-center justify-center">
                                <svg class="w-12 h-12 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div class="flex-1 text-center md:text-left">
                                <h4 class="text-xl font-bold text-blue-600">Izin Hari Ini 📝</h4>
                                @if($userAbsensiToday->izin_keterangan)
                                    <p class="text-gray-600 mt-1">{{ $userAbsensiToday->izin_keterangan }}</p>
                                @endif
                            </div>
                        </div>
                    @else
                        {{-- Status Absen Normal --}}
                        <div class="flex flex-col md:flex-row items-center gap-6">
                            <div class="w-24 h-24 rounded-full bg-green-100 flex items-center justify-center">
                                <svg class="w-12 h-12 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                            <div class="flex-1 text-center md:text-left">
                                <div class="space-y-2">
                                    <div class="flex items-center gap-2">
                                        <span class="text-sm font-medium text-gray-500">Absen Pagi:</span>
                                        <span
                                            class="text-lg font-bold text-gray-800">{{ $userAbsensiToday->jam_masuk ? $userAbsensiToday->jam_masuk->format('H:i') : '-' }}</span>
                                        @if(!$userAbsensiToday->telat)
                                            <span class="text-xs px-2 py-1 bg-green-100 text-green-700 rounded-full">Tepat Waktu</span>
                                        @else
                                            <span class="text-xs px-2 py-1 bg-red-100 text-red-700 rounded-full">Terlambat
                                                {{ $userAbsensiToday->menit_telat }}m</span>
                                        @endif
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <span class="text-sm font-medium text-gray-500">Absen Keluar:</span>
                                        <span
                                            class="text-lg font-bold text-gray-800">{{ $userAbsensiToday->jam_pulang ? $userAbsensiToday->jam_pulang->format('H:i') : 'Belum' }}</span>
                                        @if($userAbsensiToday->jam_pulang)
                                            <span class="text-xs px-2 py-1 bg-blue-100 text-blue-700 rounded-full">Selesai</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            @if(!$userAbsensiToday->jam_pulang)
                                <a href="{{ route('absen.index') }}"
                                    class="px-6 py-3 bg-gradient-to-r from-primary to-primaryDark text-white font-bold rounded-xl hover:shadow-lg transition-all">
                                    Absen Pulang
                                </a>
                            @endif
                        </div>
                    @endif
                @else
                    <div class="text-center py-8">
                        <div class="w-24 h-24 bg-yellow-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <svg class="w-12 h-12 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <h4 class="text-xl font-bold text-yellow-600 mb-2">Belum Absen Hari Ini</h4>
                        <p class="text-gray-500 mb-4">Jangan lupa untuk melakukan absensi!</p>
                        <a href="{{ route('absen.index') }}"
                            class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-primary to-primaryDark text-white font-bold rounded-xl hover:shadow-lg transition-all">
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
                <div class="bg-white rounded-2xl shadow-lg p-5 animate-slide-up-delay-2">
                    <div class="flex items-center gap-3 mb-2">
                        <div class="p-2 bg-green-100 rounded-lg">
                            <svg class="h-5 w-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <span class="text-2xl font-bold text-gray-800">{{ $userTotalHadir }}</span>
                    </div>
                    <p class="text-sm text-gray-500">Hadir Bulan Ini</p>
                </div>
                <div class="bg-white rounded-2xl shadow-lg p-5 animate-slide-up-delay-2">
                    <div class="flex items-center gap-3 mb-2">
                        <div class="p-2 bg-red-100 rounded-lg">
                            <svg class="h-5 w-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <span class="text-2xl font-bold text-gray-800">{{ $userTotalTelat }}</span>
                    </div>
                    <p class="text-sm text-gray-500">Terlambat</p>
                </div>
                <div class="bg-white rounded-2xl shadow-lg p-5 animate-slide-up-delay-3">
                    <div class="flex items-center gap-3 mb-2">
                        <div class="p-2 bg-yellow-100 rounded-lg">
                            <svg class="h-5 w-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <span class="text-2xl font-bold text-gray-800">{{ $userTotalMenitTelat }}</span>
                    </div>
                    <p class="text-sm text-gray-500">Total Menit Telat</p>
                </div>
                <div class="bg-white rounded-2xl shadow-lg p-5 animate-slide-up-delay-3">
                    <div class="flex items-center gap-3 mb-2">
                        <div class="p-2 bg-blue-100 rounded-lg">
                            <svg class="h-5 w-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1">
                                </path>
                            </svg>
                        </div>
                        <span class="text-lg font-bold text-gray-800">
                            @if($userPenggajianTerakhir)
                                Rp {{ number_format($userPenggajianTerakhir->total_gaji, 0, ',', '.') }}
                            @else
                                -
                            @endif
                        </span>
                    </div>
                    <p class="text-sm text-gray-500">Gaji Terakhir</p>
                </div>
            </div>

            {{-- Riwayat Absensi Terakhir --}}
            <div class="bg-white rounded-2xl shadow-xl p-6 animate-slide-up-delay-4">
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center gap-3">
                        <div class="p-3 bg-gradient-to-br from-primary to-primaryDark rounded-xl shadow-lg">
                            <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                                </path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-gray-800">Riwayat Absensi Terakhir</h3>
                    </div>
                    <a href="{{ route('absen.riwayat') }}"
                        class="text-primary hover:text-primaryDark text-sm font-medium">Lihat Semua →</a>
                </div>

                @if(count($userRiwayatAbsensi) > 0)
                    <div class="space-y-3">
                        @foreach($userRiwayatAbsensi as $absen)
                            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl">
                                <div class="flex items-center gap-4">
                                    <div class="w-10 h-10 rounded-full
                                                    @if($absen->izin) bg-blue-100

                                                    @endif flex items-center justify-center">
                                        @if($absen->izin)
                                            <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                        @else
                                            <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M5 13l4 4L19 7"></path>
                                            </svg>
                                        @endif
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-800">
                                            {{ \Carbon\Carbon::parse($absen->tanggal)->format('l, d M Y') }}</p>
                                        <p class="text-sm text-gray-500">
                                            @if($absen->izin)
                                                Izin: {{ $absen->izin_keterangan ?: 'Tanpa keterangan' }}
                                            @else
                                                Masuk: {{ $absen->jam_masuk ? $absen->jam_masuk->format('H:i') : '-' }}
                                                @if($absen->jam_pulang)
                                                    • Keluar: {{ $absen->jam_pulang->format('H:i') }}
                                                @endif
                                            @endif
                                        </p>
                                    </div>
                                </div>

                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8">
                        <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-3">
                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                                </path>
                            </svg>
                        </div>
                        <p class="text-gray-500">Belum ada riwayat absensi</p>
                    </div>
                @endif
            </div>


        @endif
    </div>
</x-app-layout>
