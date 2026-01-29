{{-- Absensi Location Status Component --}}
@props([
    'id' => 'location-status',
])

<div id="{{ $id }}"
    {{ $attributes->merge(['class' => 'p-4 rounded-2xl bg-gradient-to-r from-gray-50 to-gray-100 border border-gray-200 shadow-sm']) }}>
    <div class="flex items-center gap-3">
        <div class="animate-spin h-5 w-5 border-2 border-primary border-t-transparent rounded-full"></div>
        <span class="text-gray-600 font-medium">Mengambil lokasi...</span>
    </div>
</div>
