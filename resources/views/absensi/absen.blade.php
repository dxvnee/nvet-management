<x-app-layout>
    <x-slot name="header">Absen</x-slot>
    <x-slot name="subtle">Halaman absensi karyawan</x-slot>

    <div class="space-y-6">
        {{-- Welcome Section --}}
        <x-absensi.welcome-section title="Absensi Kehadiran" />

        {{-- Status Absen Hari Ini --}}
        <x-ui.section-card class="border border-gray-100 animate-slide-up-delay-1">
            <x-slot:icon>
                <x-icons.check-circle class="h-6 w-6 text-white" />
            </x-slot:icon>
            <x-slot:title>Status Absensi Hari Ini</x-slot:title>
            <x-slot:subtitle>Pantau kehadiran Anda</x-slot:subtitle>

            {{-- Status Cards Based on Condition --}}
            @if (isset($isInactive) && $isInactive)
                {{-- Inactive Status --}}
                <x-absensi.status-card type="inactive">
                    @if ($inactiveEndDate)
                        Anda sedang inactive hingga {{ $inactiveEndDate->format('d M Y') }}.
                    @else
                        Anda sedang inactive secara permanen.
                    @endif
                    @if ($inactiveReason)
                        <p class="text-sm text-gray-700 mt-2 p-3 bg-white/70 rounded-lg border border-red-200">
                            <strong>Alasan:</strong> {{ $inactiveReason }}
                        </p>
                    @endif
                </x-absensi.status-card>

                <x-ui.info-box color="warning" class="mb-5">
                    <x-slot:title>Informasi</x-slot:title>
                    Anda tidak dapat melakukan absen saat status Anda inactive. Silakan hubungi admin untuk informasi
                    lebih lanjut.
                </x-ui.info-box>
            @elseif($liburOrNot)
                {{-- Holiday Status --}}
                <x-absensi.status-card type="libur" :namaHariLibur="$namaHariLibur ?? null">
                    @if ($sudahHadir)
                        <span class="inline-flex items-center gap-1">
                            <x-icons.clock class="w-4 h-4" />
                            Anda sedang lembur hari libur. Masuk: {{ $sudahHadir->jam_masuk->format('H:i') }}
                        </span>
                    @else
                        Hari ini adalah hari
                        libur{{ isset($namaHariLibur) && $namaHariLibur ? ' (' . $namaHariLibur . ')' : '' }}. Klik
                        tombol di bawah jika ingin lembur.
                    @endif
                </x-absensi.status-card>

                {{-- Location Status --}}
                <x-absensi.location-status />

                {{-- Lembur Holiday Buttons --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 py-2">
                    <x-absensi.absen-button type="lembur-masuk" onclick="openLemburLiburModal('hadir')"
                        :disabled="$sudahHadir ? true : false" :label="$sudahHadir ? 'Sudah Masuk Lembur' : 'Masuk Lembur Hari Libur'" />

                    <x-absensi.absen-button type="pulang" onclick="openCameraModal('pulang')" :disabled="!$sudahHadir || $sudahPulang"
                        :label="$sudahPulang
                            ? 'Sudah Pulang'
                            : (!$sudahHadir
                                ? 'Masuk Lembur Dulu'
                                : 'Pulang Lembur')" />
                </div>
            @elseif($sudahIzin)
                {{-- Izin Status --}}
                <x-absensi.status-card type="izin">
                    <p class="text-sm text-amber-600 mt-1 flex items-center gap-2">
                        <x-icons.calendar class="w-4 h-4" />
                        Tanggal: {{ $sudahIzin->tanggal->format('d M Y') }}
                    </p>
                    @if ($sudahIzin->izin_keterangan)
                        <div class="mt-3 p-3 bg-amber-100 rounded-xl">
                            <p class="text-sm text-amber-800 italic flex items-start gap-2">
                                <x-icons.chat-bubble class="w-4 h-4 mt-0.5 flex-shrink-0" />
                                "{{ $sudahIzin->izin_keterangan }}"
                            </p>
                        </div>
                    @endif
                </x-absensi.status-card>
            @else
                {{-- Normal Status Cards --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                    <x-absensi.time-card type="masuk" :absen="$sudahHadir" />

                    <x-absensi.time-card type="pulang" :absen="$sudahHadir" :sudahPulang="$sudahPulang" />
                </div>
            @endif

            {{-- Special Day Info --}}
            @if (isset($hariKhususInfo) && $hariKhususInfo)
                <x-absensi.special-day-info :hariKhusus="$hariKhususInfo" />
            @endif

            {{-- Working Hours Info --}}
            @if (!$liburOrNot)
                <x-absensi.working-hours-info :user="auth()->user()" :sudahHadir="$sudahHadir" />
            @endif

            {{-- Total Working Hours Today --}}
            @if ($sudahHadir && !$sudahIzin && !$liburOrNot)
                <x-absensi.total-working-hours :totalJamKerjaText="$totalJamKerjaText" />
            @endif

            {{-- Location Status & Absen Buttons (not shown on holiday) --}}
            @if (!$liburOrNot && !$isInactive && !$sudahIzin)
                {{-- Location Status --}}
                <x-absensi.location-status />

                {{-- Absen Buttons --}}
                @php
                    $user = auth()->user();
                    if ($user->is_shift && $sudahHadir && $sudahHadir->shift_number) {
                        $jamPulangText =
                            (int) $sudahHadir->shift_number === 1
                                ? \Carbon\Carbon::parse($user->shift1_jam_keluar)->format('H:i')
                                : \Carbon\Carbon::parse($user->shift2_jam_keluar)->format('H:i');
                    } else {
                        $jamPulangText = $user->jam_keluar
                            ? \Carbon\Carbon::parse($user->jam_keluar)->format('H:i')
                            : '20:00';
                    }
                @endphp

                <x-absensi.normal-buttons :sudahHadir="$sudahHadir" :sudahPulang="$sudahPulang" :sudahIzin="$sudahIzin" :liburOrNot="$liburOrNot"
                    :isInactive="$isInactive ?? false" :jamPulangText="$jamPulangText" />
            @endif
        </x-ui.section-card>
    </div>

    {{-- Camera Modal --}}
    <x-absensi.camera-modal :storeRoute="route('absen.store')" />

    {{-- Lembur Confirmation Modal --}}
    <x-absensi.lembur-modal />

    {{-- Lembur Holiday Modal --}}
    <x-absensi.lembur-libur-modal />

    {{-- Absensi Scripts --}}
    @php
        $user = auth()->user();
        if ($user->is_shift && $sudahHadir && $sudahHadir->shift_number) {
            $jamPulangSetting =
                (int) $sudahHadir->shift_number === 1
                    ? \Carbon\Carbon::parse($user->shift1_jam_keluar)
                    : \Carbon\Carbon::parse($user->shift2_jam_keluar);
        } else {
            $jamPulangSetting = $user->jam_keluar
                ? \Carbon\Carbon::parse($user->jam_keluar)
                : \Carbon\Carbon::createFromTime(20, 0);
        }
    @endphp

    <x-absensi.absen-script :officeLatitude="$officeLatitude" :officeLongitude="$officeLongitude" :allowedRadius="$allowedRadius" :sudahHadir="$sudahHadir"
        :sudahIzin="$sudahIzin" :sudahPulang="$sudahPulang" :liburOrNot="$liburOrNot" :jamPulangHour="$jamPulangSetting->hour" :jamPulangMinute="$jamPulangSetting->minute" />
</x-app-layout>
