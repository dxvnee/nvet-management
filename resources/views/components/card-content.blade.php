<div
    {{ $attributes->merge([
        'class' => 'bg-white rounded-2xl shadow-lg p-6 border border-gray-100 animate-slide-up-delay-1',
    ]) }}>
    {{ $slot }}
</div>
