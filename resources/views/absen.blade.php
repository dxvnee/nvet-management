<x-app-layout>
    <x-slot name="header">Absen</x-slot>
    <x-slot name="subtle">Halaman absensi karyawan</x-slot>

    <div class="space-y-6">
        {{-- Welcome Section --}}
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
                        <svg class="w-8 h-8 md:w-10 md:h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-xl md:text-2xl font-bold mb-1">Absensi Kehadiran</h2>
                        <p class="text-white/80 text-sm md:text-base flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            <span id="current-datetime"></span>
                        </p>
                    </div>
                </div>
                <div class="flex items-center gap-4">
                    <div class="text-right bg-white/10 backdrop-blur-sm rounded-2xl px-4 md:px-6 py-3">
                        <p class="text-white/70 text-xs uppercase tracking-wider mb-1">Waktu Sekarang</p>
                        <p class="text-2xl md:text-3xl font-bold font-mono" x-data="{ time: '' }"
                            x-init="setInterval(() => time = new Date().toLocaleTimeString('id-ID'), 1000)"
                            x-text="time"></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Status Absen Hari Ini -->
        <div class="bg-white rounded-2xl shadow-xl p-6 border border-gray-100 animate-slide-up-delay-1">
            <div class="flex items-center gap-3 mb-6">
                <div class="p-3 bg-gradient-to-br from-primary to-primaryDark rounded-xl shadow-lg">
                    <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div>
                    <h2 class="text-xl font-bold text-gray-800">Status Absensi Hari Ini</h2>
                    <p class="text-gray-500 text-sm">Pantau kehadiran Anda</p>
                </div>
            </div>

            <!-- Status Cards -->
            @if($liburOrNot)
                <!-- Status Hari Libur - Full Width -->
                <div class="w-full p-6 rounded-2xl border-2 bg-gradient-to-br from-blue-50 to-indigo-50 border-blue-200 mb-6 shadow-sm">
                    <div class="flex items-center gap-4">
                        <div class="p-4 rounded-2xl bg-gradient-to-br from-blue-500 to-indigo-600 shadow-lg">
                            <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z">
                                </path>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <p class="text-xl font-bold text-blue-700">
                                Hari Libur{{ isset($namaHariLibur) && $namaHariLibur ? ' - ' . $namaHariLibur : '' }}
                            </p>
                            <p class="text-sm text-blue-600 mt-1">
                                @if($sudahHadir)
                                    <span class="inline-flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        Anda sedang lembur hari libur. Masuk: {{ $sudahHadir->jam_masuk->format('H:i') }}
                                    </span>
                                @else
                                    Hari ini adalah hari libur{{ isset($namaHariLibur) && $namaHariLibur ? ' (' . $namaHariLibur . ')' : '' }}. Klik tombol di bawah jika ingin lembur.
                                @endif
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Lokasi Status untuk Hari Libur -->
                <div id="location-status" class="mb-6 p-4 rounded-2xl bg-gradient-to-r from-gray-50 to-gray-100 border border-gray-200 shadow-sm">
                    <div class="flex items-center gap-3">
                        <div class="animate-spin h-5 w-5 border-2 border-primary border-t-transparent rounded-full"></div>
                        <span class="text-gray-600 font-medium">Mengambil lokasi...</span>
                    </div>
                </div>

                <!-- Tombol Lembur Hari Libur -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Tombol Masuk Lembur -->
                    <button type="button" onclick="openLemburLiburModal('hadir')" {{ $sudahHadir ? 'disabled' : '' }}
                        class="group w-full py-5 px-6 rounded-2xl font-bold text-white transition-all duration-300 flex items-center justify-center gap-3
                        {{ $sudahHadir ? 'bg-gray-300 cursor-not-allowed' : 'bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 shadow-lg hover:shadow-xl transform hover:scale-[1.02]' }}">
                        <div class="p-2 bg-white/20 rounded-xl group-hover:scale-110 transition-transform">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <span>{{ $sudahHadir ? 'Sudah Masuk Lembur' : 'Masuk Lembur Hari Libur' }}</span>
                    </button>

                    <!-- Tombol Pulang Lembur -->
                    <button type="button" onclick="openCameraModal('pulang')" {{ !$sudahHadir || $sudahPulang ? 'disabled' : '' }}
                        class="group w-full py-5 px-6 rounded-2xl font-bold text-white transition-all duration-300 flex items-center justify-center gap-3
                        {{ !$sudahHadir || $sudahPulang ? 'bg-gray-300 cursor-not-allowed' : 'bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 shadow-lg hover:shadow-xl transform hover:scale-[1.02]' }}">
                        <div class="p-2 bg-white/20 rounded-xl group-hover:scale-110 transition-transform">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                            </svg>
                        </div>
                        <span>{{ $sudahPulang ? 'Sudah Pulang' : (!$sudahHadir ? 'Masuk Lembur Dulu' : 'Pulang Lembur') }}</span>
                    </button>
                </div>
            @elseif($sudahIzin)
                <!-- Status Izin - Full Width -->
                <div class="w-full p-6 rounded-2xl border-2 bg-gradient-to-br from-amber-50 to-yellow-50 border-amber-200 mb-6 shadow-sm">
                    <div class="flex items-center gap-4">
                        <div class="p-4 rounded-2xl bg-gradient-to-br from-amber-500 to-yellow-600 shadow-lg">
                            <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                                </path>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <p class="text-xl font-bold text-amber-700">Sedang Izin</p>
                            <p class="text-sm text-amber-600 mt-1 flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                Tanggal: {{ $sudahIzin->tanggal->format('d M Y') }}
                            </p>
                            @if($sudahIzin->izin_keterangan)
                                <div class="mt-3 p-3 bg-amber-100 rounded-xl">
                                    <p class="text-sm text-amber-800 italic flex items-start gap-2">
                                        <svg class="w-4 h-4 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path>
                                        </svg>
                                        "{{ $sudahIzin->izin_keterangan }}"
                                    </p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @else
                <!-- Status Cards Normal -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                    <!-- Hadir -->
                    <div class="group p-5 rounded-2xl border-2 transition-all duration-300 {{ $sudahHadir ? 'bg-gradient-to-br from-emerald-50 to-green-50 border-emerald-200 shadow-sm' : 'bg-gradient-to-br from-gray-50 to-gray-100 border-gray-200' }}">
                        <div class="flex items-center gap-4">
                            <div class="p-3 rounded-xl shadow-lg transition-transform group-hover:scale-105 {{ $sudahHadir ? 'bg-gradient-to-br from-emerald-500 to-green-600' : 'bg-gray-300' }}">
                                <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <div class="flex items-center gap-2 flex-wrap">
                                    <p class="font-bold text-lg {{ $sudahHadir ? 'text-emerald-700' : 'text-gray-500' }}">
                                        Hadir
                                    </p>
                                    @if($sudahHadir && $sudahHadir->shift_number)
                                        <span class="text-xs px-2.5 py-1 rounded-full font-bold shadow-sm
                                            {{ (int) $sudahHadir->shift_number === 1 ? 'bg-gradient-to-r from-blue-500 to-blue-600 text-white' : 'bg-gradient-to-r from-orange-500 to-orange-600 text-white' }}">
                                            Shift {{ $sudahHadir->shift_number }}
                                        </span>
                                    @endif
                                </div>
                                @if($sudahHadir)
                                    <p class="text-sm text-emerald-600 mt-1 flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        <span class="font-semibold">{{ $sudahHadir->jam_masuk->format('H:i') }}</span>
                                        @if($sudahHadir->telat)
                                            <span class="ml-1 px-2 py-0.5 rounded-full text-xs font-bold bg-rose-100 text-rose-600">TELAT {{ $sudahHadir->menit_telat }}m</span>
                                        @endif
                                    </p>
                                @else
                                    <p class="text-sm text-gray-400 mt-1">Belum absen</p>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Pulang -->
                    <div class="group p-5 rounded-2xl border-2 transition-all duration-300 {{ $sudahPulang ? 'bg-gradient-to-br from-blue-50 to-indigo-50 border-blue-200 shadow-sm' : 'bg-gradient-to-br from-gray-50 to-gray-100 border-gray-200' }}">
                        <div class="flex items-center gap-4">
                            <div class="p-3 rounded-xl shadow-lg transition-transform group-hover:scale-105 {{ $sudahPulang ? 'bg-gradient-to-br from-blue-500 to-indigo-600' : 'bg-gray-300' }}">
                                <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                                    </path>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <p class="font-bold text-lg {{ $sudahPulang ? 'text-blue-700' : 'text-gray-500' }}">Pulang</p>
                                @if($sudahPulang)
                                    <p class="text-sm text-blue-600 mt-1 flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        <span class="font-semibold">{{ $sudahPulang->jam_pulang->format('H:i') }}</span>
                                    </p>
                                @else
                                    <p class="text-sm text-gray-400 mt-1">Belum pulang</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Info Hari Khusus -->
            @if(isset($hariKhususInfo) && $hariKhususInfo)
            <div class="bg-gradient-to-r from-blue-50 via-indigo-50 to-purple-50 rounded-2xl p-4 mb-6 border border-blue-200 shadow-sm">
                <div class="flex items-center gap-3">
                    <div class="p-3 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl shadow-lg">
                        <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-bold text-blue-700">{{ $hariKhususInfo->nama }}</p>
                        <p class="text-xs text-blue-600 flex items-center gap-1">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Hari khusus - tetap masuk kerja seperti biasa
                            @if($hariKhususInfo->jam_masuk && $hariKhususInfo->jam_keluar)
                                ({{ \Carbon\Carbon::parse($hariKhususInfo->jam_masuk)->format('H:i') }} - {{ \Carbon\Carbon::parse($hariKhususInfo->jam_keluar)->format('H:i') }})
                            @endif
                        </p>
                    </div>
                </div>
            </div>
            @endif

            <!-- Info Jam Kerja -->
            @if(!$liburOrNot)
            <div class="bg-gradient-to-r from-primary/5 to-primary/10 rounded-2xl p-4 mb-6 border border-primary/20 shadow-sm">
                <div class="flex items-center gap-3 text-primary">
                    <div class="p-2 bg-primary/20 rounded-xl">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    @php
                        $user = auth()->user();
                        if ($user->is_shift && $user->shift_partner_id) {
                            $jamMasuk1 = $user->shift1_jam_masuk ? \Carbon\Carbon::parse($user->shift1_jam_masuk)->format('H:i') : '08:00';
                            $jamKeluar1 = $user->shift1_jam_keluar ? \Carbon\Carbon::parse($user->shift1_jam_keluar)->format('H:i') : '14:00';
                            $jamMasuk2 = $user->shift2_jam_masuk ? \Carbon\Carbon::parse($user->shift2_jam_masuk)->format('H:i') : '14:00';
                            $jamKeluar2 = $user->shift2_jam_keluar ? \Carbon\Carbon::parse($user->shift2_jam_keluar)->format('H:i') : '20:00';
                            $partner = $user->shiftPartner;
                            $partnerName = $partner ? $partner->name : 'Tidak ada';
                        } else {
                            $jamMasuk = $user->jam_masuk ? \Carbon\Carbon::parse($user->jam_masuk)->format('H:i') : '09:00';
                            $jamKeluar = $user->jam_keluar ? \Carbon\Carbon::parse($user->jam_keluar)->format('H:i') : '20:00';
                        }
                    @endphp

                    @if($user->is_shift && $user->shift_partner_id)
                        <div class="flex-1">
                            <div class="flex items-center gap-2 flex-wrap">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-bold bg-blue-100 text-blue-800 shadow-sm">
                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    SHIFT
                                </span>
                            </div>
                            <p class="text-sm font-medium mt-1">
                                Shift 1: {{ $jamMasuk1 }} - {{ $jamKeluar1 }} |
                                Shift 2: {{ $jamMasuk2 }} - {{ $jamKeluar2 }} |
                                Partner: {{ $partnerName }}
                            </p>
                        </div>
                    @else
                        <div class="flex-1">
                            <p class="text-sm font-medium">
                                <span class="inline-flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    Jam masuk: <strong>{{ $jamMasuk }} WIB</strong>
                                </span>
                                <span class="mx-2">|</span>
                                <span class="inline-flex items-center gap-1">
                                    Jam pulang: <strong>{{ $jamKeluar }} WIB</strong>
                                </span>
                                <span class="mx-2">|</span>
                                <span class="inline-flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                    Radius: <strong>20 meter</strong>
                                </span>
                            </p>
                        </div>
                    @endif
                </div>

                @if($sudahHadir && $sudahHadir->shift_number)
                    <div class="mt-3 pt-3 border-t border-primary/20 flex items-center gap-2">
                        <span class="inline-flex items-center px-3 py-1.5 rounded-full text-sm font-bold shadow-sm
                            {{ (int) $sudahHadir->shift_number === 1 ? 'bg-gradient-to-r from-blue-500 to-blue-600 text-white' : 'bg-gradient-to-r from-orange-500 to-orange-600 text-white' }}">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            Anda Shift {{ $sudahHadir->shift_number }}
                        </span>
                        @php
                            $shiftJamKeluar = (int) $sudahHadir->shift_number === 1
                                ? \Carbon\Carbon::parse($user->shift1_jam_keluar)->format('H:i')
                                : \Carbon\Carbon::parse($user->shift2_jam_keluar)->format('H:i');
                        @endphp
                        <span class="text-sm text-gray-600">Bisa pulang setelah <strong>{{ $shiftJamKeluar }} WIB</strong></span>
                    </div>
                @endif
            </div>
            @endif

            <!-- Total Jam Kerja Hari Ini -->
            @if($sudahHadir && !$sudahIzin && !$liburOrNot)
                <div class="bg-gradient-to-r from-indigo-50 via-blue-50 to-purple-50 rounded-2xl p-5 mb-6 border border-blue-200 shadow-sm animate-slide-up-delay-1">
                    <div class="flex items-center gap-4">
                        <div class="p-3 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl shadow-lg">
                            <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-blue-700">Total Jam Kerja Hari Ini</p>
                            <p class="text-2xl font-bold bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent" id="working-hours">{{ $totalJamKerjaText }}</p>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Lokasi Status & Absen Buttons (tidak ditampilkan pada hari libur) -->
            @if(!$liburOrNot)
            <!-- Lokasi Status -->
            <div id="location-status" class="mb-6 p-4 rounded-2xl bg-gradient-to-r from-gray-50 to-gray-100 border border-gray-200 shadow-sm">
                <div class="flex items-center gap-3">
                    <div class="animate-spin h-5 w-5 border-2 border-primary border-t-transparent rounded-full"></div>
                    <span class="text-gray-600 font-medium">Mengambil lokasi...</span>
                </div>
            </div>

            <!-- Absen Buttons -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <!-- Tombol Hadir -->
                <button type="button" onclick="openCameraModal('hadir')" {{ $sudahHadir || $sudahIzin || $liburOrNot ? 'disabled' : '' }}
                    class="group w-full py-3 px-6 rounded-2xl font-bold text-white transition-all duration-300 flex items-center justify-center gap-3
                    {{ $sudahHadir || $sudahIzin || $liburOrNot ? 'bg-gray-300 cursor-not-allowed' : 'bg-gradient-to-r from-emerald-500 to-green-600 hover:from-emerald-600 hover:to-green-700 shadow-lg hover:shadow-xl transform hover:scale-[1.02]' }}">
                    <div class="p-2 bg-white/20 rounded-xl group-hover:scale-110 transition-transform">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                    <span>{{ $liburOrNot ? 'Hari Libur' : ($sudahHadir ? 'Sudah Hadir' : ($sudahIzin ? 'Sedang Izin' : 'Absen Hadir')) }}</span>
                </button>

                <!-- Tombol Izin -->
                <button type="button" onclick="openCameraModal('izin')" {{ ($sudahIzin && !$sudahHadir) || $sudahPulang || $liburOrNot ? 'disabled' : '' }}
                    class="group w-full py-3 px-6 rounded-2xl font-bold text-white transition-all duration-300 flex items-center justify-center gap-3
                    {{ ($sudahIzin && !$sudahHadir) || $sudahPulang || $liburOrNot ? 'bg-gray-300 cursor-not-allowed' : ($sudahHadir ? 'bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 shadow-lg hover:shadow-xl transform hover:scale-[1.02]' : 'bg-gradient-to-r from-amber-500 to-yellow-600 hover:from-amber-600 hover:to-yellow-700 shadow-lg hover:shadow-xl transform hover:scale-[1.02]') }}">
                    <div class="p-2 bg-white/20 rounded-xl group-hover:scale-110 transition-transform">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                            </path>
                        </svg>
                    </div>
                    <span>
                    @if($liburOrNot)
                        Hari Libur
                    @elseif($sudahIzin && $sudahHadir)
                        Sudah Izin Pulang
                    @elseif($sudahIzin)
                        Sedang Izin
                    @elseif($sudahPulang)
                        Sudah Pulang
                    @elseif($sudahHadir)
                        Izin Pulang Awal
                    @else
                        Izin Tidak Masuk
                    @endif
                    </span>
                </button>

                <!-- Tombol Pulang -->
                <button type="button" onclick="openCameraModal('pulang')" {{ $sudahPulang || !$sudahHadir || $sudahIzin || $liburOrNot ? 'disabled' : '' }}
                    class="group w-full py-3 px-6 rounded-2xl font-bold text-white transition-all duration-300 flex items-center justify-center gap-3
                    {{ $sudahPulang || !$sudahHadir || $sudahIzin || $liburOrNot ? 'bg-gray-300 cursor-not-allowed' : 'bg-gradient-to-r from-blue-500 to-indigo-600 hover:from-blue-600 hover:to-indigo-700 shadow-lg hover:shadow-xl transform hover:scale-[1.02]' }}">
                    <div class="p-2 bg-white/20 rounded-xl group-hover:scale-110 transition-transform">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                            </path>
                        </svg>
                    </div>
                    <span>
                    @if($liburOrNot)
                        Hari Libur
                    @elseif($sudahPulang)
                        Sudah Pulang
                    @elseif($sudahIzin)
                        Sudah Izin Pulang
                    @elseif(!$sudahHadir)
                        Hadir Dulu
                    @else
                        @php
                            $user = auth()->user();
                            if ($user->is_shift && $sudahHadir && $sudahHadir->shift_number) {
                                $jamPulangText = (int) $sudahHadir->shift_number === 1
                                    ? \Carbon\Carbon::parse($user->shift1_jam_keluar)->format('H:i')
                                    : \Carbon\Carbon::parse($user->shift2_jam_keluar)->format('H:i');
                            } else {
                                $jamPulangText = $user->jam_keluar
                                    ? \Carbon\Carbon::parse($user->jam_keluar)->format('H:i')
                                    : '20:00';
                            }
                        @endphp
                        Absen Pulang (≥{{ $jamPulangText }})
                    @endif
                    </span>
                </button>
            </div>
            @endif
        </div>

    </div>

    <!-- Camera Modal -->
    <div id="camera-modal"
        class="fixed inset-0 bg-black/60 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4">
        <div class="bg-white rounded-3xl shadow-2xl w-full max-w-lg transform transition-all animate-slide-up">
            <div class="p-6">
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center gap-3">
                        <div class="p-2 bg-gradient-to-br from-primary to-primaryDark rounded-xl shadow-lg">
                            <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                        </div>
                        <h3 id="camera-title" class="text-xl font-bold text-gray-800">Ambil Foto</h3>
                    </div>
                    <button onclick="closeCameraModal()" class="p-2 rounded-xl text-gray-400 hover:text-gray-600 hover:bg-gray-100 transition-all">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <!-- Camera Preview -->
                <div class="relative bg-gradient-to-br from-gray-900 to-black rounded-2xl overflow-hidden mb-4 shadow-inner">
                    <video id="camera-preview" autoplay playsinline class="w-full h-64 object-cover transform scale-x-[-1]"></video>
                    <canvas id="camera-canvas" class="hidden"></canvas>
                    <img id="photo-preview" class="w-full h-64 object-cover hidden">
                </div>

                <!-- Captured Photo Preview -->
                <div id="photo-result" class="hidden mb-4">
                    <p class="text-sm font-medium text-gray-600 mb-2 flex items-center gap-1">
                        <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Foto yang diambil:
                    </p>
                    <div class="relative">
                        <img id="captured-photo" class="w-full h-48 object-cover rounded-2xl border-2 border-emerald-500 shadow-lg">
                        <div class="absolute top-3 right-3 bg-gradient-to-r from-emerald-500 to-green-600 text-white p-2 rounded-xl shadow-lg">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Camera Controls -->
                <div class="flex gap-3">
                    <button type="button" id="btn-capture" onclick="capturePhoto()"
                        class="flex-1 py-3 px-6 rounded-2xl font-bold text-white bg-gradient-to-r from-primary to-primaryDark hover:from-primaryDark hover:to-primaryExtraDark transition-all shadow-lg flex items-center justify-center gap-2">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z">
                            </path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        Ambil Foto
                    </button>
                    <button type="button" id="btn-retake" onclick="retakePhoto()"
                        class="hidden py-3 px-6 rounded-2xl font-bold text-gray-700 bg-gray-100 hover:bg-gray-200 border border-gray-200 transition-all flex items-center justify-center gap-2">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15">
                            </path>
                        </svg>
                        Ulangi
                    </button>
                </div>

                <!-- Submit Form (hidden, submitted via JS) -->
                <form id="camera-form" action="{{ route('absen.store') }}" method="POST" class="hidden">
                    @csrf
                    <input type="hidden" name="tipe" id="camera-tipe">
                    <input type="hidden" name="latitude" id="camera-lat">
                    <input type="hidden" name="longitude" id="camera-lng">
                    <input type="hidden" name="foto" id="camera-foto">
                    <input type="hidden" name="keterangan" id="camera-keterangan">
                    <input type="hidden" name="diluar_lokasi_alasan" id="camera-diluar-lokasi-alasan">
                    <input type="hidden" name="is_lembur" id="camera-is-lembur" value="0">
                    <input type="hidden" name="lembur_keterangan" id="camera-lembur-keterangan">
                </form>

                <!-- Submit Button -->
                <button type="button" id="btn-submit" onclick="submitWithPhoto()"
                    class="w-full mt-4 py-4 px-6 rounded-2xl font-bold text-white bg-gradient-to-r from-emerald-500 to-green-600 hover:from-emerald-600 hover:to-green-700 transition-all shadow-lg hover:shadow-xl flex items-center justify-center gap-2 transform hover:scale-[1.01]">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    <span id="btn-submit-text">Kirim Absen</span>
                </button>

                <!-- Keterangan for Izin -->
                <div id="izin-keterangan-wrapper" class="hidden mt-4">
                    <label class="text-sm font-medium text-gray-700 mb-2 flex items-center gap-1">
                        <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path>
                        </svg>
                        <span id="izin-label">Alasan Izin</span>
                    </label>
                    <textarea id="izin-keterangan-input" rows="3"
                        class="w-full px-4 py-3 rounded-2xl border border-gray-200 focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all shadow-sm"
                        placeholder="Masukkan alasan..."></textarea>
                </div>

                <!-- Alasan Absen Diluar Lokasi -->
                <div id="diluar-lokasi-wrapper" class="hidden mt-4">
                    <div class="p-4 bg-gradient-to-r from-amber-50 to-yellow-50 border border-amber-200 rounded-2xl mb-3 shadow-sm">
                        <div class="flex items-center gap-2 text-amber-700">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                            </svg>
                            <span class="font-medium">Anda berada di luar lokasi kantor</span>
                        </div>
                        <p class="text-sm text-yellow-600 mt-1" id="diluar-lokasi-jarak"></p>
                    </div>
                    <label class="text-sm font-medium text-gray-700 mb-2 flex items-center gap-1">
                        <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                        </svg>
                        Alasan Absen Diluar Lokasi <span class="text-rose-500">*</span>
                    </label>
                    <textarea id="diluar-lokasi-input" rows="3"
                        class="w-full px-4 py-3 rounded-2xl border border-gray-200 focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all shadow-sm"
                        placeholder="Contoh: Sedang visit ke klien, meeting di luar kantor, dinas luar, dll..."></textarea>
                </div>
            </div>
        </div>
    </div>

    <!-- Lembur Confirmation Modal -->
    <div id="lembur-modal"
        class="fixed inset-0 bg-black/60 backdrop-blur-sm z-[60] hidden flex items-center justify-center p-4">
        <div class="bg-white rounded-3xl shadow-2xl w-full max-w-md transform transition-all animate-slide-up">
            <div class="p-6">
                <div class="flex items-center justify-center mb-4">
                    <div class="p-4 bg-gradient-to-br from-orange-100 to-amber-100 rounded-2xl shadow-lg">
                        <svg class="h-12 w-12 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
                <h3 class="text-xl font-bold text-gray-800 text-center mb-2">Konfirmasi Lembur</h3>
                <p class="text-gray-600 text-center mb-4">
                    Anda pulang <span id="lembur-menit" class="font-bold text-orange-600">0</span> menit setelah jam
                    kerja berakhir.
                </p>
                <p class="text-gray-600 text-center mb-6">
                    Apakah ini termasuk <span class="font-bold text-orange-600">lembur</span>?
                </p>

                <!-- Keterangan Lembur -->
                <div id="lembur-keterangan-wrapper" class="mb-6 hidden">
                    <label class="text-sm font-medium text-gray-700 mb-2 flex items-center gap-1">
                        <svg class="w-4 h-4 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path>
                        </svg>
                        Keterangan Lembur
                    </label>
                    <textarea id="lembur-keterangan-input" rows="2"
                        class="w-full px-4 py-3 rounded-2xl border border-gray-200 focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all shadow-sm"
                        placeholder="Masukkan keterangan lembur (opsional)..."></textarea>
                </div>

                <div class="flex gap-3">
                    <button type="button" onclick="confirmLembur(false)"
                        class="flex-1 py-3 px-6 rounded-2xl font-bold text-gray-700 bg-gray-100 hover:bg-gray-200 border border-gray-200 transition-all">
                        Bukan Lembur
                    </button>
                    <button type="button" onclick="showLemburKeterangan()"
                        class="flex-1 py-3 px-6 rounded-2xl font-bold text-white bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 transition-all shadow-lg hover:shadow-xl">
                        Ya, Lembur
                    </button>
                </div>

                <!-- Submit Lembur Button (hidden initially) -->
                <button type="button" id="btn-submit-lembur" onclick="confirmLembur(true)"
                    class="hidden w-full mt-4 py-4 px-6 rounded-2xl font-bold text-white bg-gradient-to-r from-emerald-500 to-green-600 hover:from-emerald-600 hover:to-green-700 transition-all shadow-lg hover:shadow-xl">
                    Kirim dengan Lembur
                </button>
            </div>
        </div>
    </div>

    <!-- Lembur Hari Libur Confirmation Modal -->
    <div id="lembur-libur-modal"
        class="fixed inset-0 bg-black/60 backdrop-blur-sm z-[60] hidden flex items-center justify-center p-4">
        <div class="bg-white rounded-3xl shadow-2xl w-full max-w-md transform transition-all animate-slide-up">
            <div class="p-6">
                <div class="flex items-center justify-center mb-4">
                    <div class="p-4 bg-gradient-to-br from-blue-100 to-indigo-100 rounded-2xl shadow-lg">
                        <svg class="h-12 w-12 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                    </div>
                </div>
                <h3 class="text-xl font-bold text-gray-800 text-center mb-2">Konfirmasi Lembur Hari Libur</h3>
                <p class="text-gray-600 text-center mb-4">
                    Hari ini adalah <span class="font-bold text-blue-600">hari libur</span> Anda.
                </p>
                <p class="text-gray-600 text-center mb-6">
                    Apakah Anda yakin ingin masuk untuk <span class="font-bold text-orange-600">lembur</span>?
                </p>

                <!-- Keterangan Lembur Hari Libur -->
                <div id="lembur-libur-keterangan-wrapper" class="mb-6">
                    <label class="text-sm font-semibold text-gray-700 mb-2 flex items-center gap-2">
                        <svg class="w-4 h-4 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                        Keterangan Lembur <span class="text-red-500">*</span>
                    </label>
                    <textarea id="lembur-libur-keterangan-input" rows="3"
                        class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-orange-400 focus:ring-4 focus:ring-orange-100 transition-all resize-none text-gray-700 placeholder-gray-400"
                        placeholder="Jelaskan alasan dan detail pekerjaan lembur di hari libur..."></textarea>
                </div>

                <div class="flex gap-3">
                    <button type="button" onclick="closeLemburLiburModal()"
                        class="group flex-1 py-3.5 px-6 rounded-2xl font-bold text-gray-700 bg-gray-100 hover:bg-gray-200 transition-all duration-300 flex items-center justify-center gap-2">
                        <svg class="w-5 h-5 transition-transform group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                        Batal
                    </button>
                    <button type="button" onclick="confirmLemburLibur()"
                        class="group flex-1 py-3.5 px-6 rounded-2xl font-bold text-white bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 transition-all duration-300 shadow-lg hover:shadow-xl hover:scale-[1.02] flex items-center justify-center gap-2">
                        <svg class="w-5 h-5 transition-transform group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        Ya, Lembur
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        let userLatitude = null;
        let userLongitude = null;
        let cameraStream = null;
        let capturedPhotoData = null;
        let currentTipe = null;
        let isOutsideLocation = false;
        let currentDistance = 0;

        // Office coordinates (same as controller)
        const officeLatitude = {{ $officeLatitude }};
        const officeLongitude = {{ $officeLongitude }};
        const allowedRadius = {{ $allowedRadius }};

        // Calculate distance using Haversine formula (same as controller)
        function calculateDistance(lat1, lon1, lat2, lon2) {
            const earthRadius = 6371000; // meters
            const dLat = (lat2 - lat1) * Math.PI / 180;
            const dLon = (lon2 - lon1) * Math.PI / 180;
            const a = Math.sin(dLat / 2) * Math.sin(dLat / 2) +
                      Math.cos(lat1 * Math.PI / 180) * Math.cos(lat2 * Math.PI / 180) *
                      Math.sin(dLon / 2) * Math.sin(dLon / 2);
            const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
            return earthRadius * c;
        }

        // Update current datetime
        function updateDateTime() {
            const now = new Date();
            const options = {
                weekday: 'long',
                year: 'numeric',
                month: 'long',
                day: 'numeric',
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit'
            };
            document.getElementById('current-datetime').textContent = now.toLocaleDateString('id-ID', options);

        }
        updateDateTime();
        setInterval(updateDateTime, 1000);

        // Get user location with fallback
        function getLocation() {
            const statusEl = document.getElementById('location-status');

            if (!navigator.geolocation) {
                statusEl.innerHTML = `
                    <div class="flex items-center gap-3 text-red-600">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                        </svg>
                        <span>Browser tidak mendukung Geolocation</span>
                    </div>
                `;
                return;
            }

            navigator.geolocation.getCurrentPosition(
                (position) => {
                    userLatitude = position.coords.latitude;
                    userLongitude = position.coords.longitude;

                    // Calculate distance to office
                    currentDistance = calculateDistance(userLatitude, userLongitude, officeLatitude, officeLongitude);
                    isOutsideLocation = currentDistance > allowedRadius;

                    if (isOutsideLocation) {
                        statusEl.innerHTML = `
                            <div class="flex items-center gap-3 text-yellow-600">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                </svg>
                                <span>Di luar area kantor (${Math.round(currentDistance)}m dari kantor)</span>
                                <button onclick="getLocation()" class="ml-auto text-sm bg-yellow-100 px-3 py-1 rounded-lg hover:bg-yellow-200 transition-colors">Refresh</button>
                            </div>
                        `;
                        statusEl.classList.remove('bg-gray-50', 'border-gray-200', 'bg-green-50', 'border-green-200');
                        statusEl.classList.add('bg-yellow-50', 'border-yellow-200');
                    } else {
                        statusEl.innerHTML = `
                            <div class="flex items-center gap-3 text-green-600">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span>Lokasi berhasil diambil (Dalam area kantor)</span>
                                <button onclick="getLocation()" class="ml-auto text-sm bg-green-100 px-3 py-1 rounded-lg hover:bg-green-200 transition-colors">Refresh</button>
                            </div>
                        `;
                        statusEl.classList.remove('bg-gray-50', 'border-gray-200', 'bg-yellow-50', 'border-yellow-200');
                        statusEl.classList.add('bg-green-50', 'border-green-200');
                    }
                },
                (error) => {
                    let errorMessage = 'Gagal mengambil lokasi';
                    switch (error.code) {
                        case error.PERMISSION_DENIED:
                            errorMessage = 'Izin lokasi ditolak. Mohon aktifkan GPS.';
                            break;
                        case error.POSITION_UNAVAILABLE:
                            errorMessage = 'Informasi lokasi tidak tersedia.';
                            break;
                        case error.TIMEOUT:
                            errorMessage = 'Waktu pengambilan lokasi habis.';
                            break;
                    }
                    statusEl.innerHTML = `
                        <div class="flex items-center gap-3 text-red-600">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                            </svg>
                            <span>${errorMessage}</span>
                            <button onclick="getLocation()" class="ml-auto text-sm bg-red-100 px-3 py-1 rounded-lg hover:bg-red-200 transition-colors">Coba Lagi</button>
                        </div>
                    `;
                    statusEl.classList.remove('bg-gray-50', 'border-gray-200');
                    statusEl.classList.add('bg-red-50', 'border-red-200');
                },
                {
                    enableHighAccuracy: true,
                    timeout: 10000,
                    maximumAge: 0
                }
            );
        }

        // Get location on page load
        getLocation();

        // Camera functions
        async function openCameraModal(tipe) {
            currentTipe = tipe;
            capturedPhotoData = null;

            // Set modal title based on type
            const titleEl = document.getElementById('camera-title');
            const submitTextEl = document.getElementById('btn-submit-text');
            const izinWrapper = document.getElementById('izin-keterangan-wrapper');
            const izinLabel = document.getElementById('izin-label');
            const diluarLokasiWrapper = document.getElementById('diluar-lokasi-wrapper');

            // Reset diluar lokasi wrapper
            diluarLokasiWrapper.classList.add('hidden');
            document.getElementById('diluar-lokasi-input').value = '';

            if (tipe === 'hadir') {
                titleEl.textContent = 'Foto Absen Hadir';
                submitTextEl.textContent = 'Kirim Absen Hadir';
                izinWrapper.classList.add('hidden');

                // Show diluar lokasi input if outside location
                if (isOutsideLocation) {
                    diluarLokasiWrapper.classList.remove('hidden');
                    document.getElementById('diluar-lokasi-jarak').textContent = 'Jarak Anda: ' + Math.round(currentDistance) + ' meter dari kantor. Silakan masukkan alasan untuk absen dari luar lokasi.';
                }
            } else if (tipe === 'pulang') {
                titleEl.textContent = 'Foto Absen Pulang';
                submitTextEl.textContent = 'Kirim Absen Pulang';
                izinWrapper.classList.add('hidden');

                // Show diluar lokasi input if outside location
                if (isOutsideLocation) {
                    diluarLokasiWrapper.classList.remove('hidden');
                    document.getElementById('diluar-lokasi-jarak').textContent = 'Jarak Anda: ' + Math.round(currentDistance) + ' meter dari kantor. Silakan masukkan alasan untuk absen dari luar lokasi.';
                }
            } else if (tipe === 'izin') {
                @if($sudahHadir)
                    titleEl.textContent = 'Foto Izin Pulang Awal';
                    submitTextEl.textContent = 'Kirim Izin Pulang Awal';
                    izinLabel.textContent = 'Alasan Pulang Awal';
                @else
                    titleEl.textContent = 'Foto Izin Tidak Masuk';
                    submitTextEl.textContent = 'Kirim Izin';
                    izinLabel.textContent = 'Alasan Izin';
                @endif
                izinWrapper.classList.remove('hidden');
            }

            // Reset UI
            document.getElementById('camera-preview').classList.remove('hidden');
            document.getElementById('photo-preview').classList.add('hidden');
            document.getElementById('photo-result').classList.add('hidden');
            document.getElementById('btn-capture').classList.remove('hidden');
            document.getElementById('btn-retake').classList.add('hidden');
            document.getElementById('btn-submit').classList.add('hidden');

            // Show modal
            document.getElementById('camera-modal').classList.remove('hidden');

            // Start camera
            try {
                cameraStream = await navigator.mediaDevices.getUserMedia({
                    video: { facingMode: 'user', width: { ideal: 640 }, height: { ideal: 480 } },
                    audio: false
                });
                document.getElementById('camera-preview').srcObject = cameraStream;
            } catch (error) {
                alert('Tidak dapat mengakses kamera. Pastikan izin kamera telah diberikan.');
                closeCameraModal();
            }
        }

        function closeCameraModal() {
            // Stop camera stream
            if (cameraStream) {
                cameraStream.getTracks().forEach(track => track.stop());
                cameraStream = null;
            }

            document.getElementById('camera-modal').classList.add('hidden');
            currentTipe = null;
            capturedPhotoData = null;
        }

        function capturePhoto() {
            const video = document.getElementById('camera-preview');
            const canvas = document.getElementById('camera-canvas');
            const ctx = canvas.getContext('2d');

            // Set canvas size to video size
            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;

            // Draw video frame to canvas (mirrored)
            ctx.save();
            ctx.scale(-1, 1);
            ctx.drawImage(video, -canvas.width, 0);
            ctx.restore();

            // Add timestamp watermark
            const now = new Date();
            const timestamp = now.toLocaleString('id-ID', {
                day: '2-digit',
                month: 'short',
                year: 'numeric',
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit'
            }) + ' WIB';

            ctx.font = 'bold 16px Arial';
            ctx.fillStyle = 'rgba(0, 0, 0, 0.7)';
            ctx.fillRect(canvas.width - 200, canvas.height - 30, 195, 25);
            ctx.fillStyle = '#ffffff';
            ctx.textAlign = 'right';

            // Get image data
            capturedPhotoData = canvas.toDataURL('image/jpeg', 0.7);

            // Show captured photo
            document.getElementById('captured-photo').src = capturedPhotoData;
            document.getElementById('photo-result').classList.remove('hidden');

            // Hide video, show controls
            document.getElementById('camera-preview').classList.add('hidden');
            document.getElementById('btn-capture').classList.add('hidden');
            document.getElementById('btn-retake').classList.remove('hidden');
            document.getElementById('btn-submit').classList.remove('hidden');
        }

        function retakePhoto() {
            capturedPhotoData = null;

            // Show video again
            document.getElementById('camera-preview').classList.remove('hidden');
            document.getElementById('photo-result').classList.add('hidden');
            document.getElementById('btn-capture').classList.remove('hidden');
            document.getElementById('btn-retake').classList.add('hidden');
            document.getElementById('btn-submit').classList.add('hidden');
        }

        function submitWithPhoto() {
            if (!capturedPhotoData) {
                alert('Silakan ambil foto terlebih dahulu.');
                return;
            }

            if (!userLatitude || !userLongitude) {
                alert('Lokasi belum tersedia. Mohon tunggu atau aktifkan GPS.');
                return;
            }

            // Set form values
            document.getElementById('camera-tipe').value = currentTipe;
            document.getElementById('camera-lat').value = userLatitude;
            document.getElementById('camera-lng').value = userLongitude;
            document.getElementById('camera-foto').value = capturedPhotoData;

            // Get keterangan for izin
            if (currentTipe === 'izin') {
                const keterangan = document.getElementById('izin-keterangan-input').value;
                if (!keterangan.trim()) {
                    alert('Silakan masukkan alasan izin.');
                    return;
                }
                document.getElementById('camera-keterangan').value = keterangan;
            }

            // Get alasan for diluar lokasi (hadir/pulang)
            if ((currentTipe === 'hadir' || currentTipe === 'pulang') && isOutsideLocation) {
                const diluarLokasiAlasan = document.getElementById('diluar-lokasi-input').value;

                document.getElementById('camera-diluar-lokasi-alasan').value = diluarLokasiAlasan;
            }

            // Handle lembur hari libur
            if (isLemburLibur && currentTipe === 'hadir') {
                document.getElementById('camera-is-lembur').value = '1';
                document.getElementById('camera-lembur-keterangan').value = lemburKeteranganPrefilled;
                // Reset lembur libur flags
                isLemburLibur = false;
                lemburKeteranganPrefilled = '';
            }

            // Check for lembur if pulang (only for non-libur days)
            @if(!$liburOrNot)
            if (currentTipe === 'pulang') {
                const lemburMenit = checkLemburEligibility();
                if (lemburMenit > 0) {
                    // Show lembur confirmation modal
                    document.getElementById('lembur-menit').textContent = lemburMenit;
                    document.getElementById('lembur-modal').classList.remove('hidden');
                    return;
                }
            }
            @endif

            // Stop camera before submit
            if (cameraStream) {
                cameraStream.getTracks().forEach(track => track.stop());
            }

            // Submit form
            document.getElementById('camera-form').submit();
        }

        // Check if eligible for lembur (pulang 30+ minutes after scheduled time)
        function checkLemburEligibility() {
            @if($sudahHadir && !$sudahIzin && !$sudahPulang)
                @php
                    $user = auth()->user();
                    if ($user->is_shift && $sudahHadir && $sudahHadir->shift_number) {
                        $jamPulangSetting = (int) $sudahHadir->shift_number === 1
                            ? \Carbon\Carbon::parse($user->shift1_jam_keluar)
                            : \Carbon\Carbon::parse($user->shift2_jam_keluar);
                    } else {
                        $jamPulangSetting = $user->jam_keluar
                            ? \Carbon\Carbon::parse($user->jam_keluar)
                            : \Carbon\Carbon::createFromTime(20, 0);
                    }
                @endphp
                const jamPulang = new Date();
                    jamPulang.setHours({{ $jamPulangSetting->hour }}, {{ $jamPulangSetting->minute }}, 0);
                const now = new Date();
                const diffMs = now - jamPulang;
                    const diffMins = Math.floor(diffMs / 60000);
                // Return minutes if over 30 minutes, otherwise 0
                    return diffMins >= 30 ? diffMins : 0;
            @else
                return 0;
            @endif
        }

        // Show keterangan input for lembur
        function showLemburKeterangan() {
            document.getElementById('lembur-keterangan-wrapper').classList.remove('hidden');
            document.getElementById('btn-submit-lembur').classList.remove('hidden');
        }

        // Confirm lembur choice
        function confirmLembur(isLembur) {
            if (isLembur) {
                document.getElementById('camera-is-lembur').value = '1';
                document.getElementById('camera-lembur-keterangan').value =
                    document.getElementById('lembur-keterangan-input').value;
            } else {
                document.getElementById('camera-is-lembur').value = '0';
                document.getElementById('camera-lembur-keterangan').value = '';
            }

            // Hide lembur modal
            document.getElementById('lembur-modal').classList.add('hidden');

            // Stop camera before submit
            if (cameraStream) {
                cameraStream.getTracks().forEach(track => track.stop());
            }

            // Submit form
            document.getElementById('camera-form').submit();
        }

        // ==================== Lembur Hari Libur Functions ====================
        let lemburLiburType = 'hadir';

        function openLemburLiburModal(type) {
            lemburLiburType = type;
            document.getElementById('lembur-libur-modal').classList.remove('hidden');
            document.getElementById('lembur-libur-keterangan-input').value = '';
        }

        function closeLemburLiburModal() {
            document.getElementById('lembur-libur-modal').classList.add('hidden');
        }

        function confirmLemburLibur() {
            const keterangan = document.getElementById('lembur-libur-keterangan-input').value.trim();
            if (!keterangan) {
                alert('Mohon masukkan keterangan lembur');
                return;
            }

            // Set lembur keterangan for the form
            lemburKeteranganPrefilled = keterangan;
            isLemburLibur = true;

            // Close lembur libur modal
            closeLemburLiburModal();

            // Open camera modal for hadir
            openCameraModal(lemburLiburType);
        }

        // Variable to track if this is lembur hari libur
        let isLemburLibur = false;
        let lemburKeteranganPrefilled = '';

        // Update working hours every minute
        @if($sudahHadir && !$sudahIzin && !$sudahPulang)
            let checkInTime = '{{ $sudahHadir->jam_masuk->format("H:i:s") }}';
            setInterval(updateWorkingHours, 60000); // Update every minute
                updateWorkingHours(); // Initial update
        @endif

        function updateWorkingHours() {
            if (typeof checkInTime === 'undefined') return;

            const now = new Date();
            const checkIn = new Date();
            const [hours, minutes, seconds] = checkInTime.split(':');
            checkIn.setHours(parseInt(hours), parseInt(minutes), parseInt(seconds));

            const diffMs = now - checkIn;
            const diffMins = Math.floor(diffMs / 60000);
            const hoursWorked = Math.floor(diffMins / 60);
            const minsWorked = diffMins % 60;

            const workingHoursEl = document.getElementById('working-hours');
            if (workingHoursEl) {
                workingHoursEl.textContent = hoursWorked + ' jam ' + minsWorked + ' menit';
            }
        }
    </script>
</x-app-layout>
