@props(['absensi'])

<div
    class="flex flex-col md:flex-row items-center gap-6 p-6 bg-gradient-to-r from-amber-50 to-yellow-50 rounded-2xl border border-amber-100">
    <div
        class="w-20 h-20 rounded-2xl bg-gradient-to-br from-amber-500 to-yellow-500 flex items-center justify-center shadow-lg">
        <x-icons.document-text class="w-10 h-10 text-white" />
    </div>
    <div class="flex-1 text-center md:text-left">
        <h4 class="text-xl font-bold text-amber-700 mb-1">Izin Hari Ini 📝</h4>
        @if ($absensi->izin_keterangan)
            <p class="text-gray-600">{{ $absensi->izin_keterangan }}</p>
        @else
            <p class="text-gray-500">Izin tanpa keterangan</p>
        @endif
    </div>
</div>
