<x-app-layout>
    <x-slot name="header">Absen</x-slot>
    <x-slot name="subtle">Halaman absensi karyawan</x-slot>

    <div class="space-y-6">
        <!-- Status Absen Hari Ini -->
        <div class="bg-white rounded-2xl shadow-xl p-6 animate-slide-up">
            <div class="flex items-center gap-3 mb-6">
                <div class="p-3 bg-gradient-to-br from-primary to-primaryDark rounded-xl shadow-lg">
                    <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div>
                    <h2 class="text-xl font-bold text-gray-800">Status Absensi Hari Ini</h2>
                    <p class="text-gray-500 text-sm" id="current-datetime"></p>
                </div>
            </div>

            <!-- Status Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                <!-- Hadir -->
                <div class="p-4 rounded-xl border-2 {{ $sudahHadir ? 'bg-green-50 border-green-300' : 'bg-gray-50 border-gray-200' }}">
                    <div class="flex items-center gap-3">
                        <div class="p-2 rounded-lg {{ $sudahHadir ? 'bg-green-500' : 'bg-gray-300' }}">
                            <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="font-semibold {{ $sudahHadir ? 'text-green-700' : 'text-gray-500' }}">Hadir</p>
                            @if($sudahHadir)
                                <p class="text-sm text-green-600">
                                    {{ \Carbon\Carbon::parse($sudahHadir->jam)->format('H:i') }}
                                    @if($sudahHadir->telat)
                                        <span class="text-red-500 font-bold">(TELAT)</span>
                                    @endif
                                </p>
                            @else
                                <p class="text-sm text-gray-400">Belum absen</p>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Izin -->
                <div class="p-4 rounded-xl border-2 {{ $sudahIzin ? 'bg-yellow-50 border-yellow-300' : 'bg-gray-50 border-gray-200' }}">
                    <div class="flex items-center gap-3">
                        <div class="p-2 rounded-lg {{ $sudahIzin ? 'bg-yellow-500' : 'bg-gray-300' }}">
                            <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="font-semibold {{ $sudahIzin ? 'text-yellow-700' : 'text-gray-500' }}">Izin</p>
                            @if($sudahIzin)
                                <p class="text-sm text-yellow-600">{{ \Carbon\Carbon::parse($sudahIzin->jam)->format('H:i') }}</p>
                            @else
                                <p class="text-sm text-gray-400">Tidak izin</p>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Pulang -->
                <div class="p-4 rounded-xl border-2 {{ $sudahPulang ? 'bg-blue-50 border-blue-300' : 'bg-gray-50 border-gray-200' }}">
                    <div class="flex items-center gap-3">
                        <div class="p-2 rounded-lg {{ $sudahPulang ? 'bg-blue-500' : 'bg-gray-300' }}">
                            <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="font-semibold {{ $sudahPulang ? 'text-blue-700' : 'text-gray-500' }}">Pulang</p>
                            @if($sudahPulang)
                                <p class="text-sm text-blue-600">{{ \Carbon\Carbon::parse($sudahPulang->jam)->format('H:i') }}</p>
                            @else
                                <p class="text-sm text-gray-400">Belum pulang</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Info Jam Kerja -->
            <div class="bg-primaryUltraLight rounded-xl p-4 mb-6">
                <div class="flex items-center gap-2 text-primary">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span class="text-sm font-medium">Jam masuk: 09:00 WIB | Jam pulang: 20:00 WIB | Radius: 10 meter</span>
                </div>
            </div>

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
                <form id="form-hadir" action="{{ route('absen.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="tipe" value="hadir">
                    <input type="hidden" name="latitude" id="lat-hadir">
                    <input type="hidden" name="longitude" id="lng-hadir">
                    <button type="submit" 
                        {{ $sudahHadir ? 'disabled' : '' }}
                        class="w-full py-4 px-6 rounded-xl font-bold text-white transition-all duration-300 flex items-center justify-center gap-2
                        {{ $sudahHadir ? 'bg-gray-300 cursor-not-allowed' : 'bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 shadow-lg hover:shadow-xl transform hover:scale-105' }}">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        {{ $sudahHadir ? 'Sudah Hadir' : 'Absen Hadir' }}
                    </button>
                </form>

                <!-- Tombol Izin -->
                <button type="button" 
                    onclick="openIzinModal()"
                    {{ $sudahIzin || $sudahHadir ? 'disabled' : '' }}
                    class="w-full py-4 px-6 rounded-xl font-bold text-white transition-all duration-300 flex items-center justify-center gap-2
                    {{ $sudahIzin || $sudahHadir ? 'bg-gray-300 cursor-not-allowed' : 'bg-gradient-to-r from-yellow-500 to-yellow-600 hover:from-yellow-600 hover:to-yellow-700 shadow-lg hover:shadow-xl transform hover:scale-105' }}">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                    {{ $sudahIzin ? 'Sudah Izin' : ($sudahHadir ? 'Sudah Hadir' : 'Absen Izin') }}
                </button>

                <!-- Tombol Pulang -->
                <form id="form-pulang" action="{{ route('absen.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="tipe" value="pulang">
                    <input type="hidden" name="latitude" id="lat-pulang">
                    <input type="hidden" name="longitude" id="lng-pulang">
                    <button type="submit" 
                        {{ $sudahPulang || !$sudahHadir ? 'disabled' : '' }}
                        class="w-full py-4 px-6 rounded-xl font-bold text-white transition-all duration-300 flex items-center justify-center gap-2
                        {{ $sudahPulang || !$sudahHadir ? 'bg-gray-300 cursor-not-allowed' : 'bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 shadow-lg hover:shadow-xl transform hover:scale-105' }}">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                        </svg>
                        {{ $sudahPulang ? 'Sudah Pulang' : (!$sudahHadir ? 'Hadir Dulu' : 'Absen Pulang') }}
                    </button>
                </form>
            </div>
        </div>

        <!-- Riwayat Absen -->
        <div class="bg-white rounded-2xl shadow-xl p-6 animate-slide-up-delay-1">
            <div class="flex items-center gap-3 mb-6">
                <div class="p-3 bg-gradient-to-br from-primary to-primaryDark rounded-xl shadow-lg">
                    <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                </div>
                <h2 class="text-xl font-bold text-gray-800">Riwayat Absensi</h2>
            </div>

            @if($riwayat->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b border-gray-200">
                                <th class="text-left py-3 px-4 font-semibold text-gray-600">Tanggal</th>
                                <th class="text-left py-3 px-4 font-semibold text-gray-600">Tipe</th>
                                <th class="text-left py-3 px-4 font-semibold text-gray-600">Jam</th>
                                <th class="text-left py-3 px-4 font-semibold text-gray-600">Status</th>
                                <th class="text-left py-3 px-4 font-semibold text-gray-600">Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($riwayat as $absen)
                                <tr class="border-b border-gray-100 hover:bg-gray-50 transition-colors">
                                    <td class="py-3 px-4 text-gray-700">{{ $absen->tanggal->format('d M Y') }}</td>
                                    <td class="py-3 px-4">
                                        <span class="px-3 py-1 rounded-full text-xs font-semibold
                                            {{ $absen->tipe === 'hadir' ? 'bg-green-100 text-green-700' : '' }}
                                            {{ $absen->tipe === 'izin' ? 'bg-yellow-100 text-yellow-700' : '' }}
                                            {{ $absen->tipe === 'pulang' ? 'bg-blue-100 text-blue-700' : '' }}">
                                            {{ ucfirst($absen->tipe) }}
                                        </span>
                                    </td>
                                    <td class="py-3 px-4 text-gray-700">{{ \Carbon\Carbon::parse($absen->jam)->format('H:i') }}</td>
                                    <td class="py-3 px-4">
                                        @if($absen->telat)
                                            <span class="px-3 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-700">Telat</span>
                                        @else
                                            <span class="px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700">Tepat Waktu</span>
                                        @endif
                                    </td>
                                    <td class="py-3 px-4 text-gray-500 text-sm">{{ $absen->keterangan ?? '-' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-8 text-gray-500">
                    <svg class="h-12 w-12 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                    <p>Belum ada riwayat absensi</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Modal Izin -->
    <div id="izin-modal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md transform transition-all">
            <div class="p-6">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-xl font-bold text-gray-800">Form Izin</h3>
                    <button onclick="closeIzinModal()" class="text-gray-400 hover:text-gray-600 transition-colors">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                <form action="{{ route('absen.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="tipe" value="izin">
                    <input type="hidden" name="latitude" id="lat-izin">
                    <input type="hidden" name="longitude" id="lng-izin">
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Alasan Izin</label>
                        <textarea name="keterangan" rows="4" required
                            class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all"
                            placeholder="Masukkan alasan izin..."></textarea>
                    </div>
                    <button type="submit" 
                        class="w-full py-3 px-6 rounded-xl font-bold text-white bg-gradient-to-r from-yellow-500 to-yellow-600 hover:from-yellow-600 hover:to-yellow-700 transition-all shadow-lg hover:shadow-xl">
                        Kirim Izin
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
        let userLatitude = null;
        let userLongitude = null;

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

        // Get user location
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
                    
                    // Set coordinates to all forms
                    document.getElementById('lat-hadir').value = userLatitude;
                    document.getElementById('lng-hadir').value = userLongitude;
                    document.getElementById('lat-pulang').value = userLatitude;
                    document.getElementById('lng-pulang').value = userLongitude;
                    document.getElementById('lat-izin').value = userLatitude;
                    document.getElementById('lng-izin').value = userLongitude;

                    statusEl.innerHTML = `
                        <div class="flex items-center gap-3 text-green-600">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span>Lokasi berhasil diambil (${userLatitude.toFixed(6)}, ${userLongitude.toFixed(6)})</span>
                        </div>
                    `;
                    statusEl.classList.remove('bg-gray-50', 'border-gray-200');
                    statusEl.classList.add('bg-green-50', 'border-green-200');
                },
                (error) => {
                    let errorMessage = 'Gagal mengambil lokasi';
                    switch(error.code) {
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

        // Modal functions
        function openIzinModal() {
            document.getElementById('izin-modal').classList.remove('hidden');
        }

        function closeIzinModal() {
            document.getElementById('izin-modal').classList.add('hidden');
        }

        // Close modal on backdrop click
        document.getElementById('izin-modal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeIzinModal();
            }
        });
    </script>
</x-app-layout>
