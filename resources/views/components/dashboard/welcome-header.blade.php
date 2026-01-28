@props([
    'title' => 'NVet Clinic & Lab',
    'subtitle' => null,
    'showAvatar' => false,
    'user' => null,
    'variant' => 'admin', // admin atau pegawai
])

<div
    class="relative overflow-hidden bg-gradient-to-br from-primary via-primaryDark to-primary rounded-3xl shadow-2xl {{ $variant === 'admin' ? 'p-8' : 'p-6 md:p-8' }} text-white animate-slide-up">
    {{-- Background Pattern --}}
    <div class="absolute inset-0 opacity-10">
        <div class="absolute -top-10 -right-10 w-40 h-40 bg-white rounded-full"></div>
        <div class="absolute -bottom-10 -left-10 w-32 h-32 bg-white rounded-full"></div>
        @if ($variant === 'admin')
            <div class="absolute top-1/2 left-1/3 w-20 h-20 bg-white rounded-full"></div>
        @endif
    </div>

    <div
        class="relative flex flex-col md:flex-row {{ $variant === 'admin' ? 'items-start md:items-center justify-between' : 'items-center' }} gap-{{ $variant === 'admin' ? '4' : '5' }}">
        @if ($showAvatar && $user)
            {{-- Avatar untuk Pegawai --}}
            <div class="relative">
                <img src="{{ $user->avatar ? asset('storage/' . $user->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&size=80&background=ffffff&color=0D9488' }}"
                    class="w-20 h-20 md:w-24 md:h-24 rounded-2xl border-4 border-white/30 shadow-xl">
                <span
                    class="absolute -bottom-1 -right-1 w-6 h-6 bg-emerald-400 rounded-full border-2 border-white flex items-center justify-center">
                    <x-icons.check-circle-solid class="w-3 h-3 text-white" />
                </span>
            </div>
        @else
            {{-- Icon untuk Admin --}}
            <div class="flex items-center gap-4">
                <div class="p-4 bg-white/20 backdrop-blur-sm rounded-2xl">
                    <x-icons.building-office class="w-10 h-10 text-white" />
                </div>
                <div>
                    <h2 class="text-2xl md:text-3xl font-bold mb-1">{{ $title }}</h2>
                    <p class="text-white/80 text-sm md:text-base flex items-center gap-2">
                        <x-icons.calendar class="w-4 h-4" />
                        {{ now()->locale('id')->isoFormat('dddd, D MMMM Y') }}
                    </p>
                </div>
            </div>
        @endif

        @if ($showAvatar && $user)
            {{-- Content untuk Pegawai --}}
            <div class="text-center md:text-left flex-1">
                <h2 class="text-2xl md:text-3xl font-bold mb-1">Halo, {{ $user->name }}! 👋</h2>
                <div class="flex flex-wrap items-center justify-center md:justify-start gap-3 mt-2">
                    <span
                        class="inline-flex items-center gap-1.5 px-3 py-1 bg-white/20 backdrop-blur-sm rounded-full text-sm">
                        <x-icons.briefcase class="w-4 h-4" />
                        {{ $user->jabatan }}
                    </span>
                    <span
                        class="inline-flex items-center gap-1.5 px-3 py-1 bg-white/20 backdrop-blur-sm rounded-full text-sm">
                        <x-icons.calendar class="w-4 h-4" />
                        {{ now()->locale('id')->isoFormat('dddd, D MMMM Y') }}
                    </span>
                </div>
            </div>
        @endif

        {{-- Clock & Status --}}
        <div class="flex items-center gap-6">
            <div
                class="hidden {{ $variant === 'admin' ? 'md:block' : 'lg:block' }} text-{{ $variant === 'admin' ? 'right' : 'center' }} bg-white/10 backdrop-blur-sm rounded-2xl {{ $variant === 'admin' ? 'px-6' : 'px-5' }} py-3">
                <p class="text-white/70 text-xs uppercase tracking-wider mb-1">
                    {{ $variant === 'admin' ? 'Waktu Sekarang' : 'Waktu' }}</p>
                <p class="{{ $variant === 'admin' ? 'text-3xl' : 'text-2xl' }} font-bold font-mono"
                    x-data="{ time: '' }" x-init="setInterval(() => time = new Date().toLocaleTimeString('id-ID'), 1000)" x-text="time"></p>
            </div>
            @if ($variant === 'admin')
                <div class="hidden lg:flex flex-col items-center bg-white/10 backdrop-blur-sm rounded-2xl px-4 py-3">
                    <span class="text-xs text-white/70 uppercase tracking-wider">Status</span>
                    <span class="text-sm font-semibold flex items-center gap-1">
                        <span class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></span>
                        Online
                    </span>
                </div>
            @endif
        </div>
    </div>
</div>
