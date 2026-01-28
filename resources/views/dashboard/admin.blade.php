<x-app-layout>
    <x-slot name="header">Dashboard Admin</x-slot>
    <x-slot name="subtle">Selamat datang kembali, {{ $user->name }}!</x-slot>

    <div class="space-y-6">
        {{-- Welcome Section Admin --}}
        <x-dashboard.welcome-header variant="admin" />

        {{-- Stats Cards Admin --}}
        <div class="grid grid-cols-2 lg:grid-cols-5 gap-4 lg:gap-6">
            {{-- Total Pegawai --}}
            <x-dashboard.stat-card title="Total Pegawai" :value="$totalPegawai" delay="1">
                <x-slot name="icon">
                    <svg class="h-5 w-5 lg:h-6 lg:w-6 text-white" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z">
                        </path>
                    </svg>
                </x-slot>
                <x-slot name="footer">
                    <div class="flex flex-wrap gap-1">
                        @foreach ($pegawaiByJabatan as $jabatan => $total)
                            @php
                                $variant = match ($jabatan) {
                                    'Dokter' => 'purple',
                                    'Paramedis' => 'info',
                                    'Tech' => 'green',
                                    'FO' => 'orange',
                                    default => 'default',
                                };
                            @endphp
                            <x-dashboard.badge :variant="$variant">{{ $jabatan }}:
                                {{ $total }}</x-dashboard.badge>
                        @endforeach
                    </div>
                </x-slot>
            </x-dashboard.stat-card>

            {{-- Absensi Hari Ini --}}
            <x-dashboard.stat-card title="Hadir Hari Ini" :value="$absensiHariIni" gradient="from-emerald-500 to-green-600"
                hoverBorder="hover:border-green-200"
                valueColor="bg-gradient-to-r from-emerald-500 to-green-600 bg-clip-text text-transparent"
                delay="2">
                <x-slot name="icon">
                    <svg class="h-5 w-5 lg:h-6 lg:w-6 text-white" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </x-slot>
                <x-slot name="footer">
                    <div class="flex flex-wrap gap-2">
                        <x-dashboard.badge variant="success">
                            <x-slot name="icon">
                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                        clip-rule="evenodd" />
                                </svg>
                            </x-slot>
                            {{ $tepatWaktuHariIni }}
                        </x-dashboard.badge>
                        <x-dashboard.badge variant="danger">
                            <x-slot name="icon">
                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                        clip-rule="evenodd" />
                                </svg>
                            </x-slot>
                            {{ $telatHariIni }}
                        </x-dashboard.badge>
                    </div>
                </x-slot>
            </x-dashboard.stat-card>

            {{-- Total Gaji Bulan Ini --}}
            <x-dashboard.stat-card title="Gaji Bulan Ini" :value="'Rp ' . number_format($totalGajiBulanIni, 0, ',', '.')" gradient="from-blue-500 to-indigo-600"
                hoverBorder="hover:border-blue-200" valueColor="text-gray-800" delay="3" :formatValue="false">
                <x-slot name="icon">
                    <svg class="h-5 w-5 lg:h-6 lg:w-6 text-white" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                        </path>
                    </svg>
                </x-slot>
                <x-slot name="footer">
                    @if ($penggajianDraft > 0)
                        <x-dashboard.badge variant="warning">
                            <x-slot name="icon">
                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                        clip-rule="evenodd" />
                                </svg>
                            </x-slot>
                            {{ $penggajianDraft }} Draft
                        </x-dashboard.badge>
                    @endif
                </x-slot>
            </x-dashboard.stat-card>

            {{-- Belum Absen --}}
            <x-dashboard.stat-card title="Belum Absen" :value="count($belumAbsen)" gradient="from-amber-500 to-orange-500"
                hoverBorder="hover:border-orange-200" :valueColor="count($belumAbsen) > 0 ? 'text-orange-500' : 'text-green-500'" delay="4" :pulse="count($belumAbsen) > 0">
                <x-slot name="icon">
                    <svg class="h-5 w-5 lg:h-6 lg:w-6 text-white" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </x-slot>
                <x-slot name="footer">
                    @if (count($belumAbsen) > 0)
                        <div class="flex -space-x-2">
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
                        <p class="text-xs text-green-500 font-medium">✓ Semua sudah absen</p>
                    @endif
                </x-slot>
            </x-dashboard.stat-card>

            {{-- Lupa Pulang Bulan Ini --}}
            <x-dashboard.stat-card title="Lupa Pulang" :value="$totalLupaPulangBulanIni" gradient="from-rose-500 to-pink-600"
                hoverBorder="hover:border-rose-200" :valueColor="$totalLupaPulangBulanIni > 3 ? 'text-rose-500' : 'text-gray-800'" delay="4">
                <x-slot name="icon">
                    <svg class="h-5 w-5 lg:h-6 lg:w-6 text-white" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                        </path>
                    </svg>
                </x-slot>
                <x-slot name="footer">
                    @if ($totalLupaPulangBulanIni > 3)
                        <x-dashboard.badge variant="danger">⚠️ Potong Gaji</x-dashboard.badge>
                    @elseif($totalLupaPulangBulanIni > 0)
                        <x-dashboard.badge variant="warning">⚡ Perhatian</x-dashboard.badge>
                    @else
                        <x-dashboard.badge variant="success">✓ Baik</x-dashboard.badge>
                    @endif
                </x-slot>
            </x-dashboard.stat-card>
        </div>

        {{-- Grafik & Detail Section --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            {{-- Grafik Absensi 7 Hari --}}
            <div
                class="lg:col-span-2 bg-white rounded-2xl shadow-lg p-6 border border-gray-100 animate-slide-up-delay-5">
                <x-dashboard.section-header title="Statistik Absensi" subtitle="7 hari terakhir">
                    <x-slot name="icon">
                        <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z">
                            </path>
                        </svg>
                    </x-slot>
                    <x-slot name="extra">
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
                    </x-slot>
                </x-dashboard.section-header>

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
                <x-dashboard.section-header title="Top Keterlambatan" subtitle="Bulan ini"
                    gradient="from-rose-500 to-red-600">
                    <x-slot name="icon">
                        <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </x-slot>
                </x-dashboard.section-header>

                @if (count($topTelat) > 0)
                    <div class="space-y-3">
                        @foreach ($topTelat as $index => $telat)
                            <x-dashboard.top-telat-item :index="$index" :telat="$telat" />
                        @endforeach
                    </div>
                @else
                    <x-dashboard.empty-state title="Luar Biasa! 🎉" subtitle="Tidak ada keterlambatan bulan ini"
                        gradient="from-emerald-100 to-green-100">
                        <svg class="w-10 h-10 text-emerald-500" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                            </path>
                        </svg>
                    </x-dashboard.empty-state>
                @endif
            </div>
        </div>

        {{-- Aktivitas Terbaru --}}
        <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-100 animate-slide-up-delay-5">
            <x-dashboard.section-header title="Aktivitas Terbaru" subtitle="Absensi hari ini" :linkHref="route('absen.detailHari', $today)">
                <x-slot name="icon">
                    <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </x-slot>
            </x-dashboard.section-header>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                @forelse($aktivitasTerbaru as $aktivitas)
                    <x-dashboard.activity-item :user="$aktivitas->user" :aktivitas="$aktivitas" />
                @empty
                    <div class="col-span-2">
                        <x-dashboard.empty-state title="Belum Ada Aktivitas"
                            subtitle="Belum ada aktivitas absensi hari ini">
                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </x-dashboard.empty-state>
                    </div>
                @endforelse
            </div>
        </div>

        {{-- Quick Actions Admin --}}
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 py-6">
            <x-dashboard.quick-action href="{{ route('users.index') }}" title="Kelola Pegawai"
                subtitle="Tambah, edit, hapus">
                <x-slot name="icon">
                    <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z">
                        </path>
                    </svg>
                </x-slot>
            </x-dashboard.quick-action>

            <x-dashboard.quick-action href="{{ route('penggajian.index') }}" title="Penggajian"
                subtitle="Kelola gaji pegawai" gradient="from-emerald-500 to-green-600"
                hoverBorder="hover:border-emerald-300" hoverText="group-hover:text-emerald-600">
                <x-slot name="icon">
                    <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z">
                        </path>
                    </svg>
                </x-slot>
            </x-dashboard.quick-action>

            <x-dashboard.quick-action href="{{ route('absen.kalender') }}" title="Riwayat Absensi"
                subtitle="Lihat semua absensi" gradient="from-blue-500 to-indigo-600"
                hoverBorder="hover:border-blue-300" hoverText="group-hover:text-blue-600">
                <x-slot name="icon">
                    <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                        </path>
                    </svg>
                </x-slot>
            </x-dashboard.quick-action>

            <x-dashboard.quick-action href="{{ route('users.create') }}" title="Tambah Pegawai"
                subtitle="Daftarkan pegawai baru" gradient="from-purple-500 to-violet-600"
                hoverBorder="hover:border-purple-300" hoverText="group-hover:text-purple-600">
                <x-slot name="icon">
                    <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z">
                        </path>
                    </svg>
                </x-slot>
            </x-dashboard.quick-action>
        </div>
    </div>
</x-app-layout>
