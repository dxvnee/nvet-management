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

                    {{-- Izin --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Status Izin</label>
                        <div class="flex items-center">
                            <input type="checkbox" name="izin" id="izin" value="1" {{ $absen->izin ? 'checked' : '' }}
                                class="h-4 w-4 text-primary focus:ring-primary border-gray-300 rounded">
                            <label for="izin" class="ml-2 block text-sm text-gray-900">
                                Izin
                            </label>
                        </div>
                    </div>

                    {{-- Izin Keterangan --}}
                    <div>
                        <label for="izin_keterangan" class="block text-sm font-medium text-gray-700 mb-2">Keterangan
                            Izin</label>
                        <textarea name="izin_keterangan" id="izin_keterangan" rows="3"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary"
                            placeholder="Jelaskan alasan izin...">{{ $absen->izin_keterangan }}</textarea>
                    </div>
                </div>

                {{-- Lokasi --}}
                <div class="border-t pt-6">
                    <h4 class="text-lg font-semibold mb-4">Lokasi (Opsional)</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="lat_masuk" class="block text-sm font-medium text-gray-700 mb-2">Latitude
                                Masuk</label>
                            <input type="number" step="any" name="lat_masuk" id="lat_masuk"
                                value="{{ $absen->lat_masuk }}"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary">
                        </div>
                        <div>
                            <label for="lng_masuk" class="block text-sm font-medium text-gray-700 mb-2">Longitude
                                Masuk</label>
                            <input type="number" step="any" name="lng_masuk" id="lng_masuk"
                                value="{{ $absen->lng_masuk }}"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary">
                        </div>
                        <div>
                            <label for="lat_pulang" class="block text-sm font-medium text-gray-700 mb-2">Latitude
                                Pulang</label>
                            <input type="number" step="any" name="lat_pulang" id="lat_pulang"
                                value="{{ $absen->lat_pulang }}"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary">
                        </div>
                        <div>
                            <label for="lng_pulang" class="block text-sm font-medium text-gray-700 mb-2">Longitude
                                Pulang</label>
                            <input type="number" step="any" name="lng_pulang" id="lng_pulang"
                                value="{{ $absen->lng_pulang }}"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary">
                        </div>
                    </div>
                </div>

                {{-- Submit Buttons --}}
                <div class="flex gap-4 pt-6 border-t">
                    <button type="submit"
                        class="btn-primary px-6 py-2 rounded-lg hover:bg-primaryDark transition-colors">
                        Simpan Perubahan
                    </button>
                    <a href="{{ url()->previous() }}"
                        class="btn-secondary px-6 py-2 rounded-lg hover:bg-primary hover:text-white transition-colors">
                        Batal
                    </a>
                </div>
            </form>
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
                        @if($absen->izin)
                            Izin
                        @elseif($absen->jam_masuk)
                            @if($absen->status === 'tepat_waktu')
                                Tepat Waktu
                            @else
                                Terlambat
                            @endif
                        @else
                            Belum Absen
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
    </div>
</x-app-layout>
