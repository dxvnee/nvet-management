{{-- Absensi Total Working Hours Component --}}
@props(['totalKerja', 'id' => 'working-hours'])

<div
    {{ $attributes->merge(['class' => 'bg-gradient-to-r from-indigo-50 via-blue-50 to-purple-50 rounded-2xl p-5 border border-blue-200 shadow-sm animate-slide-up-delay-1']) }}>
    <div class="flex items-center gap-4">
        <div class="p-3 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl shadow-lg">
            <x-icons.clock class="h-6 w-6 text-white" />
        </div>
        <div>
            <p class="text-sm font-medium text-blue-700">Total Jam Kerja Hari Ini</p>
            <p class="text-2xl font-bold bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent"
                id="{{ $id }}">
                {{ $totalKerja }}
            </p>
        </div>
    </div>
</div>
