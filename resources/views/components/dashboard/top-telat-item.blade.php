@props(['index', 'telat'])

@php
    $rankColors = [
        0 => 'bg-gradient-to-br from-rose-500 to-red-600 text-white',
        1 => 'bg-gradient-to-br from-orange-400 to-orange-500 text-white',
        2 => 'bg-gradient-to-br from-amber-400 to-yellow-500 text-white',
    ];
    $rankClass = $rankColors[$index] ?? 'bg-gray-100 text-gray-600';
@endphp

<div
    class="flex items-center gap-3 p-3 bg-gradient-to-r from-gray-50 to-white rounded-xl border border-gray-100 hover:border-rose-200 hover:shadow-sm transition-all group">
    <span class="w-7 h-7 flex items-center justify-center rounded-lg text-xs font-bold shadow-sm {{ $rankClass }}">
        {{ $index + 1 }}
    </span>
    <img src="{{ $telat->user->avatar ? asset('storage/' . $telat->user->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($telat->user->name) . '&size=32&background=fee2e2&color=ef4444' }}"
        class="w-9 h-9 rounded-xl border-2 border-white shadow-sm group-hover:scale-105 transition-transform">
    <div class="flex-1 min-w-0">
        <p class="text-sm font-semibold text-gray-800 truncate">{{ $telat->user->name }}</p>
        <p class="text-xs text-gray-500">{{ $telat->total_telat }}x terlambat</p>
    </div>
    <span class="text-xs px-2.5 py-1 bg-rose-50 text-rose-600 rounded-lg font-semibold ring-1 ring-rose-200">
        {{ $telat->total_menit }}m
    </span>
</div>
