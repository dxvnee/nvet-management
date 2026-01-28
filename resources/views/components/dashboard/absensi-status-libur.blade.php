@props(['absensi'])

<div
    class="flex flex-col md:flex-row items-center gap-6 p-6 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-2xl border border-blue-100">
    <div
        class="w-20 h-20 rounded-2xl bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center shadow-lg">
        <x-icons.sun class="h-10 w-10 text-white" />
    </div>
    <div class="flex-1 text-center md:text-left">
        <h4 class="text-xl font-bold text-blue-700 mb-1">Hari Libur 🎉</h4>
        <p class="text-gray-600">Hari ini adalah hari libur anda!</p>
        @if ($absensi->libur_keterangan)
            <p class="text-sm text-blue-600 mt-2 bg-blue-100 inline-block px-3 py-1 rounded-full">
                {{ $absensi->libur_keterangan }}</p>
        @endif
    </div>
</div>
