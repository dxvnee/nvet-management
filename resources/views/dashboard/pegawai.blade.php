<x-app-layout>
    <x-slot name="header">Dashboard</x-slot>
    <x-slot name="subtle">Selamat datang kembali, {{ $user->name }}!</x-slot>

    <div class="space-y-6">
        {{-- Welcome Section Pegawai --}}
        <x-dashboard.welcome-header variant="pegawai" :user="$user" :showAvatar="true" />

        {{-- Status Absensi Hari Ini --}}
        <x-card-content>
            <x-dashboard.section-header title="Status Absensi Hari Ini" :subtitle="now()->locale('id')->isoFormat('dddd, D MMMM Y')">
                <x-slot name="icon">
                    <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </x-slot>
            </x-dashboard.section-header>

            {{-- Status Absensi Component --}}
            <x-dashboard.absensi-status :absensi="$absensiToday ?? null" />
        </x-card-content>

        {{-- Stats Ringkasan Bulan Ini --}}
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 lg:gap-6">
            {{-- Total Hadir --}}
            <x-dashboard.stat-card title="Total Hadir" :value="$totalHadir" gradient="from-emerald-500 to-green-600"
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
                    <p class="text-xs text-gray-500">Bulan ini</p>
                </x-slot>
            </x-dashboard.stat-card>

            {{-- Total Tidak Hadir --}}
            <x-dashboard.stat-card title="Tidak Hadir" :value="$totalTidakHadir" gradient="from-rose-500 to-red-600"
                hoverBorder="hover:border-rose-200"
                valueColor="bg-gradient-to-r from-rose-500 to-red-600 bg-clip-text text-transparent" delay="3">
                <x-slot name="icon">
                    <svg class="h-5 w-5 lg:h-6 lg:w-6 text-white" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </x-slot>
                <x-slot name="footer">
                    <p class="text-xs text-gray-500">Bulan ini</p>
                </x-slot>
            </x-dashboard.stat-card>

            {{-- Total Menit Telat --}}
            <x-dashboard.stat-card title="Menit Telat" :value="$totalMenitTelat" gradient="from-amber-500 to-orange-500"
                hoverBorder="hover:border-amber-200"
                valueColor="bg-gradient-to-r from-amber-500 to-orange-500 bg-clip-text text-transparent" delay="4">
                <x-slot name="icon">
                    <svg class="h-5 w-5 lg:h-6 lg:w-6 text-white" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </x-slot>
                <x-slot name="footer">
                    @if ($totalMenitTelat > 60)
                        <x-dashboard.badge variant="danger">⚠️ Cukup tinggi</x-dashboard.badge>
                    @elseif($totalMenitTelat > 30)
                        <x-dashboard.badge variant="warning">⚡ Perhatian</x-dashboard.badge>
                    @else
                        <x-dashboard.badge variant="success">✓ Baik</x-dashboard.badge>
                    @endif
                </x-slot>
            </x-dashboard.stat-card>

            {{-- Lupa Pulang --}}
            <x-dashboard.stat-card title="Lupa Pulang" :value="$totalLupaPulang" gradient="from-rose-500 to-pink-600"
                hoverBorder="hover:border-rose-200" :valueColor="$totalLupaPulang > 3 ? 'text-rose-500' : 'text-gray-800'" delay="4">
                <x-slot name="icon">
                    <svg class="h-5 w-5 lg:h-6 lg:w-6 text-white" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                        </path>
                    </svg>
                </x-slot>
                <x-slot name="footer">
                    @if ($totalLupaPulang > 3)
                        <x-dashboard.badge variant="danger">⚠️ Potong Gaji</x-dashboard.badge>
                    @elseif($totalLupaPulang > 0)
                        <x-dashboard.badge variant="warning">⚡ Perhatian</x-dashboard.badge>
                    @else
                        <x-dashboard.badge variant="success">✓ Baik</x-dashboard.badge>
                    @endif
                </x-slot>
            </x-dashboard.stat-card>
        </div>

        {{-- Riwayat Absensi 7 Hari --}}
        <x-card-content>
            <x-dashboard.section-header title="Riwayat Absensi" subtitle="7 hari terakhir" :linkHref="route('absen.riwayat')">
                <x-slot name="icon">
                    <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                        </path>
                    </svg>
                </x-slot>
            </x-dashboard.section-header>

            <div class="space-y-3">
                @forelse($riwayatAbsensi as $absen)
                    <x-dashboard.riwayat-item :absen="$absen" />
                @empty
                    <x-dashboard.empty-state title="Belum Ada Riwayat" subtitle="Belum ada data absensi">
                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                            </path>
                        </svg>
                    </x-dashboard.empty-state>
                @endforelse
            </div>
        </x-card-content>

        {{-- Quick Actions Pegawai --}}
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <x-dashboard.quick-action href="{{ route('absen.create', ['tanggal' => now()->toDateString(), 'user' => $user->id]) }}" title="Absen Sekarang"
                subtitle="Catat kehadiran">
                <x-slot name="icon">
                    <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </x-slot>
            </x-dashboard.quick-action>

            <x-dashboard.quick-action href="{{ route('absen.riwayat') }}" title="Riwayat Absensi"
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

            <x-dashboard.quick-action href="{{ route('lembur.index') }}" title="Lembur" subtitle="Lihat data lembur"
                gradient="from-amber-500 to-orange-500" hoverBorder="hover:border-amber-300"
                hoverText="group-hover:text-amber-600">
                <x-slot name="icon">
                    <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </x-slot>
            </x-dashboard.quick-action>

            <x-dashboard.quick-action href="{{ route('profile.show') }}" title="Profil Saya" subtitle="Edit profil"
                gradient="from-purple-500 to-violet-600" hoverBorder="hover:border-purple-300"
                hoverText="group-hover:text-purple-600">
                <x-slot name="icon">
                    <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                </x-slot>
            </x-dashboard.quick-action>
        </div>
    </div>
</x-app-layout>
