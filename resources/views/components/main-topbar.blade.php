<div
    class="bg-gradient-to-br from-primary to-primaryDark shadow-xl transform transition-all duration-500 hover:shadow-2xl relative z-30">
    <div
        class="absolute inset-0 bg-gradient-to-r from-primary/20 via-primaryDark/10 to-primary/30 opacity-60 animate-pulse-slow">
    </div>
    <div class="flex w-full justify-between items-center p-6 relative z-10">
        <div class="flex flex-col animate-fade-in">
            <p
                class="title text-white font-extrabold text-2xl tracking-wide transition-transform duration-500 drop-shadow-lg">
                {{ $title }}
            </p>
            <p class="normal text-white opacity-90 transition-opacity duration-500 hover:opacity-100 italic">Selamat
                datang kembali!</p>
        </div>

        <div class="hidden sm:flex sm:items-center sm:ms-6 relative z-40">
            <x-dropdown align="right" width="48">
                <x-slot name="trigger">
                    <button
                        class="inline-flex items-center px-4 py-2 text-base  font-bold rounded-xl text-white bg-transparent  transition-all duration-500 transform hover:scale-[1.05] ">
                        <div class="text-white font-semibold">
                            {{ Auth::user()->name }}
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
                    <div class="relative z-50">
                        <x-dropdown-link :href="route('profile.edit')"
                            class="transition-all duration-500 hover:bg-primary hover:text-white font-semibold">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}" class="transition-all duration-500">
                            @csrf

                            <x-dropdown-link :href="route('logout')" onclick="event.preventDefault();
                                                    this.closest('form').submit();"
                                class="transition-all duration-500 hover:bg-red-500 hover:text-white font-semibold">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </div>
                </x-slot>
            </x-dropdown>
        </div>
    </div>
</div>
