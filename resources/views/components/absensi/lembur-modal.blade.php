{{-- Lembur Confirmation Modal Component --}}
@props([])

<div id="lembur-modal"
    class="fixed inset-0 bg-black/60 backdrop-blur-sm z-[60] hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl shadow-2xl w-full max-w-md transform transition-all animate-slide-up">
        <div class="p-6">
            <div class="flex items-center justify-center mb-4">
                <div class="p-4 bg-gradient-to-br from-orange-100 to-amber-100 rounded-2xl shadow-lg">
                    <x-icons.clock class="h-12 w-12 text-orange-500" />
                </div>
            </div>
            <h3 class="text-xl font-bold text-gray-800 text-center mb-2">Konfirmasi Lembur</h3>
            <p class="text-gray-600 text-center mb-4">
                Anda pulang <span id="lembur-menit" class="font-bold text-orange-600">0</span> menit setelah jam kerja
                berakhir.
            </p>
            <p class="text-gray-600 text-center mb-6">
                Apakah ini termasuk <span class="font-bold text-orange-600">lembur</span>?
            </p>

            {{-- Keterangan Lembur --}}
            <div id="lembur-keterangan-wrapper" class="mb-6 hidden">
                <label class="text-sm font-medium text-gray-700 mb-2 flex items-center gap-1">
                    <x-icons.chat-bubble class="w-4 h-4 text-orange-500" />
                    Keterangan Lembur
                </label>
                <textarea id="lembur-keterangan-input" rows="2"
                    class="w-full px-4 py-3 rounded-2xl border border-gray-200 focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all shadow-sm"
                    placeholder="Masukkan keterangan lembur (opsional)..."></textarea>
            </div>

            <div class="flex gap-3">
                <button type="button" onclick="confirmLembur(false)"
                    class="flex-1 py-3 px-6 rounded-2xl font-bold text-gray-700 bg-gray-100 hover:bg-gray-200 border border-gray-200 transition-all">
                    Bukan Lembur
                </button>
                <button type="button" onclick="showLemburKeterangan()"
                    class="flex-1 py-3 px-6 rounded-2xl font-bold text-white bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 transition-all shadow-lg hover:shadow-xl">
                    Ya, Lembur
                </button>
            </div>

            {{-- Submit Lembur Button --}}
            <button type="button" id="btn-submit-lembur" onclick="confirmLembur(true)"
                class="hidden w-full mt-4 py-4 px-6 rounded-2xl font-bold text-white bg-gradient-to-r from-emerald-500 to-green-600 hover:from-emerald-600 hover:to-green-700 transition-all shadow-lg hover:shadow-xl">
                Kirim dengan Lembur
            </button>
        </div>
    </div>
</div>
