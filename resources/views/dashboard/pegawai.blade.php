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
                    <x-icons.clock class="h-6 w-6 text-white" />
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
                    <x-icons.check-circle class="h-5 w-5 lg:h-6 lg:w-6 text-white" />
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
                    <x-icons.x-circle class="h-5 w-5 lg:h-6 lg:w-6 text-white" />
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
                    <x-icons.clock class="h-5 w-5 lg:h-6 lg:w-6 text-white" />
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
                    <x-icons.arrow-right-on-rectangle class="h-5 w-5 lg:h-6 lg:w-6 text-white" />
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
                    <x-icons.calendar class="h-5 w-5 text-white" />
                </x-slot>
            </x-dashboard.section-header>

            <div class="space-y-3">
                @forelse($riwayatAbsensi as $absen)
                    <x-dashboard.riwayat-item :absen="$absen" />
                @empty
                    <x-dashboard.empty-state title="Belum Ada Riwayat" subtitle="Belum ada data absensi">
                        <x-icons.calendar class="w-8 h-8 text-gray-400" />
                    </x-dashboard.empty-state>
                @endforelse
            </div>
        </x-card-content>

        {{-- Quick Actions Pegawai --}}
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <x-dashboard.quick-action
                href="{{ route('absen.create', ['tanggal' => now()->toDateString(), 'user' => $user->id]) }}"
                title="Absen Sekarang" subtitle="Catat kehadiran">
                <x-slot name="icon">
                    <x-icons.check-circle class="h-6 w-6 text-white" />
                </x-slot>
            </x-dashboard.quick-action>

            <x-dashboard.quick-action href="{{ route('absen.riwayat') }}" title="Riwayat Absensi"
                subtitle="Lihat semua absensi" gradient="from-blue-500 to-indigo-600"
                hoverBorder="hover:border-blue-300" hoverText="group-hover:text-blue-600">
                <x-slot name="icon">
                    <x-icons.calendar class="h-6 w-6 text-white" />
                </x-slot>
            </x-dashboard.quick-action>

            <x-dashboard.quick-action href="{{ route('lembur.index') }}" title="Lembur" subtitle="Lihat data lembur"
                gradient="from-amber-500 to-orange-500" hoverBorder="hover:border-amber-300"
                hoverText="group-hover:text-amber-600">
                <x-slot name="icon">
                    <x-icons.clock class="h-6 w-6 text-white" />
                </x-slot>
            </x-dashboard.quick-action>

            <x-dashboard.quick-action href="{{ route('profile.show') }}" title="Profil Saya" subtitle="Edit profil"
                gradient="from-purple-500 to-violet-600" hoverBorder="hover:border-purple-300"
                hoverText="group-hover:text-purple-600">
                <x-slot name="icon">
                    <x-icons.user class="h-6 w-6 text-white" />
                </x-slot>
            </x-dashboard.quick-action>
        </div>
    </div>
</x-app-layout>
