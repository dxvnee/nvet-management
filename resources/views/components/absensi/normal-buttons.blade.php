{{-- Normal Day Buttons Section Component --}}
@props([
    'sudahHadir' => null,
    'sudahPulang' => null,
    'sudahIzin' => null,
    'liburOrNot' => false,
    'isInactive' => false,
    'jamPulangText' => '20:00',
])

@php
    // Determine izin button label
    if ($liburOrNot) {
        $izinLabel = 'Hari Libur';
    } elseif ($sudahIzin && $sudahHadir) {
        $izinLabel = 'Sudah Izin Pulang';
    } elseif ($sudahIzin) {
        $izinLabel = 'Sedang Izin';
    } elseif ($sudahPulang) {
        $izinLabel = 'Sudah Pulang';
    } elseif ($sudahHadir) {
        $izinLabel = 'Izin Pulang Awal';
    } else {
        $izinLabel = 'Izin Tidak Masuk';
    }

    // Determine pulang button label
    if ($liburOrNot) {
        $pulangLabel = 'Hari Libur';
    } elseif ($sudahPulang) {
        $pulangLabel = 'Sudah Pulang';
    } elseif ($sudahIzin) {
        $pulangLabel = 'Sudah Izin Pulang';
    } elseif (!$sudahHadir) {
        $pulangLabel = 'Hadir Dulu';
    } else {
        $pulangLabel = "Absen Pulang (≥{$jamPulangText})";
    }

    // Determine hadir button label
    if ($liburOrNot) {
        $hadirLabel = 'Hari Libur';
    } elseif ($sudahHadir) {
        $hadirLabel = 'Sudah Hadir';
    } elseif ($sudahIzin) {
        $hadirLabel = 'Sedang Izin';
    } else {
        $hadirLabel = 'Absen Hadir';
    }
@endphp

<div class="grid grid-cols-1 md:grid-cols-3 gap-4">
    {{-- Tombol Hadir --}}
    <x-absensi.absen-button type="hadir" onclick="openCameraModal('hadir')" :disabled="$sudahHadir || $sudahIzin || $liburOrNot || $isInactive" :label="$hadirLabel" />

    {{-- Tombol Izin --}}
    <x-absensi.absen-button type="{{ $sudahHadir ? 'lembur-masuk' : 'izin' }}" onclick="openCameraModal('izin')"
        :disabled="($sudahIzin && !$sudahHadir) || $sudahPulang || $liburOrNot || $isInactive" :label="$izinLabel" />

    {{-- Tombol Pulang --}}
    <x-absensi.absen-button type="pulang" onclick="openCameraModal('pulang')" :disabled="$sudahPulang || !$sudahHadir || $sudahIzin || $liburOrNot" :label="$pulangLabel" />
</div>
