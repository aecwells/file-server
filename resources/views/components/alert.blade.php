@props(['type', 'message'])

<div class="bg-{{ $type }}-100 dark:bg-{{ $type }}-900 border border-{{ $type }}-400 dark:border-{{ $type }}-700 text-{{ $type }}-700 dark:text-{{ $type }}-300 px-4 py-3 rounded relative" role="alert">
    {{ $message ?? $slot }}
</div>