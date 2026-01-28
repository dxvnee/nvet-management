@props(['user', 'aktivitas'])

@php
    $isIzin = $aktivitas->izin;
    $isTelat = $aktivitas->telat;
    $borderColor = $isIzin ? 'border-blue-300' : (!$isTelat ? 'border-emerald-300' : 'border-rose-300');
    $badgeBg = $isIzin
        ? 'bg-blue-100 text-blue-600'
        : (!$isTelat
            ? 'bg-emerald-100 text-emerald-600'
            : 'bg-rose-100 text-rose-600');
    $badgeIcon = $isIzin ? '📝' : (!$isTelat ? '✓' : '⚠');
@endphp

<div
    class="flex items-center gap-4 p-4 bg-gradient-to-r from-gray-50 to-white rounded-xl border border-gray-100 hover:border-primary/30 hover:shadow-md transition-all group">
    <div class="relative">
        <img src="{{ $user->avatar ? asset('storage/' . $user->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&size=40' }}"
            class="w-11 h-11 rounded-xl border-2 shadow-sm group-hover:scale-105 transition-transform {{ $borderColor }}">
        <span
            class="absolute -bottom-1 -right-1 w-5 h-5 rounded-full flex items-center justify-center text-[10px] shadow-sm {{ $badgeBg }}">
            {{ $badgeIcon }}
        </span>
    </div>
    <div class="flex-1 min-w-0">
        <p class="text-sm font-semibold text-gray-800 truncate">{{ $user->name }}</p>
        <p class="text-xs text-gray-500">
            @if ($isIzin)
                <span class="text-blue-600">Izin hari ini</span>
            @elseif(!$isTelat)
                <span class="text-emerald-600">Tepat waktu</span>
            @else
                <span class="text-rose-600">Terlambat {{ $aktivitas->menit_telat }} menit</span>
            @endif
        </p>
    </div>
    <div class="text-right">
        <p class="text-sm font-bold text-gray-800">
            {{ $aktivitas->jam_masuk ? $aktivitas->jam_masuk->format('H:i') : '-' }}</p>
        <p class="text-[10px] text-gray-400 uppercase tracking-wider">
            {{ \Carbon\Carbon::parse($aktivitas->tanggal)->format('d M') }}
        </p>
    </div>
</div>
