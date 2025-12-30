<x-app-layout>
    <x-slot name="header">Tambah Hari Libur / Hari Khusus</x-slot>
    <x-slot name="subtle">Tambahkan hari libur atau hari khusus dengan pengaturan custom</x-slot>

    <div class="space-y-6">
        {{-- Back Button --}}
        <a href="{{ route('hari-libur.index') }}"
            class="inline-flex items-center gap-2 text-gray-600 hover:text-primary transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Kembali
        </a>

        {{-- Form --}}
        <div class="bg-white rounded-2xl shadow-xl p-6 w-full">
            <div class="flex items-center gap-3 mb-6">
                <div class="p-3 bg-gradient-to-br from-primary to-primaryDark  rounded-xl shadow-lg">
                    <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 4v16m8-8H4"></path>
                    </svg>
                </div>
                <h2 class="text-xl font-bold text-gray-800">Form Hari Libur / Hari Khusus</h2>
            </div>

            <form action="{{ route('hari-libur.store') }}" method="POST" class="space-y-6" x-data="{
                tipe: '{{ old('tipe', 'libur') }}',
                isMasuk: {{ old('is_masuk') ? 'true' : 'false' }},
                isLembur: {{ old('is_lembur', true) ? 'true' : 'false' }},
                isShiftEnabled: {{ old('is_shift_enabled') ? 'true' : 'false' }},
                pegawaiMode: '{{ old('pegawai_semua') || !old('pegawai_hadir') ? 'semua' : 'pilih' }}'
            }">
                @csrf

                {{-- Tipe --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Tipe <span class="text-red-500">*</span>
                    </label>
                    <div class="grid grid-cols-2 gap-4">
                        <label class="relative">
                            <input type="radio" name="tipe" value="libur" x-model="tipe"
                                class="peer sr-only" {{ old('tipe', 'libur') === 'libur' ? 'checked' : '' }}>
                            <div class="p-4 rounded-xl border-2 cursor-pointer transition-all
                                peer-checked:border-red-500 peer-checked:bg-red-50 border-gray-200 hover:border-gray-300">
                                <div class="flex items-center gap-3">
                                    <div class="p-2 rounded-lg bg-red-100 text-red-600">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="font-semibold text-gray-800">Hari Libur</p>
                                        <p class="text-xs text-gray-500">Libur nasional, cuti bersama, dll</p>
                                    </div>
                                </div>
                            </div>
                        </label>
                        <label class="relative">
                            <input type="radio" name="tipe" value="hari_khusus" x-model="tipe"
                                class="peer sr-only" {{ old('tipe') === 'hari_khusus' ? 'checked' : '' }}>
                            <div class="p-4 rounded-xl border-2 cursor-pointer transition-all
                                peer-checked:border-blue-500 peer-checked:bg-blue-50 border-gray-200 hover:border-gray-300">
                                <div class="flex items-center gap-3">
                                    <div class="p-2 rounded-lg bg-blue-100 text-blue-600">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="font-semibold text-gray-800">Hari Khusus</p>
                                        <p class="text-xs text-gray-500">Jam kerja custom, pegawai tertentu</p>
                                    </div>
                                </div>
                            </div>
                        </label>
                    </div>
                    @error('tipe')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Tanggal --}}
                <div>
                    <label for="tanggal" class="block text-sm font-medium text-gray-700 mb-2">
                        Tanggal <span class="text-red-500">*</span>
                    </label>
                    <input type="date" name="tanggal" id="tanggal" value="{{ old('tanggal') }}" required
                        class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all @error('tanggal') border-red-500 @enderror">
                    @error('tanggal')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Nama --}}
                <div>
                    <label for="nama" class="block text-sm font-medium text-gray-700 mb-2">
                        Nama <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="nama" id="nama" value="{{ old('nama') }}" required
                        placeholder="Contoh: Tahun Baru, Kerja Lembur Akhir Tahun, dll"
                        class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all @error('nama') border-red-500 @enderror">
                    @error('nama')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Keterangan --}}
                <div>
                    <label for="keterangan" class="block text-sm font-medium text-gray-700 mb-2">
                        Keterangan
                    </label>
                    <textarea name="keterangan" id="keterangan" rows="3"
                        placeholder="Keterangan tambahan (opsional)"
                        class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all @error('keterangan') border-red-500 @enderror">{{ old('keterangan') }}</textarea>
                    @error('keterangan')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Is Recurring --}}
                <div class="flex items-start gap-3">
                    <input type="checkbox" name="is_recurring" id="is_recurring" value="1"
                        {{ old('is_recurring') ? 'checked' : '' }}
                        class="mt-1 w-5 h-5 rounded border-gray-300 text-primary focus:ring-primary">
                    <div>
                        <label for="is_recurring" class="font-medium text-gray-700 cursor-pointer">
                            Berulang Setiap Tahun
                        </label>
                        <p class="text-sm text-gray-500">
                            Centang jika hari ini berulang setiap tahun (contoh: Tahun Baru, Natal, dll)
                        </p>
                    </div>
                </div>

                {{-- Divider --}}
                <div class="border-t border-gray-200 pt-6" x-show="tipe === 'hari_khusus'" x-transition>
                    <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Pengaturan Hari Khusus
                    </h3>

                    {{-- Is Masuk (Tetap Kerja) --}}
                    <div class="flex items-start gap-3 mb-6">
                        <input type="checkbox" name="is_masuk" id="is_masuk" value="1" x-model="isMasuk"
                            {{ old('is_masuk') ? 'checked' : '' }}
                            class="mt-1 w-5 h-5 rounded border-gray-300 text-primary focus:ring-primary">
                        <div>
                            <label for="is_masuk" class="font-medium text-gray-700 cursor-pointer">
                                Tetap Masuk Kerja
                            </label>
                            <p class="text-sm text-gray-500">
                                Pegawai tetap masuk kerja di hari ini
                            </p>
                        </div>
                    </div>

                    {{-- Jam Kerja Custom --}}
                    <div x-show="isMasuk" x-transition class="space-y-6">
                        {{-- Is Lembur --}}
                        <div class="bg-gradient-to-r from-yellow-50 to-orange-50 rounded-xl p-4 border border-yellow-200">
                            <div class="flex items-start gap-3">
                                <input type="checkbox" name="is_lembur" id="is_lembur" value="1" x-model="isLembur"
                                    {{ old('is_lembur', true) ? 'checked' : '' }}
                                    class="mt-1 w-5 h-5 rounded border-gray-300 text-orange-500 focus:ring-orange-500">
                                <div>
                                    <label for="is_lembur" class="font-medium text-gray-700 cursor-pointer">
                                        Termasuk Lembur
                                    </label>
                                    <p class="text-sm text-gray-500">
                                        Jika dicentang, kerja di hari ini dihitung sebagai lembur dengan pengali upah.
                                        <br>Jika tidak, dihitung sebagai kerja biasa di tampilan user.
                                    </p>
                                </div>
                            </div>
                        </div>

                        {{-- Jam Kerja Normal --}}
                        <div class="bg-gray-50 rounded-xl p-4 space-y-4">
                            <h4 class="font-medium text-gray-700">Jam Kerja</h4>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label for="jam_masuk" class="block text-sm font-medium text-gray-600 mb-2">
                                        Jam Masuk
                                    </label>
                                    <input type="time" name="jam_masuk" id="jam_masuk" value="{{ old('jam_masuk') }}"
                                        class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all">
                                </div>
                                <div>
                                    <label for="jam_keluar" class="block text-sm font-medium text-gray-600 mb-2">
                                        Jam Keluar
                                    </label>
                                    <input type="time" name="jam_keluar" id="jam_keluar" value="{{ old('jam_keluar') }}"
                                        class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all">
                                </div>
                            </div>
                        </div>

                        {{-- Pengaturan Shift --}}
                        <div class="bg-gray-50 rounded-xl p-4 space-y-4">
                            <div class="flex items-start gap-3">
                                <input type="checkbox" name="is_shift_enabled" id="is_shift_enabled" value="1" x-model="isShiftEnabled"
                                    {{ old('is_shift_enabled') ? 'checked' : '' }}
                                    class="mt-1 w-5 h-5 rounded border-gray-300 text-primary focus:ring-primary">
                                <div>
                                    <label for="is_shift_enabled" class="font-medium text-gray-700 cursor-pointer">
                                        Aktifkan Pengaturan Shift
                                    </label>
                                    <p class="text-sm text-gray-500">
                                        Atur jam kerja berbeda untuk pegawai shift
                                    </p>
                                </div>
                            </div>

                            <div x-show="isShiftEnabled" x-transition class="space-y-4 pt-4 border-t border-gray-200">
                                {{-- Shift 1 --}}
                                <div>
                                    <h5 class="text-sm font-semibold text-gray-700 mb-3 flex items-center gap-2">
                                        <span class="px-2 py-1 bg-green-100 text-green-700 rounded-lg text-xs">Shift 1</span>
                                    </h5>
                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-600 mb-2">Jam Masuk</label>
                                            <input type="time" name="shift1_jam_masuk" value="{{ old('shift1_jam_masuk') }}"
                                                class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-600 mb-2">Jam Keluar</label>
                                            <input type="time" name="shift1_jam_keluar" value="{{ old('shift1_jam_keluar') }}"
                                                class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all">
                                        </div>
                                    </div>
                                </div>

                                {{-- Shift 2 --}}
                                <div>
                                    <h5 class="text-sm font-semibold text-gray-700 mb-3 flex items-center gap-2">
                                        <span class="px-2 py-1 bg-orange-100 text-orange-700 rounded-lg text-xs">Shift 2</span>
                                    </h5>
                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-600 mb-2">Jam Masuk</label>
                                            <input type="time" name="shift2_jam_masuk" value="{{ old('shift2_jam_masuk') }}"
                                                class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-600 mb-2">Jam Keluar</label>
                                            <input type="time" name="shift2_jam_keluar" value="{{ old('shift2_jam_keluar') }}"
                                                class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Pegawai yang Hadir --}}
                        <div class="bg-gray-50 rounded-xl p-4 space-y-4">
                            <h4 class="font-medium text-gray-700">Pegawai yang Hadir</h4>

                            <div class="flex gap-4">
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="radio" name="pegawai_mode" value="semua" x-model="pegawaiMode"
                                        class="w-4 h-4 text-primary focus:ring-primary">
                                    <span class="text-sm text-gray-700">Semua Pegawai</span>
                                </label>
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="radio" name="pegawai_mode" value="pilih" x-model="pegawaiMode"
                                        class="w-4 h-4 text-primary focus:ring-primary">
                                    <span class="text-sm text-gray-700">Pilih Pegawai</span>
                                </label>
                            </div>

                            <input type="hidden" name="pegawai_semua" :value="pegawaiMode === 'semua' ? '1' : ''">

                            <div x-show="pegawaiMode === 'pilih'" x-transition class="space-y-3 max-h-60 overflow-y-auto">
                                @foreach($pegawai as $p)
                                    <label class="flex items-center gap-3 p-3 bg-white rounded-lg border border-gray-200 hover:border-primary/50 cursor-pointer transition-all">
                                        <input type="checkbox" name="pegawai_hadir[]" value="{{ $p->id }}"
                                            {{ in_array($p->id, old('pegawai_hadir', [])) ? 'checked' : '' }}
                                            class="w-4 h-4 rounded border-gray-300 text-primary focus:ring-primary">
                                        <img src="{{ $p->avatar_url }}" alt="{{ $p->name }}" class="w-8 h-8 rounded-full object-cover">
                                        <div>
                                            <p class="font-medium text-gray-800 text-sm">{{ $p->name }}</p>
                                            <p class="text-xs text-gray-500">{{ $p->jabatan ?? 'Pegawai' }}</p>
                                        </div>
                                        @if($p->is_shift)
                                            <span class="ml-auto px-2 py-1 bg-purple-100 text-purple-700 rounded-lg text-xs">Shift</span>
                                        @endif
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        {{-- Opsi Tambahan --}}
                        <div class="bg-gray-50 rounded-xl p-4 space-y-4">
                            <h4 class="font-medium text-gray-700">Opsi Tambahan</h4>

                            {{-- Libur Tetap Masuk --}}
                            <div class="flex items-start gap-3">
                                <input type="checkbox" name="libur_tetap_masuk" id="libur_tetap_masuk" value="1"
                                    {{ old('libur_tetap_masuk') ? 'checked' : '' }}
                                    class="mt-1 w-5 h-5 rounded border-gray-300 text-primary focus:ring-primary">
                                <div>
                                    <label for="libur_tetap_masuk" class="font-medium text-gray-700 cursor-pointer">
                                        Yang Libur Hari Itu Tetap Masuk
                                    </label>
                                    <p class="text-sm text-gray-500">
                                        Pegawai yang jadwalnya libur di hari ini tetap harus masuk
                                    </p>
                                </div>
                            </div>

                            {{-- Is Wajib --}}
                            <div class="flex items-start gap-3">
                                <input type="checkbox" name="is_wajib" id="is_wajib" value="1"
                                    {{ old('is_wajib') ? 'checked' : '' }}
                                    class="mt-1 w-5 h-5 rounded border-gray-300 text-primary focus:ring-primary">
                                <div>
                                    <label for="is_wajib" class="font-medium text-gray-700 cursor-pointer">
                                        Wajib Hadir
                                    </label>
                                    <p class="text-sm text-gray-500">
                                        Jika tidak hadir akan dihitung sebagai alpha/absen
                                    </p>
                                </div>
                            </div>

                            {{-- Upah Multiplier (hanya tampil jika lembur) --}}
                            <div x-show="isLembur" x-transition>
                                <label for="upah_multiplier" class="block text-sm font-medium text-gray-700 mb-2">
                                    Pengali Upah
                                </label>
                                <div class="flex items-center gap-3">
                                    <input type="number" name="upah_multiplier" id="upah_multiplier"
                                        value="{{ old('upah_multiplier', '1.0') }}"
                                        min="0.5" max="5" step="0.5"
                                        class="w-32 px-4 py-3 rounded-xl border border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all">
                                    <span class="text-gray-500">× upah normal</span>
                                </div>
                                <p class="text-sm text-gray-500 mt-1">
                                    Contoh: 2.0 = upah 2x lipat (lembur hari libur)
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Buttons --}}
                <div class="flex gap-3 pt-4">
                    <a href="{{ route('hari-libur.index') }}"
                        class="flex-1 py-3 px-6 rounded-xl font-bold text-gray-700 bg-gray-200 hover:bg-gray-300 transition-all text-center">
                        Batal
                    </a>
                    <button type="submit"
                        class="flex-1 py-3 px-6 rounded-xl font-bold text-white bg-gradient-to-r from-primary to-primaryDark hover:from-primaryDark hover:to-primary transition-all shadow-lg">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
