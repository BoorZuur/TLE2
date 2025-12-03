@props(['value'])

{{-- merge deze pls --}}
<label {{ $attributes->merge(['class' => 'block font-medium text-sm text-black']) }}>
    {{ $value ?? $slot }}
</label>
