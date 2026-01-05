@props(['message' => null, 'type' => 'error'])

@php
    $bgColor = match ($type) {
        'success' => 'bg-green-500',
        'warning' => 'bg-yellow-500',
        'info' => 'bg-blue-500',
        default => 'bg-red-500',
    };

    $textColor = 'text-white';
    $icon = match ($type) {
        'success' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z',
        'warning' => 'M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z',
        'info' => 'M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z',
        default => 'M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z',
    };
@endphp

@if($message || session('error') || session('success'))
    <div id="error-message" class="fixed ml-5 top-5 right-5 z-[1000] animate-fade-in-up overflow-hidden">
        <div class="{{ $bgColor }} {{ $textColor }} px-6 py-4 rounded-lg shadow-lg max-w-sm w-full">
            <div class="flex items-center">

                <div class="flex-1">
                    <p class="font-semibold">
                        @if($type === 'success')
                            Success!
                        @elseif($type === 'warning')
                            Warning!
                        @elseif($type === 'info')
                            Info!
                        @else
                            Error!
                        @endif
                    </p>
                    <p class="text-sm opacity-90">
                        {{ $message ?: (session('error') ?: session('success')) }}
                    </p>
                </div>
                <button onclick="this.parentElement.parentElement.parentElement.style.display='none'"
                    class="ml-4 text-white hover:text-gray-200 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                </button>
            </div>
        </div>
        <div class="loading-bar"></div>
<style>
.loading-bar {
    height: 4px;
    background: rgba(255, 255, 255, 0.8);
    width: 0%;
    animation: load 5s linear forwards;
    margin-top: -4px;
    border-radius: 0 0 8px 8px;
    overflow: hidden;
}
@keyframes load {
    to { width: 100%; }
}
.fade-out {
    animation: fadeOut 0.5s ease-out forwards;
}
@keyframes fadeOut {
    to {
        opacity: 0;
        transform: translateY(-20px);
    }
}
</style>
<script>
setTimeout(() => {
    const el = document.getElementById('error-message');
    el.classList.add('fade-out');
    setTimeout(() => {
        el.style.display = 'none';
    }, 500);
}, 5000);
</script>
    </div>
@endif
