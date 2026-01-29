{{-- Absensi Working Hours Info Component --}}
@props(['user', 'totalKerja' => null, 'shiftNumber' => null])

@php
    $isShift = $user->is_shift && $user->shift_partner_id;

    if ($isShift) {
        $jamMasuk1 = $user->shift1_jam_masuk ? \Carbon\Carbon::parse($user->shift1_jam_masuk)->format('H:i') : '08:00';
        $jamKeluar1 = $user->shift1_jam_keluar
            ? \Carbon\Carbon::parse($user->shift1_jam_keluar)->format('H:i')
            : '14:00';
        $jamMasuk2 = $user->shift2_jam_masuk ? \Carbon\Carbon::parse($user->shift2_jam_masuk)->format('H:i') : '14:00';
        $jamKeluar2 = $user->shift2_jam_keluar
            ? \Carbon\Carbon::parse($user->shift2_jam_keluar)->format('H:i')
            : '20:00';
        $partner = $user->shiftPartner;
        $partnerName = $partner ? $partner->name : 'Tidak ada';
    } else {
        $jamMasuk = $user->jam_masuk ? \Carbon\Carbon::parse($user->jam_masuk)->format('H:i') : '09:00';
        $jamKeluar = $user->jam_keluar ? \Carbon\Carbon::parse($user->jam_keluar)->format('H:i') : '20:00';
    }
@endphp

<x-ui.info-box type="info">
    <x-slot:icon>
        <x-icons.information-circle class="h-5 w-5" />
    </x-slot:icon>

    @if ($isShift)
        <div class="flex items-center gap-2 flex-wrap mb-1">
            <span
                class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-bold bg-blue-100 text-blue-800 shadow-sm">
                <x-icons.calendar class="w-3 h-3 mr-1" />
                SHIFT
            </span>
        </div>
        <p class="text-sm font-medium">
            Shift 1: {{ $jamMasuk1 }} - {{ $jamKeluar1 }} |
            Shift 2: {{ $jamMasuk2 }} - {{ $jamKeluar2 }} |
            Partner: {{ $partnerName }}
        </p>
    @else
        <p class="text-sm font-medium flex flex-wrap items-center gap-x-2">
            <span class="inline-flex items-center gap-1">
                <x-icons.clock class="w-4 h-4" />
                Jam masuk: <strong>{{ $jamMasuk }} WIB</strong>
            </span>
            <span class="mx-1">|</span>
            <span>Jam pulang: <strong>{{ $jamKeluar }} WIB</strong></span>
            <span class="mx-1">|</span>
            <span class="inline-flex items-center gap-1">
                <x-icons.map-pin class="w-4 h-4" />
                Radius: <strong>20 meter</strong>
            </span>
        </p>
    @endif

    @if ($shiftNumber)
        <div class="mt-3 pt-3 border-t border-primary/20 flex items-center gap-2">
            <span
                class="inline-flex items-center px-3 py-1.5 rounded-full text-sm font-bold shadow-sm
                {{ (int) $shiftNumber === 1 ? 'bg-gradient-to-r from-blue-500 to-blue-600 text-white' : 'bg-gradient-to-r from-orange-500 to-orange-600 text-white' }}">
                <x-icons.user class="w-4 h-4 mr-1" />
                Anda Shift {{ $shiftNumber }}
            </span>
            @php
                $shiftJamKeluar =
                    (int) $shiftNumber === 1
                        ? \Carbon\Carbon::parse($user->shift1_jam_keluar)->format('H:i')
                        : \Carbon\Carbon::parse($user->shift2_jam_keluar)->format('H:i');
            @endphp
            <span class="text-sm text-gray-600">Bisa pulang setelah <strong>{{ $shiftJamKeluar }} WIB</strong></span>
        </div>
    @endif
</x-ui.info-box>
