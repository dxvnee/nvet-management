@props([
    'href',
    'title',
    'subtitle',
    'gradient' => 'from-primary to-primaryDark',
    'hoverBorder' => 'hover:border-primary/30',
    'hoverText' => 'group-hover:text-primary',
    'bgGradient' => 'from-primary/10',
])

<a href="{{ $href }}"
    class="group relative overflow-hidden bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 p-6 border border-gray-100 {{ $hoverBorder }}">
    <div class="absolute top-0 right-0 w-20 h-20 bg-gradient-to-br {{ $bgGradient }} to-transparent rounded-bl-full">
    </div>
    <div class="relative">
        <div
            class="p-3 bg-gradient-to-br {{ $gradient }} rounded-xl w-fit mb-4 shadow-lg group-hover:scale-110 group-hover:rotate-3 transition-all duration-300">
            {{ $icon }}
        </div>
        <h4 class="font-bold text-gray-800 {{ $hoverText }} transition-colors">{{ $title }}</h4>
        <p class="text-sm text-gray-500 mt-1">{{ $subtitle }}</p>
    </div>
</a>
