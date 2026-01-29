{{-- Form Select Component --}}
@props([
    'name',
    'label' => null,
    'value' => null,
    'options' => [],
    'placeholder' => '-- Pilih --',
    'required' => false,
    'disabled' => false,
    'error' => null,
])

<div class="space-y-2">
    @if ($label)
        <label for="{{ $name }}" class="block text-sm font-medium text-gray-700">
            {{ $label }}
            @if ($required)
                <span class="text-red-500">*</span>
            @endif
        </label>
    @endif

    <select name="{{ $name }}" id="{{ $name }}" {{ $required ? 'required' : '' }}
        {{ $disabled ? 'disabled' : '' }}
        {{ $attributes->merge(['class' => 'w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary transition-colors' . ($disabled ? ' bg-gray-100 cursor-not-allowed' : '')]) }}>
        @if ($placeholder)
            <option value="">{{ $placeholder }}</option>
        @endif
        @foreach ($options as $optionValue => $optionLabel)
            <option value="{{ $optionValue }}" {{ old($name, $value) == $optionValue ? 'selected' : '' }}>
                {{ $optionLabel }}
            </option>
        @endforeach
        {{ $slot }}
    </select>

    @if ($error ?? $errors->first($name))
        <p class="text-red-500 text-sm">{{ $error ?? $errors->first($name) }}</p>
    @endif
</div>
