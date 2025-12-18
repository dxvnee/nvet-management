<x-app-layout>
    <x-slot name="header">Penggajian</x-slot>
    <x-slot name="subtle">Kelola penggajian pegawai klinik</x-slot>

    <div class="space-y-6">
        <!-- Filter Section -->
        <div class="bg-white rounded-2xl shadow-xl p-6 animate-slide-up">
            <div class="flex flex-col lg:flex-row gap-4 justify-between items-center">
                <!-- Period Filter -->
                <form method="GET" action="{{ route('penggajian.index') }}" class="flex gap-3 items-center">
                    <label class="text-sm font-medium text-gray-700 hidden md:block">Periode:</label>
                    <input type="month" name="periode" value="{{ $periode }}"
                        class="px-4 py-2 rounded-xl border border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all">
                    <button type="submit"
                        class="px-4 py-2 bg-primary hover:bg-primaryDark text-white font-semibold rounded-xl transition-all">
                        Filter
                    </button>
                </form>

                <!-- Add New Payroll -->
                <div x-data="{ open: false }" class="relative">
                    <button @click="open = !open" type="button"
                        class="px-6 py-3 bg-gradient-to-r from-primary to-primaryDark text-white font-bold rounded-xl shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-300 flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Buat Penggajian
                    </button>

                    <!-- Dropdown Employee Selection -->
                    <div x-show="open" @click.away="open = false" x-transition
                        class="absolute right-0 mt-2 w-72 bg-white rounded-xl shadow-2xl border border-gray-100 z-50 overflow-hidden">
                        <div class="p-4 border-b border-gray-100">
                            <p class="font-semibold text-gray-800">Pilih Pegawai</p>
                            <p class="text-sm text-gray-500">Periode:
                                {{ \Carbon\Carbon::parse($periode)->format('F Y') }}</p>
                        </div>
                        <div class="max-h-64 overflow-y-auto">
                            @forelse($employees as $employee)
                                @php
                                    $exists = \App\Models\Penggajian::where('user_id', $employee->id)->where('periode', $periode)->exists();
                                @endphp
                                <a href="{{ route('penggajian.create', ['user_id' => $employee->id, 'periode' => $periode]) }}"
                                    class="flex items-center gap-3 px-4 py-3 hover:bg-gray-50 transition-colors {{ $exists ? 'opacity-50 pointer-events-none' : '' }}">
                                    <img src="{{ $employee->avatar ? asset('storage/' . $employee->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($employee->name) . '&color=7F9CF5&background=EBF4FF&size=40' }}"
                                        alt="{{ $employee->name }}" class="w-10 h-10 rounded-full">
                                    <div class="flex-1">
                                        <p class="font-medium text-gray-800">{{ $employee->name }}</p>
                                        <p class="text-sm text-gray-500">{{ $employee->jabatan }}</p>
                                    </div>
                                    @if($exists)
                                        <span class="px-2 py-1 bg-green-100 text-green-600 text-xs font-medium rounded">Sudah
                                            ada</span>
                                    @endif
                                </a>
                            @empty
                                <div class="p-4 text-center text-gray-500">
                                    Tidak ada pegawai
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Payroll List -->
        <div class="bg-white rounded-2xl shadow-xl p-6 animate-slide-up-delay-1">
            <div class="flex items-center gap-3 mb-6">
                <div class="p-3 bg-gradient-to-br from-primary to-primaryDark rounded-xl shadow-lg">
                    <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h2 class="text-xl font-bold text-gray-800">Daftar Penggajian</h2>
            </div>

            @if($penggajian->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b border-gray-200">
                                <th class="text-left py-3 px-4 font-semibold text-gray-600">
                                    <a href="{{ request()->fullUrlWithQuery(['sort_by' => 'user_name', 'sort_direction' => (request('sort_by') === 'user_name' && request('sort_direction') === 'asc') ? 'desc' : 'asc']) }}"
                                       class="flex items-center space-x-1 hover:text-primary transition-colors">
                                        <span>Pegawai</span>
                                        @if(request('sort_by') === 'user_name')
                                            @if(request('sort_direction') === 'asc')
                                                <svg class="w-4 h-4 text-primary" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M14.707 12.707a1 1 0 01-1.414 0L10 9.414l-3.293 3.293a1 1 0 01-1.414-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 010 1.414z" clip-rule="evenodd"></path>
                                                </svg>
                                            @else
                                                <svg class="w-4 h-4 text-primary" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 010-1.414l-4-4a1 1 0 01-1.414 0l-4 4a1 1 0 111.414 1.414z" clip-rule="evenodd"></path>
                                                </svg>
                                            @endif
                                        @else
                                            <svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 3a1 1 0 01.707.293l3 3a1 1 0 01-1.414 1.414L10 5.414 7.707 7.707a1 1 0 01-1.414-1.414l3-3A1 1 0 0110 3zm-3.707 9.293a1 1 0 011.414 0L10 14.586l2.293-2.293a1 1 0 011.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 01.707-1.707z" clip-rule="evenodd"></path>
                                            </svg>
                                        @endif
                                    </a>
                                </th>
                                <th class="text-left py-3 px-4 font-semibold text-gray-600">
                                    <a href="{{ request()->fullUrlWithQuery(['sort_by' => 'jabatan', 'sort_direction' => (request('sort_by') === 'jabatan' && request('sort_direction') === 'asc') ? 'desc' : 'asc']) }}"
                                       class="flex items-center space-x-1 hover:text-primary transition-colors">
                                        <span>Jabatan</span>
                                        @if(request('sort_by') === 'jabatan')
                                            @if(request('sort_direction') === 'asc')
                                                <svg class="w-4 h-4 text-primary" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M14.707 12.707a1 1 0 01-1.414 0L10 9.414l-3.293 3.293a1 1 0 01-1.414-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 010 1.414z" clip-rule="evenodd"></path>
                                                </svg>
                                            @else
                                                <svg class="w-4 h-4 text-primary" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 010-1.414l-4-4a1 1 0 01-1.414 0l-4 4a1 1 0 111.414 1.414z" clip-rule="evenodd"></path>
                                                </svg>
                                            @endif
                                        @else
                                            <svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 3a1 1 0 01.707.293l3 3a1 1 0 01-1.414 1.414L10 5.414 7.707 7.707a1 1 0 01-1.414-1.414l3-3A1 1 0 0110 3zm-3.707 9.293a1 1 0 011.414 0L10 14.586l2.293-2.293a1 1 0 011.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 01.707-1.707z" clip-rule="evenodd"></path>
                                            </svg>
                                        @endif
                                    </a>
                                </th>
                                <th class="text-left py-3 px-4 font-semibold text-gray-600">
                                    <a href="{{ request()->fullUrlWithQuery(['sort_by' => 'gaji_pokok', 'sort_direction' => (request('sort_by') === 'gaji_pokok' && request('sort_direction') === 'asc') ? 'desc' : 'asc']) }}"
                                       class="flex items-center space-x-1 hover:text-primary transition-colors">
                                        <span>Gaji Pokok</span>
                                        @if(request('sort_by') === 'gaji_pokok')
                                            @if(request('sort_direction') === 'asc')
                                                <svg class="w-4 h-4 text-primary" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M14.707 12.707a1 1 0 01-1.414 0L10 9.414l-3.293 3.293a1 1 0 01-1.414-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 010 1.414z" clip-rule="evenodd"></path>
                                                </svg>
                                            @else
                                                <svg class="w-4 h-4 text-primary" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 010-1.414l-4-4a1 1 0 01-1.414 0l-4 4a1 1 0 111.414 1.414z" clip-rule="evenodd"></path>
                                                </svg>
                                            @endif
                                        @else
                                            <svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 3a1 1 0 01.707.293l3 3a1 1 0 01-1.414 1.414L10 5.414 7.707 7.707a1 1 0 01-1.414-1.414l3-3A1 1 0 0110 3zm-3.707 9.293a1 1 0 011.414 0L10 14.586l2.293-2.293a1 1 0 011.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 01.707-1.707z" clip-rule="evenodd"></path>
                                            </svg>
                                        @endif
                                    </a>
                                </th>
                                <th class="text-left py-3 px-4 font-semibold text-gray-600">
                                    <a href="{{ request()->fullUrlWithQuery(['sort_by' => 'total_potongan_telat', 'sort_direction' => (request('sort_by') === 'total_potongan_telat' && request('sort_direction') === 'asc') ? 'desc' : 'asc']) }}"
                                       class="flex items-center space-x-1 hover:text-primary transition-colors">
                                        <span>Potongan</span>
                                        @if(request('sort_by') === 'total_potongan_telat')
                                            @if(request('sort_direction') === 'asc')
                                                <svg class="w-4 h-4 text-primary" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M14.707 12.707a1 1 0 01-1.414 0L10 9.414l-3.293 3.293a1 1 0 01-1.414-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 010 1.414z" clip-rule="evenodd"></path>
                                                </svg>
                                            @else
                                                <svg class="w-4 h-4 text-primary" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 010-1.414l-4-4a1 1 0 01-1.414 0l-4 4a1 1 0 111.414 1.414z" clip-rule="evenodd"></path>
                                                </svg>
                                            @endif
                                        @else
                                            <svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 3a1 1 0 01.707.293l3 3a1 1 0 01-1.414 1.414L10 5.414 7.707 7.707a1 1 0 01-1.414-1.414l3-3A1 1 0 0110 3zm-3.707 9.293a1 1 0 011.414 0L10 14.586l2.293-2.293a1 1 0 011.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 01.707-1.707z" clip-rule="evenodd"></path>
                                            </svg>
                                        @endif
                                    </a>
                                </th>
                                <th class="text-left py-3 px-4 font-semibold text-gray-600">
                                    <a href="{{ request()->fullUrlWithQuery(['sort_by' => 'total_insentif', 'sort_direction' => (request('sort_by') === 'total_insentif' && request('sort_direction') === 'asc') ? 'desc' : 'asc']) }}"
                                       class="flex items-center space-x-1 hover:text-primary transition-colors">
                                        <span>Insentif</span>
                                        @if(request('sort_by') === 'total_insentif')
                                            @if(request('sort_direction') === 'asc')
                                                <svg class="w-4 h-4 text-primary" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M14.707 12.707a1 1 0 01-1.414 0L10 9.414l-3.293 3.293a1 1 0 01-1.414-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 010 1.414z" clip-rule="evenodd"></path>
                                                </svg>
                                            @else
                                                <svg class="w-4 h-4 text-primary" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 010-1.414l-4-4a1 1 0 01-1.414 0l-4 4a1 1 0 111.414 1.414z" clip-rule="evenodd"></path>
                                                </svg>
                                            @endif
                                        @else
                                            <svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 3a1 1 0 01.707.293l3 3a1 1 0 01-1.414 1.414L10 5.414 7.707 7.707a1 1 0 01-1.414-1.414l3-3A1 1 0 0110 3zm-3.707 9.293a1 1 0 011.414 0L10 14.586l2.293-2.293a1 1 0 011.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 01.707-1.707z" clip-rule="evenodd"></path>
                                            </svg>
                                        @endif
                                    </a>
                                </th>
                                <th class="text-left py-3 px-4 font-semibold text-gray-600">Lembur</th>
                                <th class="text-left py-3 px-4 font-semibold text-gray-600">
                                    <a href="{{ request()->fullUrlWithQuery(['sort_by' => 'total_gaji', 'sort_direction' => (request('sort_by') === 'total_gaji' && request('sort_direction') === 'asc') ? 'desc' : 'asc']) }}"
                                       class="flex items-center space-x-1 hover:text-primary transition-colors">
                                        <span>Total Gaji</span>
                                        @if(request('sort_by') === 'total_gaji')
                                            @if(request('sort_direction') === 'asc')
                                                <svg class="w-4 h-4 text-primary" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M14.707 12.707a1 1 0 01-1.414 0L10 9.414l-3.293 3.293a1 1 0 01-1.414-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 010 1.414z" clip-rule="evenodd"></path>
                                                </svg>
                                            @else
                                                <svg class="w-4 h-4 text-primary" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 010-1.414l-4-4a1 1 0 01-1.414 0l-4 4a1 1 0 111.414 1.414z" clip-rule="evenodd"></path>
                                                </svg>
                                            @endif
                                        @else
                                            <svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 3a1 1 0 01.707.293l3 3a1 1 0 01-1.414 1.414L10 5.414 7.707 7.707a1 1 0 01-1.414-1.414l3-3A1 1 0 0110 3zm-3.707 9.293a1 1 0 011.414 0L10 14.586l2.293-2.293a1 1 0 011.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 01.707-1.707z" clip-rule="evenodd"></path>
                                            </svg>
                                        @endif
                                    </a>
                                </th>
                                <th class="text-left py-3 px-4 font-semibold text-gray-600">Status</th>
                                <th class="text-left py-3 px-4 font-semibold text-gray-600">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($penggajian as $gaji)
                                <tr class="border-b border-gray-100 hover:bg-gray-50 transition-colors">
                                    <td class="py-3 px-4">
                                        <div class="flex items-center gap-3">
                                            <img src="{{ $gaji->user->avatar ? asset('storage/' . $gaji->user->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($gaji->user->name) . '&color=7F9CF5&background=EBF4FF&size=40' }}"
                                                alt="{{ $gaji->user->name }}" class="w-10 h-10 rounded-full">
                                            <div>
                                                <p class="font-semibold text-gray-900">{{ $gaji->user->name }}</p>
                                                <p class="text-sm text-gray-500">{{ $gaji->user->email }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-3 px-4">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                                                {{ $gaji->user->jabatan === 'Dokter' ? 'bg-purple-100 text-purple-700' : '' }}
                                                {{ $gaji->user->jabatan === 'Paramedis' ? 'bg-blue-100 text-blue-700' : '' }}
                                                {{ $gaji->user->jabatan === 'Tech' ? 'bg-green-100 text-green-700' : '' }}
                                                {{ $gaji->user->jabatan === 'FO' ? 'bg-orange-100 text-orange-700' : '' }}">
                                            {{ $gaji->user->jabatan }}
                                        </span>
                                    </td>
                                    <td class="py-3 px-4 text-gray-700">
                                        Rp {{ number_format($gaji->gaji_pokok, 0, ',', '.') }}
                                    </td>
                                    <td class="py-3 px-4 text-gray-700">
                                        <span class="text-red-600">- Rp {{ number_format($gaji->total_potongan_telat, 0, ',', '.') }}</span>
                                    </td>
                                    <td class="py-3 px-4 text-gray-700">
                                        <span class="text-green-600">+ Rp {{ number_format($gaji->total_insentif, 0, ',', '.') }}</span>
                                    </td>
                                    <td class="py-3 px-4 text-gray-700">
                                        <span class="text-blue-600">+ Rp {{ number_format($gaji->total_upah_lembur ?? 0, 0, ',', '.') }}</span>
                                        @if($gaji->total_menit_lembur ?? 0 > 0)
                                            <div class="text-xs text-gray-500">
                                                {{ floor(($gaji->total_menit_lembur ?? 0) / 60) }}j {{ ($gaji->total_menit_lembur ?? 0) % 60 }}m
                                            </div>
                                        @endif
                                    </td>
                                    <td class="py-3 px-4 text-gray-700">
                                        <span class="font-bold text-lg">Rp {{ number_format($gaji->total_gaji, 0, ',', '.') }}</span>
                                    </td>
                                    <td class="py-3 px-4">
                                        @if($gaji->status === 'final')
                                            <span class="px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700">Final</span>
                                        @else
                                            <span class="px-3 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-700">Draft</span>
                                        @endif
                                    </td>
                                    <td class="py-3 px-4">
                                        <div class="flex items-center gap-2">
                                            <a href="{{ route('penggajian.print', $gaji) }}" target="_blank"
                                                class="p-2 bg-green-100 hover:bg-green-200 text-green-600 rounded-lg transition-colors"
                                                title="Cetak">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z">
                                                    </path>
                                                </svg>
                                            </a>
                                            <a href="{{ route('penggajian.edit', $gaji) }}"
                                                class="p-2 bg-blue-100 hover:bg-blue-200 text-blue-600 rounded-lg transition-colors"
                                                title="Edit">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                                    </path>
                                                </svg>
                                            </a>
                                            <form action="{{ route('penggajian.destroy', $gaji) }}" method="POST" class="inline"
                                                onsubmit="return confirm('Apakah Anda yakin ingin menghapus penggajian ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="p-2 bg-red-100 hover:bg-red-200 text-red-600 rounded-lg transition-colors"
                                                    title="Hapus">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                        </path>
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-8 text-gray-500">
                    <svg class="h-12 w-12 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <p>Belum ada data penggajian</p>
                </div>
            @endif

            @if($penggajian->hasPages())
                <div class="mt-6">
                    <div class="flex justify-center">
                        <div class="flex space-x-1">
                            {{-- Previous Page Link --}}
                            @if ($penggajian->onFirstPage())
                                <span class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-not-allowed leading-5 rounded-l-xl">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                    </svg>
                                </span>
                            @else
                                <a href="{{ $penggajian->previousPageUrl() }}" class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 leading-5 rounded-l-xl hover:bg-primaryUltraLight hover:border-primary transition-colors duration-200">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                    </svg>
                                </a>
                            @endif

                            {{-- Pagination Elements --}}
                            @foreach ($penggajian->getUrlRange(1, $penggajian->lastPage()) as $page => $url)
                                @if ($page == $penggajian->currentPage())
                                    <span class="relative inline-flex items-center px-4 py-2 text-sm font-bold text-white bg-gradient-to-r from-primary to-primaryDark border border-primary leading-5 rounded-xl shadow-lg">
                                        {{ $page }}
                                    </span>
                                @else
                                    <a href="{{ $url }}" class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 leading-5 hover:bg-primaryUltraLight hover:border-primary hover:text-primary transition-all duration-200 rounded-xl">
                                        {{ $page }}
                                    </a>
                                @endif
                            @endforeach

                            {{-- Next Page Link --}}
                            @if ($penggajian->hasMorePages())
                                <a href="{{ $penggajian->nextPageUrl() }}" class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 leading-5 rounded-r-xl hover:bg-primaryUltraLight hover:border-primary transition-colors duration-200">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                                    </svg>
                                </a>
                            @else
                                <span class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-not-allowed leading-5 rounded-r-xl">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                                    </svg>
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
