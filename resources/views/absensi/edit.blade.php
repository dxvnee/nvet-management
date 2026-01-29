<x-app-layout>
    <x-slot name="header">Edit Absensi - {{ $absen->user->name }}</x-slot>
    <x-slot name="subtle">{{ $absen->tanggal->format('d F Y') }}</x-slot>

    <div class="space-y-6">
        {{-- Back Button --}}
        <x-ui.back-button label="Kembali ke Halaman Sebelumnya" />

        {{-- User Info --}}
        <x-absensi.user-info-card :user="$absen->user" :date="$absen->tanggal" />

        {{-- Edit Form --}}
        <x-ui.section-card>
            <form method="POST" action="{{ route('absen.update', $absen) }}" class="space-y-6">
                @csrf
                @method('PATCH')

                {{-- Waktu Absensi --}}
                <x-ui.form-section title="Waktu Absensi">
                    <x-slot:icon>
                        <x-icons.clock class="w-5 h-5 text-primary" />
                    </x-slot:icon>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <x-ui.form-input type="time" name="jam_masuk" label="Jam Masuk" :value="$absen->jam_masuk ? $absen->jam_masuk->format('H:i') : ''" />
                        <x-ui.form-input type="time" name="jam_pulang" label="Jam Pulang" :value="$absen->jam_pulang ? $absen->jam_pulang->format('H:i') : ''" />
                    </div>
                </x-ui.form-section>

                {{-- Status Kehadiran --}}
                <x-ui.form-section title="Status Kehadiran" :bordered="true">
                    <x-slot:icon>
                        <x-icons.check-circle class="w-5 h-5 text-primary" />
                    </x-slot:icon>

                    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Kehadiran</label>
                            <x-ui.form-checkbox name="tidak_hadir" label="Tidak Hadir" color="gray"
                                :checked="$absen->tidak_hadir" />
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Hari Libur</label>
                            <x-ui.form-checkbox name="libur" label="Libur" color="blue" :checked="$absen->libur" />
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Terlambat?</label>
                            <x-ui.form-checkbox name="telat" label="Ya, terlambat" color="red" :checked="$absen->telat" />
                        </div>
                        <x-ui.form-input type="number" name="menit_telat" label="Menit Terlambat" :value="$absen->menit_telat ?? 0" />
                    </div>
                </x-ui.form-section>

                {{-- Shift (Only for shift employees) --}}
                @if ($absen->user->is_shift && $absen->user->shift_partner_id)
                    <x-ui.form-section title="Shift" :bordered="true">
                        <x-slot:icon>
                            <x-icons.clock class="w-5 h-5 text-primary" />
                        </x-slot:icon>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <x-ui.form-select name="shift_number" label="Pilih Shift" :options="['1' => 'Shift 1', '2' => 'Shift 2']"
                                :value="$absen->shift_number" placeholder="-- Pilih Shift --" />
                        </div>
                    </x-ui.form-section>
                @endif

                {{-- Izin --}}
                <x-ui.form-section title="Izin" :bordered="true">
                    <x-slot:icon>
                        <x-icons.document-text class="w-5 h-5 text-primary" />
                    </x-slot:icon>

                    <div class="grid grid-cols-1 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Status Izin</label>
                            <x-ui.form-checkbox name="izin" label="Izin" color="primary" :checked="$absen->izin" />
                        </div>
                        <div>
                            <label for="izin_keterangan" class="block text-sm font-medium text-gray-700 mb-2">Keterangan
                                Izin</label>
                            <textarea name="izin_keterangan" id="izin_keterangan" rows="3"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary">{{ old('izin_keterangan', $absen->izin_keterangan) }}</textarea>
                        </div>
                    </div>
                </x-ui.form-section>

                {{-- Current Photos --}}
                @if ($absen->foto_masuk || $absen->foto_pulang || $absen->foto_izin)
                    <x-ui.form-section title="Foto Absensi" :bordered="true">
                        <x-slot:icon>
                            <x-icons.camera class="w-5 h-5 text-primary" />
                        </x-slot:icon>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            @if ($absen->foto_masuk)
                                <div class="space-y-2">
                                    <label class="block text-sm font-medium text-gray-700">Foto Masuk</label>
                                    <div class="relative group">
                                        <img src="{{ asset('storage/' . $absen->foto_masuk) }}" alt="Foto Masuk"
                                            class="w-full h-48 object-cover rounded-lg border border-gray-200">
                                        <div
                                            class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition-opacity rounded-lg flex items-center justify-center">
                                            <button type="button"
                                                onclick="openPhotoModal('{{ asset('storage/' . $absen->foto_masuk) }}', '{{ $absen->user->name }} - Foto Masuk', '{{ $absen->jam_masuk ? $absen->jam_masuk->format('d/m/Y H:i') : '' }}')"
                                                class="px-3 py-2 bg-white text-gray-800 rounded-lg font-medium text-sm">
                                                Lihat Foto
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            @if ($absen->foto_pulang)
                                <div class="space-y-2">
                                    <label class="block text-sm font-medium text-gray-700">Foto Pulang</label>
                                    <div class="relative group">
                                        <img src="{{ asset('storage/' . $absen->foto_pulang) }}" alt="Foto Pulang"
                                            class="w-full h-48 object-cover rounded-lg border border-gray-200">
                                        <div
                                            class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition-opacity rounded-lg flex items-center justify-center">
                                            <button type="button"
                                                onclick="openPhotoModal('{{ asset('storage/' . $absen->foto_pulang) }}', '{{ $absen->user->name }} - Foto Pulang', '{{ $absen->jam_pulang ? $absen->jam_pulang->format('d/m/Y H:i') : '' }}')"
                                                class="px-3 py-2 bg-white text-gray-800 rounded-lg font-medium text-sm">
                                                Lihat Foto
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            @if ($absen->foto_izin)
                                <div class="space-y-2">
                                    <label class="block text-sm font-medium text-gray-700">Foto Izin</label>
                                    <div class="relative group">
                                        <img src="{{ asset('storage/' . $absen->foto_izin) }}" alt="Foto Izin"
                                            class="w-full h-48 object-cover rounded-lg border border-gray-200">
                                        <div
                                            class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition-opacity rounded-lg flex items-center justify-center">
                                            <button type="button"
                                                onclick="openPhotoModal('{{ asset('storage/' . $absen->foto_izin) }}', '{{ $absen->user->name }} - Foto Izin', '{{ $absen->tanggal->format('d/m/Y') }}')"
                                                class="px-3 py-2 bg-white text-gray-800 rounded-lg font-medium text-sm">
                                                Lihat Foto
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </x-ui.form-section>
                @endif

                {{-- Location Info --}}
                @if (($absen->lat_masuk && $absen->lng_masuk) || ($absen->lat_pulang && $absen->lng_pulang))
                    <x-ui.form-section title="Lokasi Absensi" :bordered="true">
                        <x-slot:icon>
                            <x-icons.map-pin class="w-5 h-5 text-primary" />
                        </x-slot:icon>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @if ($absen->lat_masuk && $absen->lng_masuk)
                                <x-ui.info-box type="info" title="Lokasi Masuk">
                                    <x-slot:icon>
                                        <x-icons.map-pin class="w-5 h-5" />
                                    </x-slot:icon>
                                    <p class="text-sm font-mono">{{ number_format($absen->lat_masuk, 6) }},
                                        {{ number_format($absen->lng_masuk, 6) }}</p>
                                </x-ui.info-box>
                            @endif
                            @if ($absen->lat_pulang && $absen->lng_pulang)
                                <x-ui.info-box type="info" title="Lokasi Pulang">
                                    <x-slot:icon>
                                        <x-icons.map-pin class="w-5 h-5" />
                                    </x-slot:icon>
                                    <p class="text-sm font-mono">{{ number_format($absen->lat_pulang, 6) }},
                                        {{ number_format($absen->lng_pulang, 6) }}</p>
                                </x-ui.info-box>
                            @endif
                        </div>
                    </x-ui.form-section>
                @endif

                {{-- Submit --}}
                <div class="flex justify-end gap-3 pt-6 border-t">
                    <x-ui.action-button type="link" :href="url()->previous()" variant="secondary">
                        Batal
                    </x-ui.action-button>
                    <x-ui.action-button type="submit" variant="primary">
                        Update Absensi
                    </x-ui.action-button>
                </div>
            </form>
        </x-ui.section-card>

        {{-- Photo Modal --}}
        <x-absensi.photo-modal />
    </div>
</x-app-layout>
