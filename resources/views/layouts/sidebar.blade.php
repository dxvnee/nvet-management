<div
    class="m-5 overflow-hidden shadow-2xl-lr rounded-xl flex w-96 min-h-screen p-5 bg-white transform transition-all duration-300 hover:shadow-3xl">
    <div class="flex min-h-full w-full flex-col">

        <!-- Logo -->
        <div class="flex items-center gap-3 mb-8 animate-fade-in">
            <img src="{{ asset('images/logo3.png') }}" alt="logo"
                class="h-12 transition-transform duration-300 hover:scale-105">
            <p class="text-xl font-extrabold text-primaryDark transition-colors duration-300 hover:text-primary">Nvet
                Clinic & Lab</p>
        </div>

        <!-- Menu -->
        <nav class="flex flex-col gap-3 animate-slide-in-left">

            <!-- Dashboard -->
            <a href="{{ route('dashboard') }}"
                class="flex items-center gap-3 px-4 py-3 rounded-lg transition-all duration-300 text-primaryDark font-medium {{ request()->routeIs('dashboard') ? 'bg-primary text-white shadow-md transform scale-105' : 'hover:bg-primaryUltraLight hover:shadow-md hover:transform hover:scale-102' }}">
                <svg xmlns="http://www.w3.org/2000/svg"
                    class="h-6 w-6 transition-colors duration-300 {{ request()->routeIs('dashboard') ? 'text-white' : 'text-primaryDark' }}"
                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M3 12l9-9 9 9M4.5 10.5v10.5h15V10.5" />
                </svg>
                Dashboard
            </a>

            <!-- Users -->
            <a href="#"
                class="flex items-center gap-3 px-4 py-3 rounded-lg transition-all duration-300 text-primaryDark font-medium hover:bg-primaryUltraLight hover:shadow-md hover:transform hover:scale-102">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-primaryDark transition-colors duration-300"
                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M5.5 17a4.5 4.5 0 018.9 0M12 7.5a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                Users
            </a>

            <!-- Projects -->
            <a href="#"
                class="flex items-center gap-3 px-4 py-3 rounded-lg transition-all duration-300 text-primaryDark font-medium hover:bg-primaryUltraLight hover:shadow-md hover:transform hover:scale-102">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-primaryDark transition-colors duration-300"
                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M3 7h18M3 12h18M3 17h18" />
                </svg>
                Projects
            </a>

            <!-- Settings -->
            <a href="#"
                class="flex items-center gap-3 px-4 py-3 rounded-lg transition-all duration-300 text-primaryDark font-medium hover:bg-primaryUltraLight hover:shadow-md hover:transform hover:scale-102">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-primaryDark transition-colors duration-300"
                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M9.75 3a1.5 1.5 0 013 0v1.051a7.5 7.5 0 014.95 4.95H21a1.5 1.5 0 010 3h-1.301a7.5 7.5 0 01-4.95 4.95V21a1.5 1.5 0 01-3 0v-1.301a7.5 7.5 0 01-4.95-4.95H3a1.5 1.5 0 010-3h1.051a7.5 7.5 0 014.95-4.95V3z" />
                </svg>
                Settings
            </a>

        </nav>

        <!-- Footer / Logout -->
        <div class="mt-auto pt-8 animate-fade-in-up">
            <a href="#"
                class="flex items-center gap-3 px-4 py-3 rounded-lg transition-all duration-300 text-red-600 font-medium hover:bg-red-100 hover:shadow-md hover:transform hover:scale-102">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-500 transition-colors duration-300"
                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M15.75 9V5.25a2.25 2.25 0 00-2.25-2.25h-6A2.25 2.25 0 005.25 5.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9" />
                </svg>
                Logout
            </a>
        </div>

    </div>
</div>

<style>
    .animate-fade-in {
        animation: fadeIn 0.8s ease-in-out;
    }

    .animate-slide-in-left {
        animation: slideInLeft 0.6s ease-out 0.2s both;
    }

    .animate-fade-in-up {
        animation: fadeInUp 0.6s ease-out 0.4s both;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
        }

        to {
            opacity: 1;
        }
    }

    @keyframes slideInLeft {
        from {
            opacity: 0;
            transform: translateX(-30px);
        }

        to {
            opacity: 1;
            transform: translateX(0);
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
</style>
