{{-- Holiday Status Card Component --}}
@props([
    'namaHariLibur' => null,
    'sudahHadir' => null,
    'sudahPulang' => null,
])

{{-- Holiday Status Card --}}
<x-absensi.status-card type="libur" :namaHariLibur="$namaHariLibur">
    @if ($sudahHadir)
        <span class="inline-flex items-center gap-1">
            <x-icons.clock class="w-4 h-4" />
            Anda sedang lembur hari libur. Masuk: {{ $sudahHadir->jam_masuk->format('H:i') }}
        </span>
    @else
        Hari ini adalah hari libur{{ $namaHariLibur ? ' (' . $namaHariLibur . ')' : '' }}. Klik tombol di bawah jika
        ingin lembur.
    @endif
</x-absensi.status-card>

{{-- Location Status --}}
<x-absensi.location-status />

{{-- Lembur Buttons --}}
<div class="grid grid-cols-1 md:grid-cols-2 gap-4 py-2">
    <x-absensi.absen-button type="lembur-masuk" onclick="openLemburLiburModal('hadir')" :disabled="$sudahHadir ? true : false"
        :label="$sudahHadir ? 'Sudah Masuk Lembur' : 'Masuk Lembur Hari Libur'" />

    <x-absensi.absen-button type="pulang" onclick="openCameraModal('pulang')" :disabled="!$sudahHadir || $sudahPulang" :label="$sudahPulang ? 'Sudah Pulang' : (!$sudahHadir ? 'Masuk Lembur Dulu' : 'Pulang Lembur')" />
</div>
