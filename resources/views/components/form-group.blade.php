@props(['label'])

<div class="mb-4">
    <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">{{ $label }}:</label>
    {{ $slot }}
</div>
