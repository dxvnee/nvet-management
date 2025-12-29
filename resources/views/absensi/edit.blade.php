<x-app-layout>
    <x-slot name="header">Edit Absensi - {{ $absen->user->name }}</x-slot>
    <x-slot name="subtle">{{ $absen->tanggal->format('d F Y') }}</x-slot>

    <div class="space-y-6">
        {{-- Back Button --}}
        <a href="{{ url()->previous() }}"
            class="inline-flex items-center gap-2 text-gray-600 hover:text-primary transition-colors animate-slide-up">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18">
                </path>
            </svg>
            Kembali ke Halaman Sebelumnya
        </a>

        {{-- User Info --}}
        <div class="bg-white rounded-2xl shadow-xl p-6">
            <div class="flex items-center gap-4">
                <img src="{{ $absen->user->avatar ? asset('storage/' . $absen->user->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($absen->user->name) . '&color=7F9CF5&background=EBF4FF&size=64' }}"
                    alt="Avatar" class="w-16 h-16 rounded-full border-2 border-primary">
                <div>
                    <h3 class="text-xl font-bold text-gray-800">{{ $absen->user->name }}</h3>
                    <p class="text-gray-600">{{ $absen->user->jabatan }}</p>
                    <p class="text-sm text-gray-500">Tanggal: {{ $absen->tanggal->format('d F Y') }}</p>
                </div>
            </div>
        </div>

        {{-- Edit Form --}}
        <div class="bg-white rounded-2xl shadow-xl p-6">
            <form method="POST" action="{{ route('absen.update', $absen) }}" class="space-y-6">
                @csrf
                @method('PATCH')

                {{-- Waktu Absensi --}}
                <div>
                    <h4 class="text-lg font-semibold mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Waktu Absensi
                    </h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- Jam Masuk --}}
                        <div>
                            <label for="jam_masuk" class="block text-sm font-medium text-gray-700 mb-2">Jam Masuk</label>
                            <input type="time" name="jam_masuk" id="jam_masuk"
                                value="{{ $absen->jam_masuk ? $absen->jam_masuk->format('H:i') : '' }}"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary">
                        </div>

                        {{-- Jam Pulang --}}
                        <div>
                            <label for="jam_pulang" class="block text-sm font-medium text-gray-700 mb-2">Jam Pulang</label>
                            <input type="time" name="jam_pulang" id="jam_pulang"
                                value="{{ $absen->jam_pulang ? $absen->jam_pulang->format('H:i') : '' }}"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary">
                        </div>
                    </div>
                </div>

                {{-- Status Kehadiran --}}
                <div class="border-t pt-6">
                    <h4 class="text-lg font-semibold mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Status Kehadiran
                    </h4>
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">

                        {{-- Tidak Hadir --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Kehadiran</label>
                            <div class="flex items-center h-10">
                                <input type="hidden" name="tidak_hadir" value="0">
                                <input type="checkbox" name="tidak_hadir" id="tidak_hadir" value="1" {{ $absen->tidak_hadir ? 'checked' : '' }}
                                    class="h-4 w-4 text-gray-500 focus:ring-gray-500 border-gray-300 rounded">
                                <label for="tidak_hadir" class="ml-2 block text-sm text-gray-900">
                                    Tidak Hadir
                                </label>
                            </div>
                        </div>

                        {{-- Terlambat --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Terlambat?</label>
                            <div class="flex items-center h-10">
                                <input type="hidden" name="telat" value="0">
                                <input type="checkbox" name="telat" id="telat" value="1" {{ $absen->telat ? 'checked' : '' }}
                                    class="h-4 w-4 text-red-500 focus:ring-red-500 border-gray-300 rounded">
                                <label for="telat" class="ml-2 block text-sm text-gray-900">
                                    Ya, terlambat
                                </label>
                            </div>
                        </div>

                        {{-- Menit Telat --}}
                        <div>
                            <label for="menit_telat" class="block text-sm font-medium text-gray-700 mb-2">Menit Terlambat</label>
                            <input type="number" name="menit_telat" id="menit_telat" min="0"
                                value="{{ $absen->menit_telat ?? 0 }}"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary">
                        </div>
                    </div>
                </div>

                {{-- Izin --}}
                <div class="border-t pt-6">
                    <h4 class="text-lg font-semibold mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Izin
                    </h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- Checkbox Izin --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Status Izin</label>
                            <div class="flex items-center h-10">
                                <input type="hidden" name="izin" value="0">
                                <input type="checkbox" name="izin" id="izin" value="1" {{ $absen->izin ? 'checked' : '' }}
                                    class="h-4 w-4 text-yellow-500 focus:ring-yellow-500 border-gray-300 rounded">
                                <label for="izin" class="ml-2 block text-sm text-gray-900">
                                    Izin hari ini
                                </label>
                            </div>
                        </div>

                        {{-- Izin Keterangan --}}
                        <div>
                            <label for="izin_keterangan" class="block text-sm font-medium text-gray-700 mb-2">Keterangan Izin</label>
                            <textarea name="izin_keterangan" id="izin_keterangan" rows="2"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary"
                                placeholder="Jelaskan alasan izin...">{{ $absen->izin_keterangan }}</textarea>
                        </div>
                    </div>
                </div>

                {{-- Lokasi --}}
                <div class="border-t pt-6">
                    <h4 class="text-lg font-semibold mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        Lokasi (Opsional)
                    </h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="lat_masuk" class="block text-sm font-medium text-gray-700 mb-2">Latitude Masuk</label>
                            <input type="number" step="any" name="lat_masuk" id="lat_masuk"
                                value="{{ $absen->lat_masuk }}"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary">
                        </div>
                        <div>
                            <label for="lng_masuk" class="block text-sm font-medium text-gray-700 mb-2">Longitude Masuk</label>
                            <input type="number" step="any" name="lng_masuk" id="lng_masuk"
                                value="{{ $absen->lng_masuk }}"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary">
                        </div>
                        <div>
                            <label for="lat_pulang" class="block text-sm font-medium text-gray-700 mb-2">Latitude Pulang</label>
                            <input type="number" step="any" name="lat_pulang" id="lat_pulang"
                                value="{{ $absen->lat_pulang }}"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary">
                        </div>
                        <div>
                            <label for="lng_pulang" class="block text-sm font-medium text-gray-700 mb-2">Longitude Pulang</label>
                            <input type="number" step="any" name="lng_pulang" id="lng_pulang"
                                value="{{ $absen->lng_pulang }}"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary">
                        </div>
                    </div>
                </div>

                {{-- Submit Buttons --}}
                <div class="flex gap-4 pt-6 justify-end border-t">
                    <button type="submit"
                        class="btn-primary px-6 py-2 rounded-lg hover:bg-primaryDark transition-colors">
                        Simpan Perubahan
                    </button>

                </div>
            </form>

            {{-- Delete Form --}}
            <div class="flex justify-end w pt-4">
                <form method="POST" action="{{ route('absen.destroy', $absen) }}"
                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus absensi ini? Tindakan ini tidak dapat dibatalkan.')"
                    class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="btn-danger px-6 py-2 rounded-lg hover:bg-red-700 hover:scale-[1.01] hover:text-white transition-colors">
                        Hapus Absensi
                    </button>
                </form>
            </div>
        </div>

        {{-- Current Status --}}
        <div class="bg-gray-50 rounded-2xl p-6">
            <h4 class="text-lg font-semibold mb-4">Status Saat Ini</h4>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div class="text-center">
                    <div class="text-sm text-gray-600">Jam Masuk</div>
                    <div class="font-semibold">{{ $absen->jam_masuk ? $absen->jam_masuk->format('H:i') : '-' }}</div>
                </div>
                <div class="text-center">
                    <div class="text-sm text-gray-600">Jam Pulang</div>
                    <div class="font-semibold">{{ $absen->jam_pulang ? $absen->jam_pulang->format('H:i') : '-' }}</div>
                </div>
                <div class="text-center">
                    <div class="text-sm text-gray-600">Status</div>
                    <div class="font-semibold">
                        @if($absen->tidak_hadir)
                            <span class="text-gray-600">Tidak Hadir</span>
                        @elseif($absen->izin)
                            <span class="text-yellow-600">Izin</span>
                        @elseif($absen->jam_masuk)
                            @if($absen->status === 'tepat_waktu')
                                <span class="text-green-600">Tepat Waktu</span>
                            @else
                                <span class="text-red-600">Terlambat</span>
                            @endif
                        @else
                            <span class="text-gray-400">Belum Absen</span>
                        @endif
                    </div>
                </div>
                <div class="text-center">
                    <div class="text-sm text-gray-600">Menit Kerja</div>
                    <div class="font-semibold">
                        {{ $absen->menit_kerja ? floor($absen->menit_kerja / 60) . 'j ' . ($absen->menit_kerja % 60) . 'm' : '-' }}
                    </div>
                </div>
            </div>
        </div>

        {{-- Photos Section --}}
        <div class="bg-white rounded-2xl shadow-xl p-6">
            <h4 class="text-lg font-semibold mb-4">Foto Absensi</h4>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                {{-- Foto Masuk --}}
                <div class="text-center">
                    <div class="text-sm text-gray-600 mb-2">Foto Masuk</div>
                    @if($absen->foto_masuk)
                        <div class="relative">
                            <img src="{{ asset('storage/' . $absen->foto_masuk) }}"
                                alt="Foto Masuk" class="w-full h-32 object-cover rounded-lg cursor-pointer hover:opacity-80 transition-opacity"
                                onclick="openPhotoModal('{{ asset('storage/' . $absen->foto_masuk) }}', '{{ $absen->user->name }} - Foto Masuk', '{{ $absen->jam_masuk ? $absen->jam_masuk->format('d/m/Y H:i') : '' }}')">
                            <div class="absolute inset-0 flex items-center justify-center opacity-0 hover:opacity-100 transition-opacity bg-black bg-opacity-50 rounded-lg">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>
                        </div>
                        <button onclick="openPhotoModal('{{ asset('storage/' . $absen->foto_masuk) }}', '{{ $absen->user->name }} - Foto Masuk', '{{ $absen->jam_masuk ? $absen->jam_masuk->format('d/m/Y H:i') : '' }}')"
                            class="mt-2 px-3 py-1 bg-green-100 hover:bg-green-200 text-green-700 text-xs rounded transition-colors">
                            📷 Lihat Foto Masuk
                        </button>
                    @else
                        <div class="w-full h-32 bg-gray-100 rounded-lg flex items-center justify-center">
                            <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <p class="text-xs text-gray-500 mt-2">Tidak ada foto masuk</p>
                    @endif
                </div>

                {{-- Foto Pulang --}}
                <div class="text-center">
                    <div class="text-sm text-gray-600 mb-2">Foto Pulang</div>
                    @if($absen->foto_pulang)
                        <div class="relative">
                            <img src="{{ asset('storage/' . $absen->foto_pulang) }}"
                                alt="Foto Pulang" class="w-full h-32 object-cover rounded-lg cursor-pointer hover:opacity-80 transition-opacity"
                                onclick="openPhotoModal('{{ asset('storage/' . $absen->foto_pulang) }}', '{{ $absen->user->name }} - Foto Pulang', '{{ $absen->jam_pulang ? $absen->jam_pulang->format('d/m/Y H:i') : '' }}')">
                            <div class="absolute inset-0 flex items-center justify-center opacity-0 hover:opacity-100 transition-opacity bg-black bg-opacity-50 rounded-lg">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>
                        </div>
                        <button onclick="openPhotoModal('{{ asset('storage/' . $absen->foto_pulang) }}', '{{ $absen->user->name }} - Foto Pulang', '{{ $absen->jam_pulang ? $absen->jam_pulang->format('d/m/Y H:i') : '' }}')"
                            class="mt-2 px-3 py-1 bg-blue-100 hover:bg-blue-200 text-blue-700 text-xs rounded transition-colors">
                            📷 Lihat Foto Pulang
                        </button>
                    @else
                        <div class="w-full h-32 bg-gray-100 rounded-lg flex items-center justify-center">
                            <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <p class="text-xs text-gray-500 mt-2">Tidak ada foto pulang</p>
                    @endif
                </div>

                {{-- Foto Izin --}}
                <div class="text-center">
                    @if($absen->foto_izin)
                    <div class="text-sm text-gray-600 mb-2">Foto Izin</div>
                        <div class="relative">
                            <img src="{{ asset('storage/' . $absen->foto_izin) }}"
                                alt="Foto Izin" class="w-full h-32 object-cover rounded-lg cursor-pointer hover:opacity-80 transition-opacity"
                                onclick="openPhotoModal('{{ asset('storage/' . $absen->foto_izin) }}', '{{ $absen->user->name }} - Foto Izin', '{{ $absen->tanggal->format('d/m/Y') }}')">
                            <div class="absolute inset-0 flex items-center justify-center opacity-0 hover:opacity-100 transition-opacity bg-black bg-opacity-50 rounded-lg">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>
                        </div>
                        <button onclick="openPhotoModal('{{ asset('storage/' . $absen->foto_izin) }}', '{{ $absen->user->name }} - Foto Izin', '{{ $absen->tanggal->format('d/m/Y') }}')"
                            class="mt-2 px-3 py-1 bg-orange-100 hover:bg-orange-200 text-orange-700 text-xs rounded transition-colors">
                            📷 Lihat Foto Izin
                        </button>

                    @endif
                </div>
            </div>
        </div>

        {{-- Photo Modal --}}
        <div id="photo-modal" class="fixed inset-0 flex items-center justify-center z-50 hidden opacity-0 transition-all duration-300 ease-out">
            <div class="bg-white rounded-2xl shadow-2xl max-w-2xl w-full mx-4 overflow-hidden transform scale-95 transition-all duration-300 ease-out">
                <div class="p-4 bg-gradient-to-r from-primary to-primaryDark text-white flex justify-between items-center">
                    <div>
                        <h3 id="photo-modal-title" class="text-lg font-bold">Foto Absensi</h3>
                        <p id="photo-modal-subtitle" class="text-sm opacity-90"></p>
                    </div>
                    <button onclick="closePhotoModal()" class="p-1 hover:bg-white/20 rounded-lg transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <div class="p-4">
                    <div class="bg-gray-100 rounded-xl overflow-hidden">
                        <img id="photo-modal-image" src="" alt="Foto Absensi" class="w-full h-auto max-h-96 object-contain opacity-0 transform scale-95 transition-all duration-500 ease-out delay-150">
                    </div>

                    <div class="mt-4 flex justify-end gap-3">
                        <button onclick="closePhotoModal()"
                            class="px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white font-bold rounded-lg transition-colors">
                            Tutup
                        </button>
                        <a id="photo-download-link" href="" download
                            class="px-4 py-2 bg-primary hover:bg-primaryDark text-white font-bold rounded-lg transition-colors">
                            Download
                        </a>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <script>
        // Photo Modal Functions
        function openPhotoModal(imageSrc, title, subtitle) {
            const modal = document.getElementById('photo-modal');
            const modalImage = document.getElementById('photo-modal-image');

            // Set content first
            modalImage.src = imageSrc;
            document.getElementById('photo-modal-title').textContent = title;
            document.getElementById('photo-modal-subtitle').textContent = subtitle;
            document.getElementById('photo-download-link').href = imageSrc;

            // Show modal with initial state
            modal.classList.remove('hidden');

            // Force reflow to ensure initial state is applied
            modal.offsetHeight;

            // Start modal animation
            modal.classList.add('opacity-100');
            modal.querySelector('.bg-white').classList.add('scale-100');

            // Handle image animation after it's loaded
            modalImage.onload = function() {
                setTimeout(() => {
                    modalImage.classList.add('opacity-100', 'scale-100');
                }, 100);
            };

            // Fallback if image is already cached
            if (modalImage.complete) {
                setTimeout(() => {
                    modalImage.classList.add('opacity-100', 'scale-100');
                }, 100);
            }
        }

        function closePhotoModal() {
            const modal = document.getElementById('photo-modal');
            const modalImage = document.getElementById('photo-modal-image');

            // Start closing animations
            modal.classList.remove('opacity-100');
            modal.querySelector('.bg-white').classList.remove('scale-100');
            modalImage.classList.remove('opacity-100', 'scale-100');

            // Hide modal after animation completes
            setTimeout(() => {
                modal.classList.add('hidden');
                // Clear image src to free memory
                modalImage.src = '';
            }, 300);
        }

        // Close modal when clicking outside
        document.getElementById('photo-modal').addEventListener('click', function(e) {
            if (e.target === this) {
                closePhotoModal();
            }
        });

        // Close modal with Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && !document.getElementById('photo-modal').classList.contains('hidden')) {
                closePhotoModal();
            }
        });
    </script>
</x-app-layout>
