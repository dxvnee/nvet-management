{{-- Photo Button Component --}}
@props([
    'type' => 'masuk', // masuk, pulang, izin
    'photoUrl',
    'userName',
    'timestamp' => null,
    'modalId' => 'photo-modal',
])

@php
    $styles = [
        'masuk' => [
            'bg' => 'bg-green-100 hover:bg-green-200',
            'text' => 'text-green-700',
            'label' => 'Masuk',
        ],
        'pulang' => [
            'bg' => 'bg-blue-100 hover:bg-blue-200',
            'text' => 'text-blue-700',
            'label' => 'Pulang',
        ],
        'izin' => [
            'bg' => 'bg-yellow-100 hover:bg-yellow-200',
            'text' => 'text-yellow-700',
            'label' => 'Izin',
        ],
    ];

    $style = $styles[$type];
@endphp

<button
    onclick="openPhotoModal('{{ $photoUrl }}', '{{ $userName }} - Foto {{ $style['label'] }}', '{{ $timestamp }}', '{{ $modalId }}')"
    {{ $attributes->merge(['class' => "px-2 py-1 {$style['bg']} {$style['text']} text-xs rounded transition-colors"]) }}
    title="Lihat Foto {{ $style['label'] }}">
    📷 {{ $style['label'] }}
</button>
