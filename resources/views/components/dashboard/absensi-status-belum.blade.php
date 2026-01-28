<div class="text-center py-10 px-4 bg-gradient-to-r from-amber-50 to-yellow-50 rounded-2xl border border-amber-100">
    <div
        class="w-24 h-24 bg-gradient-to-br from-amber-400 to-yellow-500 rounded-2xl flex items-center justify-center mx-auto mb-5 shadow-lg">
        <x-icons.exclamation-circle class="w-12 h-12 text-white" />
    </div>
    <h4 class="text-2xl font-bold text-amber-700 mb-2">Belum Absen Hari Ini</h4>
    <p class="text-gray-600 mb-6">Jangan lupa untuk melakukan absensi!</p>
    <a href="{{ route('absen.index') }}"
        class="inline-flex items-center gap-2 px-8 py-4 bg-gradient-to-r from-primary to-primaryDark text-white font-bold rounded-xl hover:shadow-xl transition-all hover:scale-105">
        <x-icons.clock class="w-5 h-5" />
        Absen Sekarang
    </a>
</div>
