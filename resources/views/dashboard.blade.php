<x-app-layout>
    <x-slot name="header">Dashboard</x-slot>

    <div
        class="py-12 animate-fade-in bg-gradient-to-br from-primaryUltraLight via-white to-primaryUltraLight min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            <!-- Welcome Section -->
            <div
                class="bg-white backdrop-blur-lg shadow-2xl overflow-hidden sm:rounded-2xl  animate-slide-up ">
                <div class="absolute inset-0 bg-gradient-to-r from-primary/10 to-primaryDark/10 animate-pulse-slow">
                </div>
                <div class="relative p-8">
                    <div class="flex items-center space-x-4 mb-4">
                        <div
                            class="w-12 h-12 bg-gradient-to-br from-primary to-primaryDark rounded-full flex items-center justify-center animate-bounce-slow">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                        </div>
                        <div>
                            <h2
                                class="text-3xl font-bold bg-gradient-to-r from-primary to-primaryDark bg-clip-text text-transparent">
                                Selamat Datang di NVet Clinic & Lab</h2>
                            <p class="text-gray-600 text-lg">Kelola klinik dan laboratorium hewan peliharaan Anda dengan
                                mudah dan efisien.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <div
                    class="bg-white/70 backdrop-blur-lg overflow-hidden shadow-xl sm:rounded-2xl border border-white/30 hover:shadow-2xl transition-all duration-500 animate-slide-up-delay-1 hover:transform hover:scale-105 relative group">
                    <div
                        class="absolute inset-0 bg-gradient-to-br from-primary/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500">
                    </div>
                    <div class="relative p-6">
                        <div class="flex items-center justify-between mb-4">
                            <div class="p-3 bg-gradient-to-br from-primary to-primaryDark rounded-xl shadow-lg">
                                <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                                    </path>
                                </svg>
                            </div>
                            <div class="text-right">
                                <div class="text-2xl font-bold text-gray-900 animate-count-up">1,234</div>
                            </div>
                        </div>
                        <h3 class="text-sm font-semibold text-gray-600 uppercase tracking-wide">Total Pasien</h3>
                        <div class="mt-2 w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-gradient-to-r from-primary to-primaryDark h-2 rounded-full animate-progress"
                                style="width: 85%"></div>
                        </div>
                    </div>
                </div>

                <div
                    class="bg-white/70 backdrop-blur-lg flow-hidden shadow-xl sm:rounded-2xl border border-white/30 hover:shadow-2xl transition-all duration-500 animate-slide-up-delay-2 hover:transform hover:scale-105 relative group">
                    <div
                        class="absolute inset-0 bg-gradient-to-br from-green-500/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500">
                    </div>
                    <div class="relative p-6">
                        <div class="flex items-center justify-between mb-4">
                            <div class="p-3 bg-gradient-to-br from-green-500 to-green-600 rounded-xl shadow-lg">
                                <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div class="text-right">
                                <div class="text-2xl font-bold text-gray-900 animate-count-up">45</div>
                            </div>
                        </div>
                        <h3 class="text-sm font-semibold text-gray-600 uppercase tracking-wide">Kunjungan Hari Ini</h3>
                        <div class="mt-2 w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-gradient-to-r from-green-500 to-green-600 h-2 rounded-full animate-progress"
                                style="width: 65%"></div>
                        </div>
                    </div>
                </div>

                <div
                    class="bg-white/70 backdrop-blur-lg overflow-hidden shadow-xl sm:rounded-2xl border border-white/30 hover:shadow-2xl transition-all duration-500 animate-slide-up-delay-3 hover:transform hover:scale-105 relative group">
                    <div
                        class="absolute inset-0 bg-gradient-to-br from-blue-500/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500">
                    </div>
                    <div class="relative p-6">
                        <div class="flex items-center justify-between mb-4">
                            <div class="p-3 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl shadow-lg">
                                <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1">
                                    </path>
                                </svg>
                            </div>
                            <div class="text-right">
                                <div class="text-2xl font-bold text-gray-900 animate-count-up">Rp 12,500,000</div>
                            </div>
                        </div>
                        <h3 class="text-sm font-semibold text-gray-600 uppercase tracking-wide">Pendapatan Bulan Ini
                        </h3>
                        <div class="mt-2 w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-gradient-to-r from-blue-500 to-blue-600 h-2 rounded-full animate-progress"
                                style="width: 90%"></div>
                        </div>
                    </div>
                </div>

                <div
                    class="bg-white/70 backdrop-blur-lg overflow-hidden shadow-xl sm:rounded-2xl border border-white/30 hover:shadow-2xl transition-all duration-500 animate-slide-up-delay-4 hover:transform hover:scale-105 relative group">
                    <div
                        class="absolute inset-0 bg-gradient-to-br from-yellow-500/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500">
                    </div>
                    <div class="relative p-6">
                        <div class="flex items-center justify-between mb-4">
                            <div
                                class="p-3 bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-xl shadow-lg animate-pulse">
                                <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z">
                                    </path>
                                </svg>
                            </div>
                            <div class="text-right">
                                <div class="text-2xl font-bold text-gray-900 animate-count-up">3</div>
                            </div>
                        </div>
                        <h3 class="text-sm font-semibold text-gray-600 uppercase tracking-wide">Peringatan Stok</h3>
                        <div class="mt-2 w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-gradient-to-r from-yellow-500 to-yellow-600 h-2 rounded-full animate-progress"
                                style="width: 25%"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Activities -->
            <div
                class="bg-white/70 backdrop-blur-lg shadow-xl sm:rounded-2xl border border-white/30 animate-slide-up-delay-5">
                <div class="p-8">
                    <div class="flex items-center space-x-3 mb-6">
                        <div
                            class="w-10 h-10 bg-gradient-to-br from-primary to-primaryDark rounded-full flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900">Aktivitas Terbaru</h3>
                    </div>
                    <div class="space-y-6">
                        <div
                            class="flex items-center space-x-4 p-4 bg-gradient-to-r from-primary/5 to-transparent rounded-xl hover:shadow-md transition-all duration-300 animate-fade-in-up-delay-1">
                            <div class="flex-shrink-0">
                                <div
                                    class="w-12 h-12 bg-gradient-to-br from-primary to-primaryDark rounded-full flex items-center justify-center shadow-lg">
                                    <span class="text-white text-sm font-bold">JD</span>
                                </div>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-base font-semibold text-gray-900">Dr. John Doe</p>
                                <p class="text-sm text-gray-600">Melakukan pemeriksaan pada kucing persia</p>
                            </div>
                            <div class="text-sm text-gray-500 bg-gray-100 px-3 py-1 rounded-full">2 jam yang lalu</div>
                        </div>
                        <div
                            class="flex items-center space-x-4 p-4 bg-gradient-to-r from-green-500/5 to-transparent rounded-xl hover:shadow-md transition-all duration-300 animate-fade-in-up-delay-2">
                            <div class="flex-shrink-0">
                                <div
                                    class="w-12 h-12 bg-gradient-to-br from-green-500 to-green-600 rounded-full flex items-center justify-center shadow-lg">
                                    <span class="text-white text-sm font-bold">SM</span>
                                </div>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-base font-semibold text-gray-900">Sarah Miller</p>
                                <p class="text-sm text-gray-600">Menambahkan stok obat baru</p>
                            </div>
                            <div class="text-sm text-gray-500 bg-gray-100 px-3 py-1 rounded-full">4 jam yang lalu</div>
                        </div>
                        <div
                            class="flex items-center space-x-4 p-4 bg-gradient-to-r from-blue-500/5 to-transparent rounded-xl hover:shadow-md transition-all duration-300 animate-fade-in-up-delay-3">
                            <div class="flex-shrink-0">
                                <div
                                    class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center shadow-lg">
                                    <span class="text-white text-sm font-bold">AK</span>
                                </div>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-base font-semibold text-gray-900">Anna Kim</p>
                                <p class="text-sm text-gray-600">Menyelesaikan laporan laboratorium</p>
                            </div>
                            <div class="text-sm text-gray-500 bg-gray-100 px-3 py-1 rounded-full">6 jam yang lalu</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .animate-fade-in {
            animation: fadeIn 1s ease-out;
        }

        .animate-slide-up {
            animation: slideUp 0.8s ease-out;
        }

        .animate-slide-up-delay-1 {
            animation: slideUp 0.8s ease-out 0.1s both;
        }

        .animate-slide-up-delay-2 {
            animation: slideUp 0.8s ease-out 0.2s both;
        }

        .animate-slide-up-delay-3 {
            animation: slideUp 0.8s ease-out 0.3s both;
        }

        .animate-slide-up-delay-4 {
            animation: slideUp 0.8s ease-out 0.4s both;
        }

        .animate-slide-up-delay-5 {
            animation: slideUp 0.8s ease-out 0.5s both;
        }

        .animate-fade-in-up-delay-1 {
            animation: fadeInUp 0.6s ease-out 0.6s both;
        }

        .animate-fade-in-up-delay-2 {
            animation: fadeInUp 0.6s ease-out 0.7s both;
        }

        .animate-fade-in-up-delay-3 {
            animation: fadeInUp 0.6s ease-out 0.8s both;
        }

        .animate-pulse-slow {
            animation: pulse 3s ease-in-out infinite;
        }

        .animate-bounce-slow {
            animation: bounce 2s ease-in-out infinite;
        }

        .animate-count-up {
            animation: countUp 2s ease-out forwards;
        }

        .animate-progress {
            animation: progressFill 1.5s ease-out forwards;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: scale(0.95);
            }

            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(40px) scale(0.95);
            }

            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes countUp {
            from {
                transform: scale(0.5);
                opacity: 0;
            }

            to {
                transform: scale(1);
                opacity: 1;
            }
        }

        @keyframes progressFill {
            from {
                width: 0%;
            }

            to {
                width: var(--progress-width, 85%);
            }
        }
    </style>
</x-app-layout>
