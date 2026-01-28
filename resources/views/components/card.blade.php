<div
    {{  $attributes->merge([
        'class' => "
            flex flex-col md:flex-row
            w-full max-w-[900px]
            m-4 bg-white rounded-2xl shadow-[0_20px_60px_rgba(133,94,65,0.15)]
            overflow-hidden
            animate-[{$animation}_0.8s_ease-out]
        "
    ]) }}
>
    {{ $slot }}
</div>
