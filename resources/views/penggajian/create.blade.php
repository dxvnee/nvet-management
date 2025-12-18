<x-app-layout>
    <x-slot name="header">Buat Penggajian</x-slot>
    <x-slot name="subtle">{{ $user->name }} - Periode {{ \Carbon\Carbon::parse($periode)->format('F Y') }}</x-slot>

    <div class="max-w-5xl mx-auto space-y-6">
        <!-- Back Button -->
        <a href="{{ route('penggajian.index', ['periode' => $periode]) }}"
            class="inline-flex items-center gap-2 text-gray-600 hover:text-primary transition-colors animate-slide-up">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18">
                </path>
            </svg>
            Kembali ke Daftar Penggajian
        </a>

        <!-- Employee Info Card -->
        <div class="bg-white rounded-2xl shadow-xl p-6 animate-slide-up">
            <div class="flex items-center gap-4">
                <img src="{{ $user->avatar ? asset('storage/' . $user->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&color=7F9CF5&background=EBF4FF&size=80' }}"
                    alt="{{ $user->name }}" class="w-20 h-20 rounded-full border-4 border-primary shadow-lg">
                <div>
                    <h3 class="text-xl font-bold text-gray-800">{{ $user->name }}</h3>
                    <p class="text-gray-500">{{ $user->email }}</p>
                    <span class="inline-flex items-center px-3 py-1 mt-2 rounded-full text-sm font-medium
                        {{ $user->jabatan === 'Dokter' ? 'bg-purple-100 text-purple-700' : '' }}
                        {{ $user->jabatan === 'Paramedis' ? 'bg-blue-100 text-blue-700' : '' }}
                        {{ $user->jabatan === 'Tech' ? 'bg-green-100 text-green-700' : '' }}
                        {{ $user->jabatan === 'FO' ? 'bg-orange-100 text-orange-700' : '' }}">
                        {{ $user->jabatan }}
                    </span>
                </div>
                <div class="ml-auto text-right">
                    <p class="text-sm text-gray-500">Gaji Pokok</p>
                    <p class="text-2xl font-bold text-primary">Rp
                        {{ number_format($user->gaji_pokok ?? 0, 0, ',', '.') }}
                    </p>
                </div>
            </div>
        </div>

        <!-- Form -->
        <form method="POST" action="{{ route('penggajian.store') }}" class="space-y-6" x-data="penggajianForm()">
            @csrf
            <input type="hidden" name="user_id" value="{{ $user->id }}">
            <input type="hidden" name="periode" value="{{ $periode }}">

            <!-- Gaji Pokok & Potongan -->
            <div class="bg-white rounded-2xl shadow-xl p-8 animate-slide-up-delay-1">
                <div class="flex items-center gap-3 mb-6">
                    <div class="p-3 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl shadow-lg">
                        <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                            </path>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-gray-800">Gaji Pokok & Potongan</h2>
                        <p class="text-gray-500 text-sm">Informasi gaji dasar dan potongan keterlambatan</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Gaji Pokok -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Gaji Pokok</label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-500">Rp</span>
                            <input type="number" name="gaji_pokok" x-model="gajiPokok"
                                value="{{ old('gaji_pokok', $user->gaji_pokok ?? 0) }}"
                                class="w-full pl-12 pr-4 py-3 rounded-xl border border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all"
                                required>
                        </div>
                    </div>

                    <!-- Total Menit Telat -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Total Menit Terlambat</label>
                        <div class="relative">
                            <input type="number" name="total_menit_telat" x-model="totalMenitTelat"
                                value="{{ old('total_menit_telat', $totalMenitTelat) }}"
                                class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all"
                                min="0" required>
                            <span class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-500">menit</span>
                        </div>
                        <p class="mt-1 text-xs text-gray-500">Diambil dari data absensi: {{ $totalMenitTelat }} menit
                        </p>
                    </div>

                    <!-- Potongan Per Menit -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Potongan Per Menit</label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-500">Rp</span>
                            <input type="number" name="potongan_per_menit" x-model="potonganPerMenit"
                                value="{{ old('potongan_per_menit', $potonganPerMenit) }}"
                                class="w-full pl-12 pr-4 py-3 rounded-xl border border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all"
                                min="0" step="1" required>
                        </div>
                        <p class="mt-1 text-xs text-gray-500">Otomatis: Rp
                            {{ number_format($potonganPerMenit, 0, ',', '.') }}/menit ({{ $user->gaji_pokok }} ÷
                            {{ $user->jam_kerja }} jam × 26 hari ÷ 60 menit, dibulatkan)
                        </p>
                    </div>

                    <!-- Total Potongan -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Total Potongan Keterlambatan</label>
                        <div class="bg-red-50 rounded-xl px-4 py-3 border border-red-200">
                            <p class="text-red-700 font-bold text-lg">- Rp <span
                                    x-text="formatNumber(totalMenitTelat * potonganPerMenit)"></span></p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Lembur Section -->
            <div class="bg-white rounded-2xl shadow-xl p-8 animate-slide-up-delay-2">
                <div class="flex items-center gap-3 mb-6">
                    <div class="p-3 bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-xl shadow-lg">
                        <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-gray-800">Lembur</h2>
                        <p class="text-gray-500 text-sm">Perhitungan upah lembur</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Total Durasi Lembur</label>
                        <div class="relative">
                            <input type="number" x-model="totalMenitLembur" readonly
                                class="w-full px-4 py-3 rounded-xl border border-gray-300 bg-gray-50 focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all">
                            <span class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-500">menit</span>
                        </div>
                        <p class="mt-1 text-xs text-gray-500">
                            {{ floor($totalMenitLembur / 60) }} jam {{ $totalMenitLembur % 60 }} menit
                        </p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Upah Lembur Per Menit</label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-500">Rp</span>
                            <input type="number" x-model="upahLemburPerMenit"
                                class="w-full pl-12 pr-4 py-3 rounded-xl border border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all">
                        </div>

                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Total Upah Lembur</label>
                        <div class="bg-yellow-50 rounded-xl px-4 py-3 border border-yellow-200">
                            <p class="text-yellow-700 font-bold text-lg">+ Rp <span
                                    x-text="formatNumber(totalMenitLembur * upahLemburPerMenit)"></span></p>
                        </div>
                        <!-- Hidden input to send total lembur value as part of 'lain_lain' or separate field if DB supports it.
                             For now, we'll add it to the calculation but maybe we should add a hidden field for it or merge with lain-lain.
                             Let's add a hidden input for 'uang_lembur' and handle it in controller if needed,
                             or just let the user manually add it to 'lain_lain' if we don't want to change DB structure too much.
                             BUT, the prompt asked for it to be calculated.
                             Let's assume we add it to 'lain_lain' automatically in the total calculation,
                             or better, add a specific field in the form that gets summed up.
                        -->
                        <input type="hidden" name="insentif_detail[uang_lembur]"
                            :value="totalMenitLembur * upahLemburPerMenit">
                    </div>
                </div>
            </div>

            <!-- Insentif Section -->
            <div class="bg-white rounded-2xl shadow-xl p-8 animate-slide-up-delay-2">
                <div class="flex items-center gap-3 mb-6">
                    <div class="p-3 bg-gradient-to-br from-green-500 to-green-600 rounded-xl shadow-lg">
                        <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7">
                            </path>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-gray-800">Insentif - {{ $user->jabatan }}</h2>
                        <p class="text-gray-500 text-sm">Komponen insentif berdasarkan jabatan</p>
                    </div>
                </div>

                @if($user->jabatan === 'Dokter')
                    <!-- Dokter Incentive Form -->
                    <div class="space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Total Transaksi</label>
                                <div class="relative">
                                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-500">Rp</span>
                                    <input type="number" name="insentif_detail[transaksi]" x-model="dokter.transaksi"
                                        class="w-full pl-12 pr-4 py-3 rounded-xl border border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all"
                                        min="0">
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Persentase Insentif (%)</label>
                                <div class="relative">
                                    <input type="number" name="insentif_detail[persenan]" x-model="dokter.persenan"
                                        class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all"
                                        min="0" max="100" step="0.1">
                                    <span class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-500">%</span>
                                </div>
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Pengurangan</label>
                                <div class="relative">
                                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-500">Rp</span>
                                    <input type="number" name="insentif_detail[pengurangan]" x-model="dokter.pengurangan"
                                        class="w-full pl-12 pr-4 py-3 rounded-xl border border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all"
                                        min="0">
                                </div>
                                <input type="text" name="insentif_detail[keterangan_pengurangan]"
                                    placeholder="Keterangan pengurangan..."
                                    class="w-full mt-2 px-4 py-2 rounded-lg border border-gray-300 text-sm focus:border-primary focus:ring-2 focus:ring-primary/20">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Penambahan</label>
                                <div class="relative">
                                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-500">Rp</span>
                                    <input type="number" name="insentif_detail[penambahan]" x-model="dokter.penambahan"
                                        class="w-full pl-12 pr-4 py-3 rounded-xl border border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all"
                                        min="0">
                                </div>
                                <input type="text" name="insentif_detail[keterangan_penambahan]"
                                    placeholder="Keterangan penambahan..."
                                    class="w-full mt-2 px-4 py-2 rounded-lg border border-gray-300 text-sm focus:border-primary focus:ring-2 focus:ring-primary/20">
                            </div>
                        </div>
                        <!-- Dynamic Lain-lain Items -->
                        <div class="space-y-3">
                            <div class="flex items-center justify-between">
                                <label class="block text-sm font-medium text-gray-700">Insentif Lain-lain</label>
                                <button type="button" @click="dokter.lainLainItems.push({nama: '', qty: 1, harga: 0})"
                                    class="px-3 py-1 bg-green-100 hover:bg-green-200 text-green-700 text-sm font-medium rounded-lg transition-colors flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                    </svg>
                                    Tambah Item
                                </button>
                            </div>
                            <template x-for="(item, index) in dokter.lainLainItems" :key="index">
                                <div class="bg-gray-50 rounded-xl p-4">
                                    <div class="flex items-start gap-3">
                                        <div class="flex-1 grid grid-cols-1 md:grid-cols-4 gap-2">
                                            <div class="md:col-span-2">
                                                <input type="text"
                                                    :name="'insentif_detail[lain_lain_items]['+index+'][nama]'"
                                                    x-model="item.nama" placeholder="Nama item"
                                                    class="w-full px-3 py-2 rounded-lg border border-gray-300 text-sm focus:border-primary">
                                            </div>
                                            <div>
                                                <input type="number"
                                                    :name="'insentif_detail[lain_lain_items]['+index+'][qty]'"
                                                    x-model="item.qty" placeholder="Qty" min="0"
                                                    class="w-full px-3 py-2 rounded-lg border border-gray-300 text-sm focus:border-primary">
                                            </div>
                                            <div class="relative">
                                                <span
                                                    class="absolute left-2 top-1/2 -translate-y-1/2 text-gray-500 text-xs">Rp</span>
                                                <input type="number"
                                                    :name="'insentif_detail[lain_lain_items]['+index+'][harga]'"
                                                    x-model="item.harga" placeholder="Harga" min="0"
                                                    class="w-full pl-8 pr-2 py-2 rounded-lg border border-gray-300 text-sm focus:border-primary">
                                            </div>
                                        </div>
                                        <button type="button" @click="dokter.lainLainItems.splice(index, 1)"
                                            class="p-2 bg-red-100 hover:bg-red-200 text-red-600 rounded-lg transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                </path>
                                            </svg>
                                        </button>
                                    </div>
                                    <p class="text-xs text-gray-500 mt-2">= Rp <span
                                            x-text="formatNumber((parseInt(item.qty) || 0) * (parseFloat(item.harga) || 0))"></span>
                                    </p>
                                </div>
                            </template>
                            <p x-show="dokter.lainLainItems.length === 0" class="text-sm text-gray-400 italic">Belum ada
                                item lain-lain</p>
                        </div>
                        <div class="bg-green-50 rounded-xl p-4 border border-green-200">
                            <p class="text-sm text-gray-600">Formula: Transaksi - (Pengurangan + Penambahan) × Persenan +
                                Lain-lain</p>
                            <p class="text-green-700 font-bold text-lg mt-2">Total Insentif: Rp <span
                                    x-text="formatNumber(calculateDokterInsentif())"></span></p>
                        </div>
                    </div>

                @elseif($user->jabatan === 'Paramedis')
                    <!-- Paramedis Incentive Form -->
                    <div class="space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Antar Jemput -->
                            <div class="bg-gray-50 rounded-xl p-4">
                                <label class="block text-sm font-medium text-gray-700 mb-3">Antar Jemput</label>
                                <div class="grid grid-cols-2 gap-2">
                                    <div>
                                        <input type="number" name="insentif_detail[antar_jemput_qty]"
                                            x-model="paramedis.antarJemputQty" placeholder="Qty" min="0"
                                            class="w-full px-3 py-2 rounded-lg border border-gray-300 text-sm focus:border-primary">
                                    </div>
                                    <div class="relative">
                                        <span
                                            class="absolute left-2 top-1/2 -translate-y-1/2 text-gray-500 text-xs">Rp</span>
                                        <input type="number" name="insentif_detail[antar_jemput_harga]"
                                            x-model="paramedis.antarJemputHarga" placeholder="Harga" min="0"
                                            class="w-full pl-8 pr-2 py-2 rounded-lg border border-gray-300 text-sm focus:border-primary">
                                    </div>
                                </div>
                                <p class="text-xs text-gray-500 mt-1">= Rp <span
                                        x-text="formatNumber(paramedis.antarJemputQty * paramedis.antarJemputHarga)"></span>
                                </p>
                            </div>
                            <!-- Rawat Inap -->
                            <div class="bg-gray-50 rounded-xl p-4">
                                <label class="block text-sm font-medium text-gray-700 mb-3">Rawat Inap</label>
                                <div class="grid grid-cols-2 gap-2">
                                    <div>
                                        <input type="number" name="insentif_detail[rawat_inap_qty]"
                                            x-model="paramedis.rawatInapQty" placeholder="Qty" min="0"
                                            class="w-full px-3 py-2 rounded-lg border border-gray-300 text-sm focus:border-primary">
                                    </div>
                                    <div class="relative">
                                        <span
                                            class="absolute left-2 top-1/2 -translate-y-1/2 text-gray-500 text-xs">Rp</span>
                                        <input type="number" name="insentif_detail[rawat_inap_harga]"
                                            x-model="paramedis.rawatInapHarga" placeholder="Harga" min="0"
                                            class="w-full pl-8 pr-2 py-2 rounded-lg border border-gray-300 text-sm focus:border-primary">
                                    </div>
                                </div>
                                <p class="text-xs text-gray-500 mt-1">= Rp <span
                                        x-text="formatNumber(paramedis.rawatInapQty * paramedis.rawatInapHarga)"></span></p>
                            </div>
                            <!-- Visit -->
                            <div class="bg-gray-50 rounded-xl p-4">
                                <label class="block text-sm font-medium text-gray-700 mb-3">Visit</label>
                                <div class="grid grid-cols-2 gap-2">
                                    <div>
                                        <input type="number" name="insentif_detail[visit_qty]" x-model="paramedis.visitQty"
                                            placeholder="Qty" min="0"
                                            class="w-full px-3 py-2 rounded-lg border border-gray-300 text-sm focus:border-primary">
                                    </div>
                                    <div class="relative">
                                        <span
                                            class="absolute left-2 top-1/2 -translate-y-1/2 text-gray-500 text-xs">Rp</span>
                                        <input type="number" name="insentif_detail[visit_harga]"
                                            x-model="paramedis.visitHarga" placeholder="Harga" min="0"
                                            class="w-full pl-8 pr-2 py-2 rounded-lg border border-gray-300 text-sm focus:border-primary">
                                    </div>
                                </div>
                                <p class="text-xs text-gray-500 mt-1">= Rp <span
                                        x-text="formatNumber(paramedis.visitQty * paramedis.visitHarga)"></span></p>
                            </div>
                            <!-- Grooming -->
                            <div class="bg-gray-50 rounded-xl p-4">
                                <label class="block text-sm font-medium text-gray-700 mb-3">Grooming</label>
                                <div class="grid grid-cols-2 gap-2">
                                    <div>
                                        <input type="number" name="insentif_detail[grooming_qty]"
                                            x-model="paramedis.groomingQty" placeholder="Qty" min="0"
                                            class="w-full px-3 py-2 rounded-lg border border-gray-300 text-sm focus:border-primary">
                                    </div>
                                    <div class="relative">
                                        <span
                                            class="absolute left-2 top-1/2 -translate-y-1/2 text-gray-500 text-xs">Rp</span>
                                        <input type="number" name="insentif_detail[grooming_harga]"
                                            x-model="paramedis.groomingHarga" placeholder="Harga" min="0"
                                            class="w-full pl-8 pr-2 py-2 rounded-lg border border-gray-300 text-sm focus:border-primary">
                                    </div>
                                </div>
                                <p class="text-xs text-gray-500 mt-1">= Rp <span
                                        x-text="formatNumber(paramedis.groomingQty * paramedis.groomingHarga)"></span></p>
                            </div>
                        </div>
                        <!-- Dynamic Lain-lain Items -->
                        <div class="space-y-3">
                            <div class="flex items-center justify-between">
                                <label class="block text-sm font-medium text-gray-700">Insentif Lain-lain</label>
                                <button type="button" @click="paramedis.lainLainItems.push({nama: '', qty: 1, harga: 0})"
                                    class="px-3 py-1 bg-green-100 hover:bg-green-200 text-green-700 text-sm font-medium rounded-lg transition-colors flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                    </svg>
                                    Tambah Item
                                </button>
                            </div>
                            <template x-for="(item, index) in paramedis.lainLainItems" :key="index">
                                <div class="bg-gray-50 rounded-xl p-4">
                                    <div class="flex items-start gap-3">
                                        <div class="flex-1 grid grid-cols-1 md:grid-cols-4 gap-2">
                                            <div class="md:col-span-2">
                                                <input type="text"
                                                    :name="'insentif_detail[lain_lain_items]['+index+'][nama]'"
                                                    x-model="item.nama" placeholder="Nama item"
                                                    class="w-full px-3 py-2 rounded-lg border border-gray-300 text-sm focus:border-primary">
                                            </div>
                                            <div>
                                                <input type="number"
                                                    :name="'insentif_detail[lain_lain_items]['+index+'][qty]'"
                                                    x-model="item.qty" placeholder="Qty" min="0"
                                                    class="w-full px-3 py-2 rounded-lg border border-gray-300 text-sm focus:border-primary">
                                            </div>
                                            <div class="relative">
                                                <span
                                                    class="absolute left-2 top-1/2 -translate-y-1/2 text-gray-500 text-xs">Rp</span>
                                                <input type="number"
                                                    :name="'insentif_detail[lain_lain_items]['+index+'][harga]'"
                                                    x-model="item.harga" placeholder="Harga" min="0"
                                                    class="w-full pl-8 pr-2 py-2 rounded-lg border border-gray-300 text-sm focus:border-primary">
                                            </div>
                                        </div>
                                        <button type="button" @click="paramedis.lainLainItems.splice(index, 1)"
                                            class="p-2 bg-red-100 hover:bg-red-200 text-red-600 rounded-lg transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                </path>
                                            </svg>
                                        </button>
                                    </div>
                                    <p class="text-xs text-gray-500 mt-2">= Rp <span
                                            x-text="formatNumber((parseInt(item.qty) || 0) * (parseFloat(item.harga) || 0))"></span>
                                    </p>
                                </div>
                            </template>
                            <p x-show="paramedis.lainLainItems.length === 0" class="text-sm text-gray-400 italic">Belum ada
                                item lain-lain</p>
                        </div>
                        <div class="bg-green-50 rounded-xl p-4 border border-green-200">
                            <p class="text-green-700 font-bold text-lg">Total Insentif: Rp <span
                                    x-text="formatNumber(calculateParamedisInsentif())"></span></p>
                        </div>
                    </div>

                @elseif($user->jabatan === 'FO')
                    <!-- FO Incentive Form -->
                    <div class="space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Review -->
                            <div class="bg-gray-50 rounded-xl p-4">
                                <label class="block text-sm font-medium text-gray-700 mb-3">Review</label>
                                <div class="grid grid-cols-2 gap-2">
                                    <div>
                                        <input type="number" name="insentif_detail[review_qty]" x-model="fo.reviewQty"
                                            placeholder="Qty" min="0"
                                            class="w-full px-3 py-2 rounded-lg border border-gray-300 text-sm focus:border-primary">
                                    </div>
                                    <div class="relative">
                                        <span
                                            class="absolute left-2 top-1/2 -translate-y-1/2 text-gray-500 text-xs">Rp</span>
                                        <input type="number" name="insentif_detail[review_harga]" x-model="fo.reviewHarga"
                                            placeholder="Harga" min="0"
                                            class="w-full pl-8 pr-2 py-2 rounded-lg border border-gray-300 text-sm focus:border-primary">
                                    </div>
                                </div>
                                <p class="text-xs text-gray-500 mt-1">= Rp <span
                                        x-text="formatNumber(fo.reviewQty * fo.reviewHarga)"></span></p>
                            </div>
                            <!-- Appointment -->
                            <div class="bg-gray-50 rounded-xl p-4">
                                <label class="block text-sm font-medium text-gray-700 mb-3">Appointment</label>
                                <div class="grid grid-cols-2 gap-2">
                                    <div>
                                        <input type="number" name="insentif_detail[appointment_qty]"
                                            x-model="fo.appointmentQty" placeholder="Qty" min="0"
                                            class="w-full px-3 py-2 rounded-lg border border-gray-300 text-sm focus:border-primary">
                                    </div>
                                    <div class="relative">
                                        <span
                                            class="absolute left-2 top-1/2 -translate-y-1/2 text-gray-500 text-xs">Rp</span>
                                        <input type="number" name="insentif_detail[appointment_harga]"
                                            x-model="fo.appointmentHarga" placeholder="Harga" min="0"
                                            class="w-full pl-8 pr-2 py-2 rounded-lg border border-gray-300 text-sm focus:border-primary">
                                    </div>
                                </div>
                                <p class="text-xs text-gray-500 mt-1">= Rp <span
                                        x-text="formatNumber(fo.appointmentQty * fo.appointmentHarga)"></span></p>
                            </div>
                        </div>
                        <!-- Dynamic Lain-lain Items -->
                        <div class="space-y-3">
                            <div class="flex items-center justify-between">
                                <label class="block text-sm font-medium text-gray-700">Insentif Lain-lain</label>
                                <button type="button" @click="fo.lainLainItems.push({nama: '', qty: 1, harga: 0})"
                                    class="px-3 py-1 bg-green-100 hover:bg-green-200 text-green-700 text-sm font-medium rounded-lg transition-colors flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                    </svg>
                                    Tambah Item
                                </button>
                            </div>
                            <template x-for="(item, index) in fo.lainLainItems" :key="index">
                                <div class="bg-gray-50 rounded-xl p-4">
                                    <div class="flex items-start gap-3">
                                        <div class="flex-1 grid grid-cols-1 md:grid-cols-4 gap-2">
                                            <div class="md:col-span-2">
                                                <input type="text"
                                                    :name="'insentif_detail[lain_lain_items]['+index+'][nama]'"
                                                    x-model="item.nama" placeholder="Nama item"
                                                    class="w-full px-3 py-2 rounded-lg border border-gray-300 text-sm focus:border-primary">
                                            </div>
                                            <div>
                                                <input type="number"
                                                    :name="'insentif_detail[lain_lain_items]['+index+'][qty]'"
                                                    x-model="item.qty" placeholder="Qty" min="0"
                                                    class="w-full px-3 py-2 rounded-lg border border-gray-300 text-sm focus:border-primary">
                                            </div>
                                            <div class="relative">
                                                <span
                                                    class="absolute left-2 top-1/2 -translate-y-1/2 text-gray-500 text-xs">Rp</span>
                                                <input type="number"
                                                    :name="'insentif_detail[lain_lain_items]['+index+'][harga]'"
                                                    x-model="item.harga" placeholder="Harga" min="0"
                                                    class="w-full pl-8 pr-2 py-2 rounded-lg border border-gray-300 text-sm focus:border-primary">
                                            </div>
                                        </div>
                                        <button type="button" @click="fo.lainLainItems.splice(index, 1)"
                                            class="p-2 bg-red-100 hover:bg-red-200 text-red-600 rounded-lg transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                </path>
                                            </svg>
                                        </button>
                                    </div>
                                    <p class="text-xs text-gray-500 mt-2">= Rp <span
                                            x-text="formatNumber((parseInt(item.qty) || 0) * (parseFloat(item.harga) || 0))"></span>
                                    </p>
                                </div>
                            </template>
                            <p x-show="fo.lainLainItems.length === 0" class="text-sm text-gray-400 italic">Belum ada item
                                lain-lain</p>
                        </div>
                        <div class="bg-green-50 rounded-xl p-4 border border-green-200">
                            <p class="text-green-700 font-bold text-lg">Total Insentif: Rp <span
                                    x-text="formatNumber(calculateFOInsentif())"></span></p>
                        </div>
                    </div>

                @elseif($user->jabatan === 'Tech')
                    <!-- Tech Incentive Form -->
                    <div class="space-y-4">
                        <div class="bg-gray-50 rounded-xl p-4">
                            <label class="block text-sm font-medium text-gray-700 mb-3">Antar Konten</label>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <input type="number" name="insentif_detail[antar_konten_qty]"
                                        x-model="tech.antarKontenQty" placeholder="Qty" min="0"
                                        class="w-full px-3 py-2 rounded-lg border border-gray-300 text-sm focus:border-primary">
                                </div>
                                <div class="relative">
                                    <span class="absolute left-2 top-1/2 -translate-y-1/2 text-gray-500 text-xs">Rp</span>
                                    <input type="number" name="insentif_detail[antar_konten_harga]"
                                        x-model="tech.antarKontenHarga" placeholder="Harga" min="0"
                                        class="w-full pl-8 pr-2 py-2 rounded-lg border border-gray-300 text-sm focus:border-primary">
                                </div>
                            </div>
                            <p class="text-xs text-gray-500 mt-1">= Rp <span
                                    x-text="formatNumber(tech.antarKontenQty * tech.antarKontenHarga)"></span></p>
                        </div>
                        <!-- Dynamic Lain-lain Items -->
                        <div class="space-y-3">
                            <div class="flex items-center justify-between">
                                <label class="block text-sm font-medium text-gray-700">Insentif Lain-lain</label>
                                <button type="button" @click="tech.lainLainItems.push({nama: '', qty: 1, harga: 0})"
                                    class="px-3 py-1 bg-green-100 hover:bg-green-200 text-green-700 text-sm font-medium rounded-lg transition-colors flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                    </svg>
                                    Tambah Item
                                </button>
                            </div>
                            <template x-for="(item, index) in tech.lainLainItems" :key="index">
                                <div class="bg-gray-50 rounded-xl p-4">
                                    <div class="flex items-start gap-3">
                                        <div class="flex-1 grid grid-cols-1 md:grid-cols-4 gap-2">
                                            <div class="md:col-span-2">
                                                <input type="text"
                                                    :name="'insentif_detail[lain_lain_items]['+index+'][nama]'"
                                                    x-model="item.nama" placeholder="Nama item"
                                                    class="w-full px-3 py-2 rounded-lg border border-gray-300 text-sm focus:border-primary">
                                            </div>
                                            <div>
                                                <input type="number"
                                                    :name="'insentif_detail[lain_lain_items]['+index+'][qty]'"
                                                    x-model="item.qty" placeholder="Qty" min="0"
                                                    class="w-full px-3 py-2 rounded-lg border border-gray-300 text-sm focus:border-primary">
                                            </div>
                                            <div class="relative">
                                                <span
                                                    class="absolute left-2 top-1/2 -translate-y-1/2 text-gray-500 text-xs">Rp</span>
                                                <input type="number"
                                                    :name="'insentif_detail[lain_lain_items]['+index+'][harga]'"
                                                    x-model="item.harga" placeholder="Harga" min="0"
                                                    class="w-full pl-8 pr-2 py-2 rounded-lg border border-gray-300 text-sm focus:border-primary">
                                            </div>
                                        </div>
                                        <button type="button" @click="tech.lainLainItems.splice(index, 1)"
                                            class="p-2 bg-red-100 hover:bg-red-200 text-red-600 rounded-lg transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                </path>
                                            </svg>
                                        </button>
                                    </div>
                                    <p class="text-xs text-gray-500 mt-2">= Rp <span
                                            x-text="formatNumber((parseInt(item.qty) || 0) * (parseFloat(item.harga) || 0))"></span>
                                    </p>
                                </div>
                            </template>
                            <p x-show="tech.lainLainItems.length === 0" class="text-sm text-gray-400 italic">Belum ada item
                                lain-lain</p>
                        </div>
                        <div class="bg-green-50 rounded-xl p-4 border border-green-200">
                            <p class="text-green-700 font-bold text-lg">Total Insentif: Rp <span
                                    x-text="formatNumber(calculateTechInsentif())"></span></p>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Lain-lain Section -->
            <div class="bg-white rounded-2xl shadow-xl p-8 animate-slide-up-delay-2">
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center gap-3">
                        <div class="p-3 bg-gradient-to-br from-orange-500 to-orange-600 rounded-xl shadow-lg">
                            <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                                </path>
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-xl font-bold text-gray-800">Lain-lain</h2>
                            <p class="text-gray-500 text-sm">Komponen tambahan penggajian (+/-)</p>
                        </div>
                    </div>
                    <button type="button" @click="lainLainItems.push({ nama: '', nilai: 0 })"
                        class="px-4 py-2 bg-orange-500 hover:bg-orange-600 text-white rounded-lg text-sm font-medium transition-colors flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4">
                            </path>
                        </svg>
                        Tambah Item
                    </button>
                </div>

                <!-- Dynamic Lain-lain Items -->
                <template x-if="lainLainItems.length > 0">
                    <div class="space-y-3">
                        <template x-for="(item, index) in lainLainItems" :key="index">
                            <div
                                class="flex flex-col md:flex-row gap-3 p-4 bg-orange-50 rounded-xl border border-orange-200">
                                <div class="flex-1">
                                    <label class="block text-xs font-medium text-gray-600 mb-1">Nama/Keterangan</label>
                                    <input type="text" x-model="item.nama"
                                        :name="'lain_lain_items[' + index + '][nama]'"
                                        placeholder="Contoh: Reimburse Transport, Bonus, Potongan Kasbon..."
                                        class="w-full px-3 py-2 rounded-lg border border-gray-300 focus:border-orange-500 focus:ring-2 focus:ring-orange-500/20 text-sm">
                                </div>
                                <div class="w-full md:w-48">
                                    <label class="block text-xs font-medium text-gray-600 mb-1">Nilai (+/-)</label>
                                    <div class="relative">
                                        <span
                                            class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-500 text-sm">Rp</span>
                                        <input type="number" x-model="item.nilai"
                                            :name="'lain_lain_items[' + index + '][nilai]'"
                                            class="w-full pl-10 pr-3 py-2 rounded-lg border border-gray-300 focus:border-orange-500 focus:ring-2 focus:ring-orange-500/20 text-sm">
                                    </div>
                                    <p class="text-xs text-gray-500 mt-1">Negatif untuk potongan</p>
                                </div>
                                <div class="flex items-end">
                                    <button type="button" @click="lainLainItems.splice(index, 1)"
                                        class="px-3 py-2 bg-red-100 hover:bg-red-200 text-red-600 rounded-lg transition-colors">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                            </path>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </template>

                        <!-- Total Lain-lain -->
                        <div class="mt-4 p-4 rounded-xl"
                            :class="calculateLainLainTotal() >= 0 ? 'bg-green-50 border border-green-200' : 'bg-red-50 border border-red-200'">
                            <p :class="calculateLainLainTotal() >= 0 ? 'text-green-700' : 'text-red-700'"
                                class="font-bold text-lg">
                                Total Lain-lain: <span
                                    x-text="(calculateLainLainTotal() >= 0 ? '+ ' : '') + 'Rp ' + formatNumber(calculateLainLainTotal())"></span>
                            </p>
                        </div>
                    </div>
                </template>

                <template x-if="lainLainItems.length === 0">
                    <div class="text-center py-8 text-gray-500">
                        <svg class="w-12 h-12 mx-auto mb-3 text-gray-300" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                            </path>
                        </svg>
                        <p>Belum ada item lain-lain</p>
                        <p class="text-sm">Klik tombol "Tambah Item" untuk menambahkan</p>
                    </div>
                </template>

                <div class="mt-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Catatan</label>
                    <textarea name="catatan" rows="3" placeholder="Catatan tambahan..."
                        class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all"></textarea>
                </div>
            </div>

            <!-- Total & Submit -->
            <div
                class="bg-gradient-to-br from-primary to-primaryDark rounded-2xl shadow-xl p-8 text-white animate-slide-up-delay-2">
                <div class="flex flex-col md:flex-row justify-between items-center gap-6">
                    <div>
                        <p class="text-white/80 text-lg">Total Gaji yang Diterima</p>
                        <p class="text-4xl font-bold">Rp <span x-text="formatNumber(calculateTotal())"></span></p>
                    </div>
                    <div class="flex gap-4">
                        <button type="submit" name="status" value="draft"
                            class="px-8 py-3 bg-white/20 hover:bg-white/30 text-white font-bold rounded-xl transition-all duration-300 flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4">
                                </path>
                            </svg>
                            Simpan Draft
                        </button>
                        <button type="submit" name="status" value="final"
                            class="px-8 py-3 bg-white text-primary font-bold rounded-xl shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-300 flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7"></path>
                            </svg>
                            Finalkan
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <script>
        function penggajianForm() {
            return {
                gajiPokok: {{ $user->gaji_pokok ?? 0 }},
                totalMenitTelat: {{ $totalMenitTelat }},
                potonganPerMenit: {{ $potonganPerMenit }},
                totalMenitLembur: {{ $totalMenitLembur ?? 0 }},
                upahLemburPerMenit: {{ floor($potonganPerMenit) }},
                lainLainItems: [],

                // Dokter
                dokter: {
                    transaksi: 0,
                    persenan: 0,
                    pengurangan: 0,
                    penambahan: 0,
                    lainLainItems: []
                },

                // Paramedis
                paramedis: {
                    antarJemputQty: 0, antarJemputHarga: 10000,
                    rawatInapQty: 0, rawatInapHarga: 10000,
                    visitQty: 0, visitHarga: 5000,
                    groomingQty: 0, groomingHarga: 10000,
                    lainLainItems: []
                },

                // FO
                fo: {
                    reviewQty: 0, reviewHarga: 0,
                    appointmentQty: 0, appointmentHarga: 0,
                    lainLainItems: []
                },

                // Tech
                tech: {
                    antarKontenQty: 0, antarKontenHarga: 0,
                    lainLainItems: []
                },

                formatNumber(num) {
                    return new Intl.NumberFormat('id-ID').format(num || 0);
                },

                calculateInsentifLainLainTotal(items) {
                    return items.reduce((total, item) => {
                        return total + ((parseInt(item.qty) || 0) * (parseFloat(item.harga) || 0));
                    }, 0);
                },

                calculateLainLainTotal() {
                    return this.lainLainItems.reduce((total, item) => {
                        return total + (parseFloat(item.nilai) || 0);
                    }, 0);
                },

                calculateDokterInsentif() {
                    const transaksi = parseFloat(this.dokter.transaksi) || 0;
                    const pengurangan = parseFloat(this.dokter.pengurangan) || 0;
                    const penambahan = parseFloat(this.dokter.penambahan) || 0;
                    const persenan = (parseFloat(this.dokter.persenan) || 0) / 100;
                    const lainLain = this.calculateInsentifLainLainTotal(this.dokter.lainLainItems);
                    return (transaksi - pengurangan + penambahan) * persenan + lainLain;
                },

                calculateParamedisInsentif() {
                    const antarJemput = (parseInt(this.paramedis.antarJemputQty) || 0) * (parseFloat(this.paramedis.antarJemputHarga) || 0);
                    const rawatInap = (parseInt(this.paramedis.rawatInapQty) || 0) * (parseFloat(this.paramedis.rawatInapHarga) || 0);
                    const visit = (parseInt(this.paramedis.visitQty) || 0) * (parseFloat(this.paramedis.visitHarga) || 0);
                    const grooming = (parseInt(this.paramedis.groomingQty) || 0) * (parseFloat(this.paramedis.groomingHarga) || 0);
                    const lainLain = this.calculateInsentifLainLainTotal(this.paramedis.lainLainItems);
                    return antarJemput + rawatInap + visit + grooming + lainLain;
                },

                calculateFOInsentif() {
                    const review = (parseInt(this.fo.reviewQty) || 0) * (parseFloat(this.fo.reviewHarga) || 0);
                    const appointment = (parseInt(this.fo.appointmentQty) || 0) * (parseFloat(this.fo.appointmentHarga) || 0);
                    const lainLain = this.calculateInsentifLainLainTotal(this.fo.lainLainItems);
                    return review + appointment + lainLain;
                },

                calculateTechInsentif() {
                    const antarKonten = (parseInt(this.tech.antarKontenQty) || 0) * (parseFloat(this.tech.antarKontenHarga) || 0);
                    const lainLain = this.calculateInsentifLainLainTotal(this.tech.lainLainItems);
                    return antarKonten + lainLain;
                },

                getInsentif() {
                    const jabatan = '{{ $user->jabatan }}';
                    switch (jabatan) {
                        case 'Dokter': return this.calculateDokterInsentif();
                        case 'Paramedis': return this.calculateParamedisInsentif();
                        case 'FO': return this.calculateFOInsentif();
                        case 'Tech': return this.calculateTechInsentif();
                        default: return 0;
                    }
                },

                calculateTotal() {
                    const gaji = parseFloat(this.gajiPokok) || 0;
                    const potongan = (parseInt(this.totalMenitTelat) || 0) * (parseFloat(this.potonganPerMenit) || 0);
                    const lembur = (parseInt(this.totalMenitLembur) || 0) * (parseFloat(this.upahLemburPerMenit) || 0);
                    const insentif = this.getInsentif();
                    const lainLain = this.calculateLainLainTotal();
                    return gaji - potongan + lembur + insentif + lainLain;
                }
            }
        }
    </script>
</x-app-layout>
