{{-- Special Day Info Box Component --}}
@props(['hariKhusus'])

<div
    class="bg-gradient-to-r from-blue-50 via-indigo-50 to-purple-50 rounded-2xl p-4 mb-6 border border-blue-200 shadow-sm">
    <div class="flex items-center gap-3">
        <div class="p-3 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl shadow-lg">
            <x-icons.calendar class="h-5 w-5 text-white" />
        </div>
        <div>
            <p class="text-sm font-bold text-blue-700">{{ $hariKhusus->nama }}</p>
            <p class="text-xs text-blue-600 flex items-center gap-1">
                <x-icons.information-circle class="w-3 h-3" />
                Hari khusus - tetap masuk kerja seperti biasa
                @if ($hariKhusus->jam_masuk && $hariKhusus->jam_keluar)
                    ({{ \Carbon\Carbon::parse($hariKhusus->jam_masuk)->format('H:i') }} -
                    {{ \Carbon\Carbon::parse($hariKhusus->jam_keluar)->format('H:i') }})
                @endif
            </p>
        </div>
    </div>
</div>
