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
                    <x-icons.users-group class="h-5 w-5 lg:h-6 lg:w-6 text-white" />
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
                    <x-icons.check-circle class="h-5 w-5 lg:h-6 lg:w-6 text-white" />
                </x-slot>
                <x-slot name="footer">
                    <div class="flex flex-wrap gap-2">
                        <x-dashboard.badge variant="success">
                            <x-slot name="icon">
                                <x-icons.check-circle-solid class="w-3 h-3" />
                            </x-slot>
                            {{ $tepatWaktuHariIni }}
                        </x-dashboard.badge>
                        <x-dashboard.badge variant="danger">
                            <x-slot name="icon">
                                <x-icons.x-circle-solid class="w-3 h-3" />
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
                    <x-icons.currency class="h-5 w-5 lg:h-6 lg:w-6 text-white" />
                </x-slot>
                <x-slot name="footer">
                    @if ($penggajianDraft > 0)
                        <x-dashboard.badge variant="warning">
                            <x-slot name="icon">
                                <x-icons.exclamation-circle-solid class="w-3 h-3" />
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
                    <x-icons.exclamation-circle class="h-5 w-5 lg:h-6 lg:w-6 text-white" />
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
                    <x-icons.arrow-right-on-rectangle class="h-5 w-5 lg:h-6 lg:w-6 text-white" />
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
                        <x-icons.chart-bar class="h-5 w-5 text-white" />
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
                        <x-icons.clock class="h-5 w-5 text-white" />
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
                        <x-icons.check class="w-10 h-10 text-emerald-500" />
                    </x-dashboard.empty-state>
                @endif
            </div>
        </div>

        {{-- Aktivitas Terbaru --}}
        <x-card-content>
            <x-dashboard.section-header title="Aktivitas Terbaru" subtitle="Absensi hari ini" :linkHref="route('absen.detailHari', $today)">
                <x-slot name="icon">
                    <x-icons.clock class="h-5 w-5 text-white" />
                </x-slot>
            </x-dashboard.section-header>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                @forelse($aktivitasTerbaru as $aktivitas)
                    <x-dashboard.activity-item :user="$aktivitas->user" :aktivitas="$aktivitas" />
                @empty
                    <div class="col-span-2">
                        <x-dashboard.empty-state title="Belum Ada Aktivitas"
                            subtitle="Belum ada aktivitas absensi hari ini">
                            <x-icons.clock class="w-8 h-8 text-gray-400" />
                        </x-dashboard.empty-state>
                    </div>
                @endforelse
            </div>
        </x-card-conte>

        {{-- Quick Actions Admin --}}
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <x-dashboard.quick-action href="{{ route('users.index') }}" title="Kelola Pegawai"
                subtitle="Tambah, edit, hapus">
                <x-slot name="icon">
                    <x-icons.users class="h-6 w-6 text-white" />
                </x-slot>
            </x-dashboard.quick-action>

            <x-dashboard.quick-action href="{{ route('penggajian.index') }}" title="Penggajian"
                subtitle="Kelola gaji pegawai" gradient="from-emerald-500 to-green-600"
                hoverBorder="hover:border-emerald-300" hoverText="group-hover:text-emerald-600">
                <x-slot name="icon">
                    <x-icons.wallet class="h-6 w-6 text-white" />
                </x-slot>
            </x-dashboard.quick-action>

            <x-dashboard.quick-action href="{{ route('absen.kalender') }}" title="Riwayat Absensi"
                subtitle="Lihat semua absensi" gradient="from-blue-500 to-indigo-600"
                hoverBorder="hover:border-blue-300" hoverText="group-hover:text-blue-600">
                <x-slot name="icon">
                    <x-icons.calendar class="h-6 w-6 text-white" />
                </x-slot>
            </x-dashboard.quick-action>

            <x-dashboard.quick-action href="{{ route('users.create') }}" title="Tambah Pegawai"
                subtitle="Daftarkan pegawai baru" gradient="from-purple-500 to-violet-600"
                hoverBorder="hover:border-purple-300" hoverText="group-hover:text-purple-600">
                <x-slot name="icon">
                    <x-icons.user-plus class="h-6 w-6 text-white" />
                </x-slot>
            </x-dashboard.quick-action>
        </div>
    </div>
</x-app-layout>
