{{-- Lembur Hari Libur Modal Component --}}
@props([])

<div id="lembur-libur-modal"
    class="fixed inset-0 bg-black/60 backdrop-blur-sm z-[60] hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl shadow-2xl w-full max-w-md transform transition-all animate-slide-up">
        <div class="p-6">
            <div class="flex items-center justify-center mb-4">
                <div class="p-4 bg-gradient-to-br from-blue-100 to-indigo-100 rounded-2xl shadow-lg">
                    <x-icons.sun class="h-12 w-12 text-blue-500" />
                </div>
            </div>
            <h3 class="text-xl font-bold text-gray-800 text-center mb-2">Konfirmasi Lembur Hari Libur</h3>
            <p class="text-gray-600 text-center mb-4">
                Hari ini adalah <span class="font-bold text-blue-600">hari libur</span> Anda.
            </p>
            <p class="text-gray-600 text-center mb-6">
                Apakah Anda yakin ingin masuk untuk <span class="font-bold text-orange-600">lembur</span>?
            </p>

            {{-- Keterangan Lembur Hari Libur --}}
            <div id="lembur-libur-keterangan-wrapper" class="mb-6">
                <label class="text-sm font-semibold text-gray-700 mb-2 flex items-center gap-2">
                    <x-icons.pencil class="w-4 h-4 text-orange-500" />
                    Keterangan Lembur <span class="text-red-500">*</span>
                </label>
                <textarea id="lembur-libur-keterangan-input" rows="3"
                    class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-orange-400 focus:ring-4 focus:ring-orange-100 transition-all resize-none text-gray-700 placeholder-gray-400"
                    placeholder="Jelaskan alasan dan detail pekerjaan lembur di hari libur..."></textarea>
            </div>

            <div class="flex gap-3">
                <button type="button" onclick="closeLemburLiburModal()"
                    class="group flex-1 py-3.5 px-6 rounded-2xl font-bold text-gray-700 bg-gray-100 hover:bg-gray-200 transition-all duration-300 flex items-center justify-center gap-2">
                    <x-icons.x-mark class="w-5 h-5 transition-transform group-hover:scale-110" />
                    Batal
                </button>
                <button type="button" onclick="confirmLemburLibur()"
                    class="group flex-1 py-3.5 px-6 rounded-2xl font-bold text-white bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 transition-all duration-300 shadow-lg hover:shadow-xl hover:scale-[1.02] flex items-center justify-center gap-2">
                    <x-icons.check class="w-5 h-5 transition-transform group-hover:scale-110" />
                    Ya, Lembur
                </button>
            </div>
        </div>
    </div>
</div>
