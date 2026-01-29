{{-- Photo Modal Component --}}
@props([
    'id' => 'photo-modal',
])

<div id="{{ $id }}"
    class="fixed inset-0 flex items-center justify-center z-50 hidden opacity-0 transition-all duration-300 ease-out">
    <div
        class="bg-white rounded-2xl shadow-2xl max-w-2xl w-full mx-4 overflow-hidden transform scale-95 transition-all duration-300 ease-out">
        <div class="p-4 bg-gradient-to-r from-primary to-primaryDark text-white flex justify-between items-center">
            <div>
                <h3 id="{{ $id }}-title" class="text-lg font-bold">Foto Absensi</h3>
                <p id="{{ $id }}-subtitle" class="text-sm opacity-90"></p>
            </div>
            <button onclick="closePhotoModal('{{ $id }}')"
                class="p-1 hover:bg-white/20 rounded-lg transition-colors">
                <x-icons.x-mark class="w-6 h-6" />
            </button>
        </div>

        <div class="p-4">
            <div class="bg-gray-100 rounded-xl overflow-hidden">
                <img id="{{ $id }}-image" src="" alt="Foto Absensi"
                    class="w-full h-auto max-h-96 object-contain opacity-0 transform scale-95 transition-all duration-500 ease-out delay-150">
            </div>

            <div class="mt-4 flex justify-end gap-3">
                <button onclick="closePhotoModal('{{ $id }}')"
                    class="px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white font-bold rounded-lg transition-colors">
                    Tutup
                </button>
                <a id="{{ $id }}-download" href="" download
                    class="px-4 py-2 bg-primary hover:bg-primaryDark text-white font-bold rounded-lg transition-colors">
                    Download
                </a>
            </div>
        </div>
    </div>
</div>

@once
    @push('scripts')
        <script>
            function openPhotoModal(imageSrc, title, subtitle, modalId = 'photo-modal') {
                const modal = document.getElementById(modalId);
                const modalImage = document.getElementById(`${modalId}-image`);

                modalImage.src = imageSrc;
                document.getElementById(`${modalId}-title`).textContent = title;
                document.getElementById(`${modalId}-subtitle`).textContent = subtitle;
                document.getElementById(`${modalId}-download`).href = imageSrc;

                modal.classList.remove('hidden');
                modal.offsetHeight;
                modal.classList.add('opacity-100');
                modal.querySelector('.bg-white').classList.add('scale-100');

                modalImage.onload = function() {
                    setTimeout(() => {
                        modalImage.classList.add('opacity-100', 'scale-100');
                    }, 100);
                };

                if (modalImage.complete) {
                    setTimeout(() => {
                        modalImage.classList.add('opacity-100', 'scale-100');
                    }, 100);
                }
            }

            function closePhotoModal(modalId = 'photo-modal') {
                const modal = document.getElementById(modalId);
                const modalImage = document.getElementById(`${modalId}-image`);

                modal.classList.remove('opacity-100');
                modal.querySelector('.bg-white').classList.remove('scale-100');
                modalImage.classList.remove('opacity-100', 'scale-100');

                setTimeout(() => {
                    modal.classList.add('hidden');
                    modalImage.src = '';
                }, 300);
            }

            document.addEventListener('DOMContentLoaded', function() {
                document.querySelectorAll('[id$="-modal"]').forEach(modal => {
                    modal.addEventListener('click', function(e) {
                        if (e.target === this) {
                            closePhotoModal(this.id);
                        }
                    });
                });

                document.addEventListener('keydown', function(e) {
                    if (e.key === 'Escape') {
                        document.querySelectorAll('[id$="-modal"]:not(.hidden)').forEach(modal => {
                            closePhotoModal(modal.id);
                        });
                    }
                });
            });
        </script>
    @endpush
@endonce
