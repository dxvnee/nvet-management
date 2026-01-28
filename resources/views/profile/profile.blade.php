<x-app-layout>
    <x-slot name="header">Profil</x-slot>
    <x-slot name="subtle">Kelola informasi profil Anda</x-slot>

    <div class="space-y-6">
        <!-- Profile Card -->
        <div class="bg-white rounded-2xl shadow-xl p-8 animate-slide-up">
            <div class="flex flex-col lg:flex-row gap-8">
                <!-- Profile Photo Section -->
                <div class="flex flex-col items-center lg:items-start">
                    <div class="relative">
                        <div class="w-32 h-32 rounded-full overflow-hidden border-4 border-primary shadow-lg">
                            @if(auth()->user()->avatar && Storage::disk('public')->exists(auth()->user()->avatar))
                                <img id="profile-preview" src="{{ 'storage/' . auth()->user()->avatar }}"
                                    alt="Profile Photo" class="w-full h-full object-cover">
                            @else
                                <img id="profile-preview"
                                    src="{{ 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) . '&color=7F9CF5&background=EBF4FF&size=128' }}"
                                    alt="Profile Photo" class="w-full h-full object-cover">
                            @endif
                        </div>
                        <input type="file" id="avatar-file-input" name="avatar" accept="image/*" class="hidden"
                            form="profile-form" onchange="handleFileSelection(this)">
                        <button type="button" onclick="document.getElementById('avatar-file-input').click()"
                            class="absolute bottom-0 right-0 bg-primary hover:bg-primaryDark text-white p-3 rounded-full shadow-lg hover:shadow-xl transform hover:scale-110 transition-all duration-300">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                </path>
                            </svg>
                        </button>
                    </div>

                </div>

                <!-- Profile Info Section -->
                <div class="flex-1">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Name -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap</label>
                            <div class="bg-gray-50 rounded-xl px-4 py-3 border border-gray-200">
                                <p class="text-gray-900 font-medium">{{ auth()->user()->name }}</p>
                            </div>
                        </div>

                        <!-- Email -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                            <div class="bg-gray-50 rounded-xl px-4 py-3 border border-gray-200">
                                <p class="text-gray-900">{{ auth()->user()->email }}</p>
                            </div>
                        </div>

                        <!-- Jabatan -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Jabatan</label>
                            <div class="bg-gray-50 rounded-xl px-4 py-3 border border-gray-200">
                                <div class="flex items-center gap-2">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                                        {{ auth()->user()->jabatan === 'Dokter' ? 'bg-purple-100 text-purple-700' : '' }}
                                        {{ auth()->user()->jabatan === 'Paramedis' ? 'bg-blue-100 text-blue-700' : '' }}
                                        {{ auth()->user()->jabatan === 'Tech' ? 'bg-green-100 text-green-700' : '' }}
                                        {{ auth()->user()->jabatan === 'FO' ? 'bg-orange-100 text-orange-700' : '' }}">
                                        {{ auth()->user()->jabatan }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Member Since -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Bergabung Sejak</label>
                            <div class="bg-gray-50 rounded-xl px-4 py-3 border border-gray-200">
                                <p class="text-gray-900">{{ auth()->user()->created_at->format('d M Y') }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Stats Cards -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-8">
                        <!-- Total Absen Bulan Ini -->
                        <div class="bg-gradient-to-r from-blue-50 to-blue-100 rounded-xl p-4 border border-blue-200">
                            <div class="flex items-center gap-3">
                                <div class="p-2 bg-blue-500 rounded-lg">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                        </path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-blue-700">Absen Bulan Ini</p>
                                    <p class="text-2xl font-bold text-blue-800">{{ $stats['bulan_ini'] ?? 0 }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Total Jam Kerja -->
                        <div class="bg-gradient-to-r from-green-50 to-green-100 rounded-xl p-4 border border-green-200">
                            <div class="flex items-center gap-3">
                                <div class="p-2 bg-green-500 rounded-lg">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-green-700">Total Jam Kerja</p>
                                    <p class="text-2xl font-bold text-green-800">{{ $stats['total_jam'] ?? 0 }}j</p>
                                </div>
                            </div>
                        </div>

                        <!-- Status Terakhir -->
                        <div
                            class="bg-gradient-to-r from-red-50 to-red-100 rounded-xl p-4 border border-red-200">
                            <div class="flex items-center gap-3">
                                <div class="p-2 bg-red-500 rounded-lg">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-red-700">Tidak Hadir</p>
                                    <p class="text-lg font-bold text-red-800">
                                        {{ $stats['tidak_hadir'] ?? 0 }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Edit Profile Form -->
        <div class="bg-white rounded-2xl shadow-xl p-8 animate-slide-up-delay-1">
            <div class="flex items-center gap-3 mb-6">
                <div class="p-3 bg-gradient-to-br from-primary to-primaryDark rounded-xl shadow-lg">
                    <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                        </path>
                    </svg>
                </div>
                <div>
                    <h2 class="text-xl font-bold text-gray-800">Edit Profil</h2>
                    <p class="text-gray-500 text-sm">Perbarui informasi profil Anda</p>
                </div>
            </div>

            <form id="profile-form" method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data"
                class="space-y-6">
                @csrf
                @method('patch')



                <!-- Name -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap</label>
                    <input id="name" name="name" type="text" value="{{ old('name', auth()->user()->name) }}"
                        class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all @error('name') border-red-500 @enderror"
                        required>
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                    <input id="email" name="email" type="email" value="{{ old('email', auth()->user()->email) }}"
                        class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all @error('email') border-red-500 @enderror"
                        required>
                    @error('email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Jabatan (Read Only) -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Jabatan</label>
                    <div class="bg-gray-50 rounded-xl px-4 py-3 border border-gray-200">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                            {{ auth()->user()->jabatan === 'Dokter' ? 'bg-purple-100 text-purple-700' : '' }}
                            {{ auth()->user()->jabatan === 'Paramedis' ? 'bg-blue-100 text-blue-700' : '' }}
                            {{ auth()->user()->jabatan === 'Tech' ? 'bg-green-100 text-green-700' : '' }}
                            {{ auth()->user()->jabatan === 'FO' ? 'bg-orange-100 text-orange-700' : '' }}">
                            {{ auth()->user()->jabatan }}
                        </span>
                        <p class="text-xs text-gray-500 mt-1">Jabatan hanya dapat diubah oleh administrator</p>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="flex justify-end">
                    <button type="submit"
                        class="px-8 py-3 bg-gradient-to-r from-primary to-primaryDark text-white font-bold rounded-xl shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-300">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>

        <!-- Change Password Form -->
        <div class="bg-white rounded-2xl shadow-xl p-8 animate-slide-up-delay-2">
            <div class="flex items-center gap-3 mb-6">
                <div class="p-3 bg-gradient-to-br from-red-500 to-red-600 rounded-xl shadow-lg">
                    <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                        </path>
                    </svg>
                </div>
                <div>
                    <h2 class="text-xl font-bold text-gray-800">Ganti Password</h2>
                    <p class="text-gray-500 text-sm">Pastikan akun Anda menggunakan password yang kuat</p>
                </div>
            </div>

            <form method="POST" action="{{ route('profile.password.update') }}" class="space-y-6">
                @csrf
                @method('put')

                <!-- Current Password -->
                <div>
                    <label for="current_password" class="block text-sm font-medium text-gray-700 mb-2">Password Saat
                        Ini</label>
                    <div class="relative">
                        <input id="current_password" name="current_password" type="password"
                            class="w-full px-4 py-3 pr-12 rounded-xl border border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all @error('current_password') border-red-500 @enderror"
                            required>
                        <button type="button" onclick="togglePassword('current_password')"
                            class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                            <svg id="eye-current_password" class="w-5 h-5" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                </path>
                            </svg>
                        </button>
                    </div>
                    @error('current_password')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- New Password -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Password Baru</label>
                    <div class="relative">
                        <input id="password" name="password" type="password"
                            class="w-full px-4 py-3 pr-12 rounded-xl border border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all @error('password') border-red-500 @enderror"
                            required>
                        <button type="button" onclick="togglePassword('password')"
                            class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                            <svg id="eye-password" class="w-5 h-5" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                </path>
                            </svg>
                        </button>
                    </div>
                    <p class="mt-1 text-xs text-gray-500">Minimal 8 karakter</p>
                    @error('password')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Confirm Password -->
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">Konfirmasi
                        Password Baru</label>
                    <div class="relative">
                        <input id="password_confirmation" name="password_confirmation" type="password"
                            class="w-full px-4 py-3 pr-12 rounded-xl border border-gray-300 focus:border-primary focus:ring-2 focus:ring-primary/20 transition-all"
                            required>
                        <button type="button" onclick="togglePassword('password_confirmation')"
                            class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                            <svg id="eye-password_confirmation" class="w-5 h-5" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                </path>
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="flex justify-end">
                    <button type="submit"
                        class="px-8 py-3 bg-gradient-to-r from-red-500 to-red-600 text-white font-bold rounded-xl shadow-lg hover:shadow-xl transform hover:scale-105 transition-all duration-300">
                        Ganti Password
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Handle file selection for avatar upload
        function handleFileSelection(input) {
            if (input.files && input.files[0]) {
                const file = input.files[0];

                // Validate file type
                if (!file.type.startsWith('image/')) {
                    showNotification('File harus berupa gambar!', 'error');
                    input.value = '';
                    return;
                }

                // Validate file size (max 2MB)
                if (file.size > 2 * 1024 * 1024) {
                    showNotification('Ukuran file maksimal 2MB!', 'error');
                    input.value = '';
                    return;
                }

                // Preview the image
                const reader = new FileReader();
                reader.onload = function (e) {
                    document.getElementById('profile-preview').src = e.target.result;
                    showNotification('Foto berhasil dipilih! Akan otomatis di-crop menjadi square sebelum disimpan.', 'success');
                };
                reader.readAsDataURL(file);
            }
        }

        function showNotification(message, type) {
            // Create notification element
            const notification = document.createElement('div');
            notification.className = `fixed top-4 right-4 px-6 py-4 rounded-xl shadow-lg z-50 transform translate-x-full transition-transform duration-300 ${type === 'success' ? 'bg-green-500 text-white' : 'bg-red-500 text-white'
                }`;
            notification.innerHTML = `
                <div class="flex items-center gap-3">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="${type === 'success' ? 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z' : 'M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z'
                }"></path>
                    </svg>
                    <span>${message}</span>
                </div>
            `;

            document.body.appendChild(notification);

            // Animate in
            setTimeout(() => {
                notification.classList.remove('translate-x-full');
            }, 100);

            // Auto remove after 3 seconds
            setTimeout(() => {
                notification.classList.add('translate-x-full');
                setTimeout(() => {
                    document.body.removeChild(notification);
                }, 300);
            }, 3000);
        }

        // Toggle password visibility
        function togglePassword(inputId) {
            const input = document.getElementById(inputId);
            const eyeIcon = document.getElementById('eye-' + inputId);

            if (input.type === 'password') {
                input.type = 'text';
                eyeIcon.innerHTML = `
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"></path>
                `;
            } else {
                input.type = 'password';
                eyeIcon.innerHTML = `
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                `;
            }
        }
    </script>
</x-app-layout>
