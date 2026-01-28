@props([
    'absensi' => null,
])

@if (isset($absensi) && ($absensi->jam_masuk != null || $absensi->izin != false || $absensi->libur != false))
    @if ($absensi->libur)
        {{-- Status Libur --}}
        <x-dashboard.absensi-status-libur :absensi="$absensi" />
    @elseif($absensi->izin)
        {{-- Status Izin --}}
        <x-dashboard.absensi-status-izin :absensi="$absensi" />
    @else
        {{-- Status Absen Normal --}}
        <x-dashboard.absensi-status-normal :absensi="$absensi" />
    @endif
@else
    {{-- Belum Absen --}}
    <x-dashboard.absensi-status-belum />
@endif
