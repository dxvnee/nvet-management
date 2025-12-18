<x-app-layout>
    <x-slot name="header">Persetujuan Lembur</x-slot>
    <x-slot name="subtle">Kelola pengajuan lembur pegawai</x-slot>

    <div class="space-y-6">
        <div class="bg-white rounded-2xl shadow-xl p-6 animate-slide-up">
            <div class="flex items-center gap-3 mb-6">
                <div class="p-3 bg-gradient-to-br from-primary to-primaryDark rounded-xl shadow-lg">
                    <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h2 class="text-xl font-bold text-gray-800">Daftar Lembur</h2>
            </div>

            @if($lemburs->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b border-gray-200">
                                <th class="text-left py-3 px-4 font-semibold text-gray-600">Pegawai</th>
                                <th class="text-left py-3 px-4 font-semibold text-gray-600">Waktu</th>
                                <th class="text-left py-3 px-4 font-semibold text-gray-600">Durasi</th>
                                <th class="text-left py-3 px-4 font-semibold text-gray-600">Keterangan</th>
                                <th class="text-left py-3 px-4 font-semibold text-gray-600">Foto</th>
                                <th class="text-left py-3 px-4 font-semibold text-gray-600">Status</th>
                                <th class="text-left py-3 px-4 font-semibold text-gray-600">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($lemburs as $lembur)
                                <tr class="border-b border-gray-100 hover:bg-gray-50 transition-colors">
                                    <td class="py-3 px-4">
                                        <div class="flex items-center gap-3">
                                            <img src="{{ $lembur->user->avatar ? asset('storage/' . $lembur->user->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($lembur->user->name) . '&color=7F9CF5&background=EBF4FF&size=40' }}"
                                                alt="{{ $lembur->user->name }}" class="w-10 h-10 rounded-full">
                                            <div>
                                                <p class="font-semibold text-gray-900">{{ $lembur->user->name }}</p>
                                                <p class="text-sm text-gray-500">{{ $lembur->user->jabatan }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-3 px-4 text-gray-700">
                                        <div>{{ $lembur->tanggal->format('d M Y') }}</div>
                                        <div class="text-sm">{{ $lembur->jam_mulai->format('H:i') }} -
                                            {{ $lembur->jam_selesai ? $lembur->jam_selesai->format('H:i') : '...' }}</div>
                                    </td>
                                    <td class="py-3 px-4 text-gray-700">
                                        {{ $lembur->durasi_menit > 0 ? floor($lembur->durasi_menit / 60) . 'j ' . ($lembur->durasi_menit % 60) . 'm' : '-' }}
                                    </td>
                                    <td class="py-3 px-4 text-gray-700 max-w-xs truncate">
                                        {{ $lembur->keterangan ?? '-' }}
                                    </td>
                                    <td class="py-3 px-4">
                                        @if($lembur->foto_mulai || $lembur->foto_selesai)
                                            <button onclick="openPhotoModal('{{ $lembur->id }}', '{{ $lembur->foto_mulai }}', '{{ $lembur->foto_selesai }}', '{{ $lembur->user->name }}', '{{ $lembur->tanggal->format('d M Y') }}')"
                                                class="p-2 bg-blue-100 hover:bg-blue-200 text-blue-600 rounded-lg transition-colors"
                                                title="Lihat Foto">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                </svg>
                                            </button>
                                        @else
                                            <span class="text-xs text-gray-400">-</span>
                                        @endif
                                    </td>
                                    <td class="py-3 px-4">
                                        @if($lembur->status === 'approved')
                                            <span class="px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-700">Disetujui</span>
                                        @elseif($lembur->status === 'rejected')
                                            <span class="px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-700">Ditolak</span>
                                        @else
                                            <span class="px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-700">Menunggu</span>
                                        @endif
                                    </td>
                                    <td class="py-3 px-4">
                                        @if($lembur->status === 'pending' && $lembur->jam_selesai)
                                            <div class="flex items-center gap-2">
                                                <form action="{{ route('lembur.approve', $lembur) }}" method="POST">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit"
                                                        class="p-2 bg-green-100 hover:bg-green-200 text-green-600 rounded-lg transition-colors"
                                                        title="Setujui">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                        </svg>
                                                    </button>
                                                </form>
                                                <button onclick="openRejectModal('{{ route('lembur.reject', $lembur) }}')"
                                                    class="p-2 bg-red-100 hover:bg-red-200 text-red-600 rounded-lg transition-colors"
                                                    title="Tolak">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                    </svg>
                                                </button>
                                            </div>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-8 text-gray-500">
                    <svg class="h-12 w-12 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <p>Belum ada data lembur</p>
                </div>
            @endif

            @if($lemburs->hasPages())
                <div class="mt-6">
                    <div class="flex justify-center">
                        <div class="flex space-x-1">
                            {{-- Previous Page Link --}}
                            @if ($lemburs->onFirstPage())
                                <span class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-not-allowed leading-5 rounded-l-xl">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                    </svg>
                                </span>
                            @else
                                <a href="{{ $lemburs->previousPageUrl() }}" class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 leading-5 rounded-l-xl hover:bg-primaryUltraLight hover:border-primary transition-colors duration-200">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                    </svg>
                                </a>
                            @endif

                            {{-- Pagination Elements --}}
                            @foreach ($lemburs->getUrlRange(1, $lemburs->lastPage()) as $page => $url)
                                @if ($page == $lemburs->currentPage())
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
                            @if ($lemburs->hasMorePages())
                                <a href="{{ $lemburs->nextPageUrl() }}" class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 leading-5 rounded-r-xl hover:bg-primaryUltraLight hover:border-primary transition-colors duration-200">
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

    <!-- Reject Modal -->
    <div id="rejectModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center">
        <div class="bg-white rounded-xl p-6 w-full max-w-md mx-4">
            <h3 class="text-lg font-bold mb-4">Tolak Pengajuan Lembur</h3>
            <form id="rejectForm" method="POST">
                @csrf
                @method('PATCH')
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Alasan Penolakan</label>
                    <textarea name="alasan" rows="3" required
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary"></textarea>
                </div>
                <div class="flex justify-end gap-3">
                    <button type="button" onclick="document.getElementById('rejectModal').classList.add('hidden')"
                        class="px-4 py-2 text-gray-600 hover:bg-gray-100 rounded-lg">Batal</button>
                    <button type="submit"
                        class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">Tolak</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Photo Modal -->
    <div id="photo-modal" class="fixed inset-0 flex items-center justify-center z-50 hidden opacity-0 transition-all duration-300 ease-out p-4">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-4xl transform scale-95 transition-all duration-300 ease-out">
            <div class="p-6">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h3 class="text-xl font-bold text-gray-800">Foto Lembur</h3>
                        <p class="text-gray-600 text-sm" id="photo-subtitle"></p>
                    </div>
                    <button onclick="closePhotoModal()" class="text-gray-400 hover:text-gray-600 transition-colors">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <div class="text-center">
                    <!-- Foto Lembur -->
                    <div class="space-y-3">
                        <h4 class="font-semibold text-gray-700 flex items-center justify-center gap-2">
                            <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            Foto Lembur
                        </h4>
                        <div class="relative bg-gray-100 rounded-xl overflow-hidden max-w-md mx-auto">
                            <img id="photo-lembur" class="w-full h-80 object-cover opacity-0 transform scale-95 transition-all duration-500 ease-out delay-150" alt="Foto Lembur">
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script>
        function openRejectModal(url) {
            document.getElementById('rejectForm').action = url;
            document.getElementById('rejectModal').classList.remove('hidden');
        }

        function openPhotoModal(lemburId, fotoMulai, fotoSelesai, namaPegawai, tanggal) {
            const modal = document.getElementById('photo-modal');
            const modalImage = document.getElementById('photo-lembur');

            document.getElementById('photo-subtitle').textContent = namaPegawai + ' - ' + tanggal;

            // Prioritize foto_selesai, fallback to foto_mulai
            const fotoToShow = fotoSelesai || fotoMulai;

            if (fotoToShow) {
                modalImage.src = '/storage/' + fotoToShow;
                modalImage.style.display = 'block';
            } else {
                modalImage.style.display = 'none';
            }

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
            const modalImage = document.getElementById('photo-lembur');

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

        // Close modals when clicking outside
        document.getElementById('rejectModal').addEventListener('click', function(e) {
            if (e.target === this) {
                this.classList.add('hidden');
            }
        });

        document.getElementById('photo-modal').addEventListener('click', function(e) {
            if (e.target === this) {
                closePhotoModal();
            }
        });

        // Close modals with Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                if (!document.getElementById('rejectModal').classList.contains('hidden')) {
                    document.getElementById('rejectModal').classList.add('hidden');
                }
                if (!document.getElementById('photo-modal').classList.contains('hidden')) {
                    closePhotoModal();
                }
            }
        });
    </script>
</x-app-layout>
