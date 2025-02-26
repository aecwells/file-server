@props(['value'])

<label {{ $attributes->merge(['class' => 'lable']) }}>
    {{ $value ?? $slot }}
</label>
