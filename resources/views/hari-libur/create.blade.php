<x-app-layout>
    <x-slot name="header">Tambah Hari Libur</x-slot>
    <x-slot name="subtle">Tambahkan hari libur baru</x-slot>

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
        <div class="bg-white rounded-2xl shadow-xl p-6 max-w-2xl">
            <div class="flex items-center gap-3 mb-6">
                <div class="p-3 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl shadow-lg">
                    <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 4v16m8-8H4"></path>
                    </svg>
                </div>
                <h2 class="text-xl font-bold text-gray-800">Form Hari Libur</h2>
            </div>

            <form action="{{ route('hari-libur.store') }}" method="POST" class="space-y-6">
                @csrf

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
                        Nama Hari Libur <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="nama" id="nama" value="{{ old('nama') }}" required
                        placeholder="Contoh: Tahun Baru, Idul Fitri, dll"
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
                            Centang jika hari libur ini berulang setiap tahun (contoh: Tahun Baru, Natal, dll)
                        </p>
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
