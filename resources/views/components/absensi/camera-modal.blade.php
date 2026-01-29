{{-- Camera Modal Component --}}
@props(['storeRoute', 'csrfToken'])

<div id="camera-modal"
    class="fixed inset-0 bg-black/60 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4">
    <div
        class="bg-white y-translate-1/2 rounded-3xl shadow-2xl w-full max-w-lg transform transition-all animate-slide-up">
        <div class="p-6">
            {{-- Header --}}
            <div class="flex items-center justify-between mb-6">
                <div class="flex items-center gap-3">
                    <div class="p-2 bg-gradient-to-br from-primary to-primaryDark rounded-xl shadow-lg">
                        <x-icons.camera class="h-5 w-5 text-white" />
                    </div>
                    <h3 id="camera-title" class="text-xl font-bold text-gray-800">Ambil Foto</h3>
                </div>
                <button onclick="closeCameraModal()"
                    class="p-2 rounded-xl text-gray-400 hover:text-gray-600 hover:bg-gray-100 transition-all">
                    <x-icons.x-mark class="h-6 w-6" />
                </button>
            </div>

            {{-- Camera Preview --}}
            <div
                class="relative bg-gradient-to-br from-gray-900 to-black rounded-2xl overflow-hidden mb-4 shadow-inner">
                <video id="camera-preview" autoplay playsinline
                    class="w-full h-64 object-cover transform scale-x-[-1]"></video>
                <canvas id="camera-canvas" class="hidden"></canvas>
                <img id="photo-preview" class="w-full h-64 object-cover hidden">
            </div>

            {{-- Captured Photo Preview --}}
            <div id="photo-result" class="hidden mb-4">
                <p class="text-sm font-medium text-gray-600 mb-2 flex items-center gap-1">
                    <x-icons.check class="w-4 h-4 text-emerald-500" />
                    Foto yang diambil:
                </p>
                <div class="relative">
                    <img id="captured-photo"
                        class="w-full h-48 object-cover rounded-2xl border-2 border-emerald-500 shadow-lg">
                    <div
                        class="absolute top-3 right-3 bg-gradient-to-r from-emerald-500 to-green-600 text-white p-2 rounded-xl shadow-lg">
                        <x-icons.check class="h-4 w-4" />
                    </div>
                </div>
            </div>

            {{-- Camera Controls --}}
            <div class="flex gap-3">
                <button type="button" id="btn-capture" onclick="capturePhoto()"
                    class="flex-1 py-3 px-6 rounded-2xl font-bold text-white bg-gradient-to-r from-primary to-primaryDark hover:from-primaryDark hover:to-primaryExtraDark transition-all shadow-lg flex items-center justify-center gap-2">
                    <x-icons.camera class="h-5 w-5" />
                    Ambil Foto
                </button>
                <button type="button" id="btn-retake" onclick="retakePhoto()"
                    class="hidden py-3 px-6 rounded-2xl font-bold text-gray-700 bg-gray-100 hover:bg-gray-200 border border-gray-200 transition-all flex items-center justify-center gap-2">
                    <x-icons.refresh class="h-5 w-5" />
                    Ulangi
                </button>
            </div>

            {{-- Submit Form --}}
            <form id="camera-form" action="{{ $storeRoute }}" method="POST" class="hidden">
                @csrf
                <input type="hidden" name="tipe" id="camera-tipe">
                <input type="hidden" name="latitude" id="camera-lat">
                <input type="hidden" name="longitude" id="camera-lng">
                <input type="hidden" name="foto" id="camera-foto">
                <input type="hidden" name="keterangan" id="camera-keterangan">
                <input type="hidden" name="diluar_lokasi_alasan" id="camera-diluar-lokasi-alasan">
                <input type="hidden" name="is_lembur" id="camera-is-lembur" value="0">
                <input type="hidden" name="lembur_keterangan" id="camera-lembur-keterangan">
            </form>

            {{-- Submit Button --}}
            <button type="button" id="btn-submit" onclick="submitWithPhoto()"
                class="w-full mt-4 py-4 px-6 rounded-2xl font-bold text-white bg-gradient-to-r from-emerald-500 to-green-600 hover:from-emerald-600 hover:to-green-700 transition-all shadow-lg hover:shadow-xl flex items-center justify-center gap-2 transform hover:scale-[1.01]">
                <x-icons.check class="h-5 w-5" />
                <span id="btn-submit-text">Kirim Absen</span>
            </button>

            {{-- Keterangan for Izin --}}
            <div id="izin-keterangan-wrapper" class="hidden mt-4">
                <label class="text-sm font-medium text-gray-700 mb-2 flex items-center gap-1">
                    <x-icons.chat-bubble class="w-4 h-4 text-amber-500" />
                    <span id="izin-label">Alasan Izin</span>
                </label>
                <textarea id="izin-keterangan-input" rows="3"
                    class="w-full px-4 py-3 rounded-2xl border border-gray-200 focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all shadow-sm"
                    placeholder="Masukkan alasan..."></textarea>
            </div>

            {{-- Alasan Absen Diluar Lokasi --}}
            <div id="diluar-lokasi-wrapper" class="hidden mt-4">
                <div
                    class="p-4 bg-gradient-to-r from-amber-50 to-yellow-50 border border-amber-200 rounded-2xl mb-3 shadow-sm">
                    <div class="flex items-center gap-2 text-amber-700">
                        <x-icons.exclamation-triangle class="h-5 w-5" />
                        <span class="font-medium">Anda berada di luar lokasi kantor</span>
                    </div>
                    <p class="text-sm text-yellow-600 mt-1" id="diluar-lokasi-jarak"></p>
                </div>
                <label class="text-sm font-medium text-gray-700 mb-2 flex items-center gap-1">
                    <x-icons.map-pin class="w-4 h-4 text-amber-500" />
                    Alasan Absen Diluar Lokasi <span class="text-rose-500">*</span>
                </label>
                <textarea id="diluar-lokasi-input" rows="3"
                    class="w-full px-4 py-3 rounded-2xl border border-gray-200 focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all shadow-sm"
                    placeholder="Contoh: Sedang visit ke klien, meeting di luar kantor, dinas luar, dll..."></textarea>
            </div>
        </div>
    </div>
</div>
