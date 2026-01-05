<x-app-layout>
    <x-slot name="header">Tambah Absensi Manual - {{ $user->name }}</x-slot>
    <x-slot name="subtle">{{ \Carbon\Carbon::parse($tanggal)->format('d F Y') }}</x-slot>

    <div class="space-y-6">
        {{-- Back Button --}}
        <a href="{{ route('absen.detailHari', $tanggal) }}"
            class="inline-flex items-center gap-2 text-gray-600 hover:text-primary transition-colors animate-slide-up">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18">
                </path>
            </svg>
            Kembali ke Detail Hari
        </a>

        {{-- User Info --}}
        <div class="bg-white rounded-2xl shadow-xl p-6">
            <div class="flex items-center gap-4">
                <img src="{{ $user->avatar ? asset('storage/' . $user->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&color=7F9CF5&background=EBF4FF&size=64' }}"
                    alt="Avatar" class="w-16 h-16 rounded-full border-2 border-primary">
                <div>
                    <h3 class="text-xl font-bold text-gray-800">{{ $user->name }}</h3>
                    <p class="text-gray-600">{{ $user->jabatan }}</p>
                    <p class="text-sm text-gray-500">Tanggal: {{ \Carbon\Carbon::parse($tanggal)->format('d F Y') }}</p>
                </div>
            </div>
        </div>

        {{-- Create Form --}}
        <div class="bg-white rounded-2xl shadow-xl p-6">
            <form method="POST" action="{{ route('absen.storeManual') }}" class="space-y-6">
                @csrf
                <input type="hidden" name="user_id" value="{{ $user->id }}">
                <input type="hidden" name="tanggal" value="{{ $tanggal }}">

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
                                value="{{ old('jam_masuk') }}"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary">
                            @error('jam_masuk')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Jam Pulang --}}
                        <div>
                            <label for="jam_pulang" class="block text-sm font-medium text-gray-700 mb-2">Jam Pulang</label>
                            <input type="time" name="jam_pulang" id="jam_pulang"
                                value="{{ old('jam_pulang') }}"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary">
                            @error('jam_pulang')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
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
                                <input type="checkbox" name="tidak_hadir" id="tidak_hadir" value="1" {{ old('tidak_hadir') ? 'checked' : '' }}
                                    class="h-4 w-4 text-gray-500 focus:ring-gray-500 border-gray-300 rounded">
                                <label for="tidak_hadir" class="ml-2 block text-sm text-gray-900">
                                    Tidak Hadir
                                </label>
                            </div>
                        </div>

                        {{-- Libur --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Hari Libur</label>
                            <div class="flex items-center h-10">
                                <input type="hidden" name="libur" value="0">
                                <input type="checkbox" name="libur" id="libur" value="1" {{ old('libur') ? 'checked' : '' }}
                                    class="h-4 w-4 text-blue-500 focus:ring-blue-500 border-gray-300 rounded">
                                <label for="libur" class="ml-2 block text-sm text-gray-900">
                                    Libur
                                </label>
                            </div>
                        </div>

                        {{-- Terlambat --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Terlambat?</label>
                            <div class="flex items-center h-10">
                                <input type="hidden" name="telat" value="0">
                                <input type="checkbox" name="telat" id="telat" value="1" {{ old('telat') ? 'checked' : '' }}
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
                                value="{{ old('menit_telat', 0) }}"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary">
                        </div>
                    </div>
                </div>

                {{-- Shift (Only for shift employees) --}}
                @if($user->is_shift && $user->shift_partner_id)
                <div class="border-t pt-6">
                    <h4 class="text-lg font-semibold mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Shift
                    </h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Pilih Shift</label>
                            <select name="shift_number" id="shift_number"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary">
                                <option value="">-- Pilih Shift --</option>
                                <option value="1" {{ old('shift_number') == '1' ? 'selected' : '' }}>Shift 1</option>
                                <option value="2" {{ old('shift_number') == '2' ? 'selected' : '' }}>Shift 2</option>
                            </select>
                        </div>
                    </div>
                </div>
                @endif

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
                                <input type="checkbox" name="izin" id="izin" value="1" {{ old('izin') ? 'checked' : '' }}
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
                                placeholder="Jelaskan alasan izin...">{{ old('izin_keterangan') }}</textarea>
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
                                value="{{ old('lat_masuk') }}"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary">
                        </div>
                        <div>
                            <label for="lng_masuk" class="block text-sm font-medium text-gray-700 mb-2">Longitude Masuk</label>
                            <input type="number" step="any" name="lng_masuk" id="lng_masuk"
                                value="{{ old('lng_masuk') }}"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary">
                        </div>
                        <div>
                            <label for="lat_pulang" class="block text-sm font-medium text-gray-700 mb-2">Latitude Pulang</label>
                            <input type="number" step="any" name="lat_pulang" id="lat_pulang"
                                value="{{ old('lat_pulang') }}"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary">
                        </div>
                        <div>
                            <label for="lng_pulang" class="block text-sm font-medium text-gray-700 mb-2">Longitude Pulang</label>
                            <input type="number" step="any" name="lng_pulang" id="lng_pulang"
                                value="{{ old('lng_pulang') }}"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary">
                        </div>
                    </div>
                </div>

                {{-- Submit Buttons --}}
                <div class="flex gap-4 pt-6 justify-end border-t">
                    <a href="{{ route('absen.detailHari', $tanggal) }}"
                        class="px-6 py-2 bg-gray-500 hover:bg-gray-600 text-white font-bold rounded-lg transition-colors">
                        Batal
                    </a>
                    <button type="submit"
                        class="btn-primary px-6 py-2 rounded-lg hover:bg-primaryDark transition-colors">
                        Simpan Absensi
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
