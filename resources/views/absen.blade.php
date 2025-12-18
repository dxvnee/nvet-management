<x-app-layout>
    <x-slot name="header">Absen</x-slot>
    <x-slot name="subtle">Halaman absensi karyawan</x-slot>

    <div class="space-y-6">
        <!-- Status Absen Hari Ini -->
        <div class="bg-white rounded-2xl shadow-xl p-6 animate-slide-up">
            <div class="flex items-center gap-3 mb-6">
                <div class="p-3 bg-gradient-to-br from-primary to-primaryDark rounded-xl shadow-lg">
                    <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div>
                    <h2 class="text-xl font-bold text-gray-800">Status Absensi Hari Ini</h2>
                    <p class="text-gray-500 text-sm" id="current-datetime"></p>
                </div>
            </div>

            <!-- Status Cards -->
            @if($sudahIzin)
                <!-- Status Izin - Full Width -->
                <div class="w-full p-6 rounded-xl border-2 bg-yellow-50 border-yellow-300 mb-6">
                    <div class="flex items-center gap-4">
                        <div class="p-3 rounded-lg bg-yellow-500">
                            <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                                </path>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <p class="text-xl font-bold text-yellow-700">Sedang Izin</p>
                            <p class="text-sm text-yellow-600 mt-1">
                                Tanggal: {{ $sudahIzin->tanggal->format('d M Y') }}
                            </p>
                            @if($sudahIzin->izin_keterangan)
                                <p class="text-sm text-yellow-600 mt-2 italic">
                                    "{{ $sudahIzin->izin_keterangan }}"
                                </p>
                            @endif
                        </div>
                    </div>
                </div>
            @else
                <!-- Status Cards Normal -->
                <div class="flex gap-4 mb-6">
                    <!-- Hadir -->
                    <div
                        class="flex-1 p-4 rounded-xl border-2 {{ $sudahHadir ? 'bg-green-50 border-green-300' : 'bg-gray-50 border-gray-200' }}">
                        <div class="flex items-center gap-3">
                            <div class="p-2 rounded-lg {{ $sudahHadir ? 'bg-green-500' : 'bg-gray-300' }}">
                                <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="font-semibold {{ $sudahHadir ? 'text-green-700' : 'text-gray-500' }}">
                                    Hadir
                                    @if($sudahHadir && $sudahHadir->shift_number)
                                        <span
                                            class="ml-1 text-xs px-2 py-0.5 rounded-full {{ $sudahHadir->shift_number === 1 ? 'bg-blue-500 text-white' : 'bg-orange-500 text-white' }}">
                                            Shift {{ $sudahHadir->shift_number }}
                                        </span>
                                    @endif
                                </p>
                                @if($sudahHadir)
                                    <p class="text-sm text-green-600">
                                        {{ $sudahHadir->jam_masuk->format('H:i') }}
                                        @if($sudahHadir->telat)
                                            <span class="text-red-500 font-bold">(TELAT {{ $sudahHadir->menit_telat }} menit)</span>
                                        @endif
                                    </p>
                                @else
                                    <p class="text-sm text-gray-400">Belum absen</p>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Pulang -->
                    <div
                        class="flex-1 p-4 rounded-xl border-2 {{ $sudahPulang ? 'bg-blue-50 border-blue-300' : 'bg-gray-50 border-gray-200' }}">
                        <div class="flex items-center gap-3">
                            <div class="p-2 rounded-lg {{ $sudahPulang ? 'bg-blue-500' : 'bg-gray-300' }}">
                                <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                                    </path>
                                </svg>
                            </div>
                            <div>
                                <p class="font-semibold {{ $sudahPulang ? 'text-blue-700' : 'text-gray-500' }}">Pulang</p>
                                @if($sudahPulang)
                                    <p class="text-sm text-blue-600">{{ $sudahPulang->jam_pulang->format('H:i') }}</p>
                                @else
                                    <p class="text-sm text-gray-400">Belum pulang</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Info Jam Kerja -->
            <div class="bg-primaryUltraLight rounded-xl p-4 mb-6">
                <div class="flex items-center gap-2 text-primary">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    @php
                        $user = auth()->user();
                        if ($user->is_shift && $user->shift_partner_id) {
                            $jamMasuk1 = $user->shift1_jam_masuk ? \Carbon\Carbon::parse($user->shift1_jam_masuk)->format('H:i') : '08:00';
                            $jamKeluar1 = $user->shift1_jam_keluar ? \Carbon\Carbon::parse($user->shift1_jam_keluar)->format('H:i') : '14:00';
                            $jamMasuk2 = $user->shift2_jam_masuk ? \Carbon\Carbon::parse($user->shift2_jam_masuk)->format('H:i') : '14:00';
                            $jamKeluar2 = $user->shift2_jam_keluar ? \Carbon\Carbon::parse($user->shift2_jam_keluar)->format('H:i') : '20:00';
                            $partner = $user->shiftPartner;
                            $partnerName = $partner ? $partner->name : 'Tidak ada';
                        } else {
                            $jamMasuk = $user->jam_masuk ? \Carbon\Carbon::parse($user->jam_masuk)->format('H:i') : '09:00';
                            $jamKeluar = $user->jam_keluar ? \Carbon\Carbon::parse($user->jam_keluar)->format('H:i') : '20:00';
                        }
                    @endphp

                    @if($user->is_shift && $user->shift_partner_id)
                        <span class="text-sm font-medium">
                            <span
                                class="inline-flex items-center px-2 py-0.5 rounded bg-blue-100 text-blue-800 mr-2">SHIFT</span>
                            Shift 1: {{ $jamMasuk1 }} - {{ $jamKeluar1 }} |
                            Shift 2: {{ $jamMasuk2 }} - {{ $jamKeluar2 }} |
                            Partner: {{ $partnerName }}
                        </span>
                    @else
                        <span class="text-sm font-medium">Jam masuk: {{ $jamMasuk }} WIB | Jam pulang: {{ $jamKeluar }} WIB
                            | Radius: 20 meter</span>
                    @endif
                </div>

                @if($sudahHadir && $sudahHadir->shift_number)
                    <div class="mt-2 flex items-center gap-2">
                        <span
                            class="inline-flex items-center px-3 py-1 rounded-full text-sm font-bold
                                                {{ $sudahHadir->shift_number === 1 ? 'bg-blue-500 text-white' : 'bg-orange-500 text-white' }}">
                            Anda Shift {{ $sudahHadir->shift_number }}
                        </span>
                        @php
                            $shiftJamKeluar = $sudahHadir->shift_number === 1
                                ? \Carbon\Carbon::parse($user->shift1_jam_keluar)->format('H:i')
                                : \Carbon\Carbon::parse($user->shift2_jam_keluar)->format('H:i');
                        @endphp
                        <span class="text-sm text-gray-600">Bisa pulang setelah {{ $shiftJamKeluar }} WIB</span>
                    </div>
                @endif
            </div>

            <!-- Total Jam Kerja Hari Ini -->
            @if($sudahHadir && !$sudahIzin)
                <div
                    class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-xl p-4 mb-6 border border-blue-200 animate-slide-up-delay-1">
                    <div class="flex items-center gap-3">
                        <div class="p-2 bg-blue-500 rounded-lg">
                            <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-blue-700">Total Jam Kerja Hari Ini</p>
                            <p class="text-lg font-bold text-blue-800" id="working-hours">{{ $totalJamKerjaText }}</p>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Lokasi Status -->
            <div id="location-status" class="mb-6 p-4 rounded-xl bg-gray-50 border border-gray-200">
                <div class="flex items-center gap-3">
                    <div class="animate-spin h-5 w-5 border-2 border-primary border-t-transparent rounded-full"></div>
                    <span class="text-gray-600">Mengambil lokasi...</span>
                </div>
            </div>

            <!-- Absen Buttons -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <!-- Tombol Hadir -->
                <button type="button" onclick="openCameraModal('hadir')" {{ $sudahHadir || $sudahIzin ? 'disabled' : '' }}
                    class="w-full py-4 px-6 rounded-xl font-bold text-white transition-all duration-300 flex items-center justify-center gap-2
                    {{ $sudahHadir || $sudahIzin ? 'bg-gray-300 cursor-not-allowed' : 'bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 shadow-lg hover:shadow-xl transform hover:scale-105' }}">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                        </path>
                    </svg>
                    {{ $sudahHadir ? 'Sudah Hadir' : ($sudahIzin ? 'Sedang Izin' : 'Absen Hadir') }}
                </button>

                <!-- Tombol Izin -->
                <button type="button" onclick="openCameraModal('izin')" {{ ($sudahIzin && !$sudahHadir) || $sudahPulang ? 'disabled' : '' }}
                    class="w-full py-4 px-6 rounded-xl font-bold text-white transition-all duration-300 flex items-center justify-center gap-2
                    {{ ($sudahIzin && !$sudahHadir) || $sudahPulang ? 'bg-gray-300 cursor-not-allowed' : ($sudahHadir ? 'bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 shadow-lg hover:shadow-xl transform hover:scale-105' : 'bg-gradient-to-r from-yellow-500 to-yellow-600 hover:from-yellow-600 hover:to-yellow-700 shadow-lg hover:shadow-xl transform hover:scale-105') }}">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
                        </path>
                    </svg>
                    @if($sudahIzin && $sudahHadir)
                        Sudah Izin Pulang
                    @elseif($sudahIzin)
                        Sedang Izin
                    @elseif($sudahPulang)
                        Sudah Pulang
                    @elseif($sudahHadir)
                        Izin Pulang Awal
                    @else
                        Izin Tidak Masuk
                    @endif
                </button>

                <!-- Tombol Pulang -->
                <button type="button" onclick="openCameraModal('pulang')" {{ $sudahPulang || !$sudahHadir || $sudahIzin ? 'disabled' : '' }}
                    class="w-full py-4 px-6 rounded-xl font-bold text-white transition-all duration-300 flex items-center justify-center gap-2
                    {{ $sudahPulang || !$sudahHadir || $sudahIzin ? 'bg-gray-300 cursor-not-allowed' : 'bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 shadow-lg hover:shadow-xl transform hover:scale-105' }}">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                        </path>
                    </svg>
                    @if($sudahPulang)
                        Sudah Pulang
                    @elseif($sudahIzin)
                        Sudah Izin Pulang
                    @elseif(!$sudahHadir)
                        Hadir Dulu
                    @else
                        @php
                            $user = auth()->user();
                            if ($user->is_shift && $sudahHadir && $sudahHadir->shift_number) {
                                $jamPulangText = $sudahHadir->shift_number === 1
                                    ? \Carbon\Carbon::parse($user->shift1_jam_keluar)->format('H:i')
                                    : \Carbon\Carbon::parse($user->shift2_jam_keluar)->format('H:i');
                            } else {
                                $jamPulangText = $user->jam_keluar
                                    ? \Carbon\Carbon::parse($user->jam_keluar)->format('H:i')
                                    : '20:00';
                            }
                        @endphp
                        Absen Pulang (≥{{ $jamPulangText }})
                    @endif
                </button>
            </div>
        </div>

    </div>

    <!-- Camera Modal -->
    <div id="camera-modal"
        class="fixed inset-0 bg-black bg-opacity-75 z-50 hidden flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-lg transform transition-all">
            <div class="p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 id="camera-title" class="text-xl font-bold text-gray-800">Ambil Foto</h3>
                    <button onclick="closeCameraModal()" class="text-gray-400 hover:text-gray-600 transition-colors">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <!-- Camera Preview -->
                <div class="relative bg-black rounded-xl overflow-hidden mb-4">
                    <video id="camera-preview" autoplay playsinline class="w-full h-64 object-cover"></video>
                    <canvas id="camera-canvas" class="hidden"></canvas>
                    <img id="photo-preview" class="w-full h-64 object-cover hidden">


                </div>

                <!-- Captured Photo Preview -->
                <div id="photo-result" class="hidden mb-4">
                    <p class="text-sm text-gray-600 mb-2">Foto yang diambil:</p>
                    <div class="relative">
                        <img id="captured-photo" class="w-full h-48 object-cover rounded-xl border-2 border-green-500">
                        <div class="absolute top-2 right-2 bg-green-500 text-white p-1 rounded-full">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Camera Controls -->
                <div class="flex gap-3">
                    <button type="button" id="btn-capture" onclick="capturePhoto()"
                        class="flex-1 py-3 px-6 rounded-xl font-bold text-white bg-gradient-to-r from-primary to-primaryDark hover:from-primaryDark hover:to-primaryExtraDark transition-all shadow-lg flex items-center justify-center gap-2">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z">
                            </path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        Ambil Foto
                    </button>
                    <button type="button" id="btn-retake" onclick="retakePhoto()"
                        class="hidden py-3 px-6 rounded-xl font-bold text-gray-700 bg-gray-200 hover:bg-gray-300 transition-all flex items-center justify-center gap-2">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15">
                            </path>
                        </svg>
                        Ulangi
                    </button>
                </div>

                <!-- Submit Form (hidden, submitted via JS) -->
                <form id="camera-form" action="{{ route('absen.store') }}" method="POST" class="hidden">
                    @csrf
                    <input type="hidden" name="tipe" id="camera-tipe">
                    <input type="hidden" name="latitude" id="camera-lat">
                    <input type="hidden" name="longitude" id="camera-lng">
                    <input type="hidden" name="foto" id="camera-foto">
                    <input type="hidden" name="keterangan" id="camera-keterangan">
                    <input type="hidden" name="is_lembur" id="camera-is-lembur" value="0">
                    <input type="hidden" name="lembur_keterangan" id="camera-lembur-keterangan">
                </form>

                <!-- Submit Button -->
                <button type="button" id="btn-submit" onclick="submitWithPhoto()"
                    class=" w-full mt-3 py-3 px-6 rounded-xl font-bold text-white bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 transition-all shadow-lg flex items-center justify-center gap-2">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    <span id="btn-submit-text">Kirim Absen</span>
                </button>

                <!-- Keterangan for Izin -->
                <div id="izin-keterangan-wrapper" class="hidden mt-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <span id="izin-label">Alasan Izin</span>
                    </label>
                    <textarea id="izin-keterangan-input" rows="3"
                        class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all"
                        placeholder="Masukkan alasan..."></textarea>
                </div>
            </div>
        </div>
    </div>

    <!-- Lembur Confirmation Modal -->
    <div id="lembur-modal"
        class="fixed inset-0 bg-black bg-opacity-75 z-[60] hidden flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md transform transition-all">
            <div class="p-6">
                <div class="flex items-center justify-center mb-4">
                    <div class="p-4 bg-orange-100 rounded-full">
                        <svg class="h-12 w-12 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
                <h3 class="text-xl font-bold text-gray-800 text-center mb-2">Konfirmasi Lembur</h3>
                <p class="text-gray-600 text-center mb-4">
                    Anda pulang <span id="lembur-menit" class="font-bold text-orange-600">0</span> menit setelah jam
                    kerja berakhir.
                </p>
                <p class="text-gray-600 text-center mb-6">
                    Apakah ini termasuk <span class="font-bold text-orange-600">lembur</span>?
                </p>

                <!-- Keterangan Lembur -->
                <div id="lembur-keterangan-wrapper" class="mb-6 hidden">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Keterangan Lembur</label>
                    <textarea id="lembur-keterangan-input" rows="2"
                        class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all"
                        placeholder="Masukkan keterangan lembur (opsional)..."></textarea>
                </div>

                <div class="flex gap-3">
                    <button type="button" onclick="confirmLembur(false)"
                        class="flex-1 py-3 px-6 rounded-xl font-bold text-gray-700 bg-gray-200 hover:bg-gray-300 transition-all">
                        Bukan Lembur
                    </button>
                    <button type="button" onclick="showLemburKeterangan()"
                        class="flex-1 py-3 px-6 rounded-xl font-bold text-white bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 transition-all shadow-lg">
                        Ya, Lembur
                    </button>
                </div>

                <!-- Submit Lembur Button (hidden initially) -->
                <button type="button" id="btn-submit-lembur" onclick="confirmLembur(true)"
                    class="hidden w-full mt-3 py-3 px-6 rounded-xl font-bold text-white bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 transition-all shadow-lg">
                    Kirim dengan Lembur
                </button>
            </div>
        </div>
    </div>

    <script>
        let userLatitude = null;
        let userLongitude = null;
        let cameraStream = null;
        let capturedPhotoData = null;
        let currentTipe = null;

        // Update current datetime
        function updateDateTime() {
            const now = new Date();
            const options = {
                weekday: 'long',
                year: 'numeric',
                month: 'long',
                day: 'numeric',
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit'
            };
            document.getElementById('current-datetime').textContent = now.toLocaleDateString('id-ID', options);

        }
        updateDateTime();
        setInterval(updateDateTime, 1000);

        // Get user location with fallback
        function getLocation() {
            const statusEl = document.getElementById('location-status');

            if (!navigator.geolocation) {
                statusEl.innerHTML = `
                    <div class="flex items-center gap-3 text-red-600">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                        </svg>
                        <span>Browser tidak mendukung Geolocation</span>
                    </div>
                `;
                return;
            }

            navigator.geolocation.getCurrentPosition(
                (position) => {
                    userLatitude = position.coords.latitude;
                    userLongitude = position.coords.longitude;

                    statusEl.innerHTML = `
                        <div class="flex items-center gap-3 text-green-600">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span>Lokasi berhasil diambil</span>
                            <button onclick="getLocation()" class="ml-auto text-sm bg-green-100 px-3 py-1 rounded-lg hover:bg-green-200 transition-colors">Refresh</button>
                        </div>
                    `;
                    statusEl.classList.remove('bg-gray-50', 'border-gray-200');
                    statusEl.classList.add('bg-green-50', 'border-green-200');
                },
                (error) => {
                    let errorMessage = 'Gagal mengambil lokasi';
                    switch (error.code) {
                        case error.PERMISSION_DENIED:
                            errorMessage = 'Izin lokasi ditolak. Mohon aktifkan GPS.';
                            break;
                        case error.POSITION_UNAVAILABLE:
                            errorMessage = 'Informasi lokasi tidak tersedia.';
                            break;
                        case error.TIMEOUT:
                            errorMessage = 'Waktu pengambilan lokasi habis.';
                            break;
                    }
                    statusEl.innerHTML = `
                        <div class="flex items-center gap-3 text-red-600">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                            </svg>
                            <span>${errorMessage}</span>
                            <button onclick="getLocation()" class="ml-auto text-sm bg-red-100 px-3 py-1 rounded-lg hover:bg-red-200 transition-colors">Coba Lagi</button>
                        </div>
                    `;
                    statusEl.classList.remove('bg-gray-50', 'border-gray-200');
                    statusEl.classList.add('bg-red-50', 'border-red-200');
                },
                {
                    enableHighAccuracy: true,
                    timeout: 10000,
                    maximumAge: 0
                }
            );
        }

        // Get location on page load
        getLocation();

        // Camera functions
        async function openCameraModal(tipe) {
            currentTipe = tipe;
            capturedPhotoData = null;

            // Set modal title based on type
            const titleEl = document.getElementById('camera-title');
            const submitTextEl = document.getElementById('btn-submit-text');
            const izinWrapper = document.getElementById('izin-keterangan-wrapper');
            const izinLabel = document.getElementById('izin-label');

            if (tipe === 'hadir') {
                titleEl.textContent = 'Foto Absen Hadir';
                submitTextEl.textContent = 'Kirim Absen Hadir';
                izinWrapper.classList.add('hidden');
            } else if (tipe === 'pulang') {
                titleEl.textContent = 'Foto Absen Pulang';
                submitTextEl.textContent = 'Kirim Absen Pulang';
                izinWrapper.classList.add('hidden');
            } else if (tipe === 'izin') {
                @if($sudahHadir)
                    titleEl.textContent = 'Foto Izin Pulang Awal';
                    submitTextEl.textContent = 'Kirim Izin Pulang Awal';
                    izinLabel.textContent = 'Alasan Pulang Awal';
                @else
                    titleEl.textContent = 'Foto Izin Tidak Masuk';
                    submitTextEl.textContent = 'Kirim Izin';
                    izinLabel.textContent = 'Alasan Izin';
                @endif
                izinWrapper.classList.remove('hidden');
            }

            // Reset UI
            document.getElementById('camera-preview').classList.remove('hidden');
            document.getElementById('photo-preview').classList.add('hidden');
            document.getElementById('photo-result').classList.add('hidden');
            document.getElementById('btn-capture').classList.remove('hidden');
            document.getElementById('btn-retake').classList.add('hidden');
            document.getElementById('btn-submit').classList.add('hidden');

            // Show modal
            document.getElementById('camera-modal').classList.remove('hidden');

            // Start camera
            try {
                cameraStream = await navigator.mediaDevices.getUserMedia({
                    video: { facingMode: 'user', width: { ideal: 640 }, height: { ideal: 480 } },
                    audio: false
                });
                document.getElementById('camera-preview').srcObject = cameraStream;
            } catch (error) {
                alert('Tidak dapat mengakses kamera. Pastikan izin kamera telah diberikan.');
                closeCameraModal();
            }
        }

        function closeCameraModal() {
            // Stop camera stream
            if (cameraStream) {
                cameraStream.getTracks().forEach(track => track.stop());
                cameraStream = null;
            }

            document.getElementById('camera-modal').classList.add('hidden');
            currentTipe = null;
            capturedPhotoData = null;
        }

        function capturePhoto() {
            const video = document.getElementById('camera-preview');
            const canvas = document.getElementById('camera-canvas');
            const ctx = canvas.getContext('2d');

            // Set canvas size to video size
            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;

            // Draw video frame to canvas
            ctx.drawImage(video, 0, 0);

            // Add timestamp watermark
            const now = new Date();
            const timestamp = now.toLocaleString('id-ID', {
                day: '2-digit',
                month: 'short',
                year: 'numeric',
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit'
            }) + ' WIB';

            ctx.font = 'bold 16px Arial';
            ctx.fillStyle = 'rgba(0, 0, 0, 0.7)';
            ctx.fillRect(canvas.width - 200, canvas.height - 30, 195, 25);
            ctx.fillStyle = '#ffffff';
            ctx.textAlign = 'right';

            // Get image data
            capturedPhotoData = canvas.toDataURL('image/jpeg', 0.7);

            // Show captured photo
            document.getElementById('captured-photo').src = capturedPhotoData;
            document.getElementById('photo-result').classList.remove('hidden');

            // Hide video, show controls
            document.getElementById('camera-preview').classList.add('hidden');
            document.getElementById('btn-capture').classList.add('hidden');
            document.getElementById('btn-retake').classList.remove('hidden');
            document.getElementById('btn-submit').classList.remove('hidden');
        }

        function retakePhoto() {
            capturedPhotoData = null;

            // Show video again
            document.getElementById('camera-preview').classList.remove('hidden');
            document.getElementById('photo-result').classList.add('hidden');
            document.getElementById('btn-capture').classList.remove('hidden');
            document.getElementById('btn-retake').classList.add('hidden');
            document.getElementById('btn-submit').classList.add('hidden');
        }

        function submitWithPhoto() {
            if (!capturedPhotoData) {
                alert('Silakan ambil foto terlebih dahulu.');
                return;
            }

            if (!userLatitude || !userLongitude) {
                alert('Lokasi belum tersedia. Mohon tunggu atau aktifkan GPS.');
                return;
            }

            // Set form values
            document.getElementById('camera-tipe').value = currentTipe;
            document.getElementById('camera-lat').value = userLatitude;
            document.getElementById('camera-lng').value = userLongitude;
            document.getElementById('camera-foto').value = capturedPhotoData;

            // Get keterangan for izin
            if (currentTipe === 'izin') {
                const keterangan = document.getElementById('izin-keterangan-input').value;
                if (!keterangan.trim()) {
                    alert('Silakan masukkan alasan izin.');
                    return;
                }
                document.getElementById('camera-keterangan').value = keterangan;
            }

            // Check for lembur if pulang
            if (currentTipe === 'pulang') {
                const lemburMenit = checkLemburEligibility();
                if (lemburMenit > 0) {
                    // Show lembur confirmation modal
                    document.getElementById('lembur-menit').textContent = lemburMenit;
                    document.getElementById('lembur-modal').classList.remove('hidden');
                    return;
                }
            }

            // Stop camera before submit
            if (cameraStream) {
                cameraStream.getTracks().forEach(track => track.stop());
            }

            // Submit form
            document.getElementById('camera-form').submit();
        }

        // Check if eligible for lembur (pulang 30+ minutes after scheduled time)
        function checkLemburEligibility() {
            @if($sudahHadir && !$sudahIzin && !$sudahPulang)
                @php
                    $user = auth()->user();
                    if ($user->is_shift && $sudahHadir && $sudahHadir->shift_number) {
                        $jamPulangSetting = $sudahHadir->shift_number === 1
                            ? \Carbon\Carbon::parse($user->shift1_jam_keluar)
                            : \Carbon\Carbon::parse($user->shift2_jam_keluar);
                    } else {
                        $jamPulangSetting = $user->jam_keluar
                            ? \Carbon\Carbon::parse($user->jam_keluar)
                            : \Carbon\Carbon::createFromTime(20, 0);
                    }
                @endphp
                const jamPulang = new Date();
                    jamPulang.setHours({{ $jamPulangSetting->hour }}, {{ $jamPulangSetting->minute }}, 0);
                const now = new Date();
                const diffMs = now - jamPulang;
                    const diffMins = Math.floor(diffMs / 60000);
                // Return minutes if over 30 minutes, otherwise 0
                    return diffMins >= 30 ? diffMins : 0;
            @else
                return 0;
            @endif
        }

        // Show keterangan input for lembur
        function showLemburKeterangan() {
            document.getElementById('lembur-keterangan-wrapper').classList.remove('hidden');
            document.getElementById('btn-submit-lembur').classList.remove('hidden');
        }

        // Confirm lembur choice
        function confirmLembur(isLembur) {
            if (isLembur) {
                document.getElementById('camera-is-lembur').value = '1';
                document.getElementById('camera-lembur-keterangan').value =
                    document.getElementById('lembur-keterangan-input').value;
            } else {
                document.getElementById('camera-is-lembur').value = '0';
                document.getElementById('camera-lembur-keterangan').value = '';
            }

            // Hide lembur modal
            document.getElementById('lembur-modal').classList.add('hidden');

            // Stop camera before submit
            if (cameraStream) {
                cameraStream.getTracks().forEach(track => track.stop());
            }

            // Submit form
            document.getElementById('camera-form').submit();
        }

        // Update working hours every minute
       @if($sudahHadir && !$sudahIzin && !$sudahPulang)
        let checkInTime = '{{ $sudahHadir->jam_masuk->format("H:i:s") }}';
        setInterval(updateWorkingHours, 60000); // Update every minute
            updateWorkingHours(); // Initial update
    @endif

        function updateWorkingHours() {
            if (typeof checkInTime === 'undefined') return;

            const now = new Date();
            const checkIn = new Date();
            const [hours, minutes, seconds] = checkInTime.split(':');
            checkIn.setHours(parseInt(hours), parseInt(minutes), parseInt(seconds));

            const diffMs = now - checkIn;
            const diffMins = Math.floor(diffMs / 60000);
            const hoursWorked = Math.floor(diffMins / 60);
            const minsWorked = diffMins % 60;

            const workingHoursEl = document.getElementById('working-hours');
            if (workingHoursEl) {
                workingHoursEl.textContent = hoursWorked + ' jam ' + minsWorked + ' menit';
            }
        }
    </script>
</x-app-layout>
