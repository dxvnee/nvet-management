<div class="relative mb-5">
    <div
        class="bg-gradient-to-br rounded-xl from-primary to-primaryDark shadow-2xl transform transition-all duration-500 relative z-30">

        <div class="flex w-full justify-between items-center p-5 relative z-10">
            <div class="flex items-center gap-4">
                <button onclick="toggleSidebar()" name="button-sidebar"
                    class="text-white hover:text-primaryUltraLight transition-all duration-300 transform hover:scale-110 hover:-translate-x-1">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </button>
                <div class="flex flex-col animate-fade-in">
                    <p
                        class="title text-white font-extrabold text-2xl tracking-wide transition-transform duration-500 drop-shadow-lg">
                        {{ $title }}
                    </p>
                    <p class="normal text-white opacity-90 transition-opacity duration-500 hover:opacity-100 italic">
                        {{ $subtle }}
                    </p>
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button
                            class="inline-flex items-center px-4 py-2 text-base font-bold rounded-xl text-white bg-transparent  transition-all duration-500 transform hover:scale-[1.05] ">
                            <div class="flex items-center gap-3">
                                <img src="{{ auth()->user()->avatar ? asset('storage/' . auth()->user()->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) . '&color=7F9CF5&background=EBF4FF&size=32' }}"
                                    alt="Avatar" class="w-8 h-8 rounded-full border-2 border-white shadow-sm">
                                <div class="text-white font-semibold">
                                    @if(Auth::check())
                                        {{ Auth::user()->name }}
                                    @else
                                        Guest
                                    @endif
                                </div>
                            </div>
                            <div class="ms-2 transition-transform duration-500 group-hover:rotate-180">
                                <svg class="fill-current h-5 w-5 transition-colors duration-500"
                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <div class="relative z-50 m-2">
                            @if(Auth::check())
                                <x-dropdown-link :href="route('profile.show')"
                                    class="transition-all duration-500 hover:bg-primaryExtraLight font-semibold">
                                    {{ __('Profile') }}
                                </x-dropdown-link>

                                <!-- Authentication -->
                                <form method="POST" action="{{ route('logout') }}" class="transition-all duration-500">
                                    @csrf

                                    <x-dropdown-link :href="route('logout')" onclick="event.preventDefault();
                                                                                this.closest('form').submit();"
                                        class="transition-all duration-500 hover:bg-primaryExtraLight font-semibold">
                                        {{ __('Log Out') }}
                                    </x-dropdown-link>
                                </form>
                            @else
                                <x-dropdown-link :href="route('login')"
                                    class="transition-all duration-500 hover:bg-primary hover:text-white font-semibold">
                                    {{ __('Login') }}
                                </x-dropdown-link>
                            @endif
                        </div>
                    </x-slot>
                </x-dropdown>
            </div>
        </div>
    </div>
</div>