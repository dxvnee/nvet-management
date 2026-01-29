{{-- User Info Card Component --}}
@props(['user', 'date' => null, 'extraInfo' => null])

<x-ui.section-card>
    <div class="flex items-center gap-4">
        <x-ui.user-avatar :user="$user" size="lg" class="border-2 border-primary" />
        <div>
            <h3 class="text-xl font-bold text-gray-800">{{ $user->name }}</h3>
            <p class="text-gray-600">{{ $user->jabatan }}</p>
            @if ($date)
                <p class="text-sm text-gray-500">Tanggal: {{ \Carbon\Carbon::parse($date)->format('d F Y') }}</p>
            @endif
            @if ($user->email && !$date)
                <p class="text-sm text-gray-500">Email: {{ $user->email }}</p>
            @endif
            {{ $extraInfo ?? '' }}
        </div>
    </div>
</x-ui.section-card>
