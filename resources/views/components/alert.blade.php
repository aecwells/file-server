@props(['type' => 'info', 'messages' => []])

@php
    $alertClasses = match($type) {
        'success' => 'bg-green-100 text-green-800 border-green-500',
        'error' => 'bg-red-100 text-red-800 border-red-500',
        'warning' => 'bg-yellow-100 text-yellow-800 border-yellow-500',
        default => 'bg-blue-100 text-blue-800 border-blue-500',
    };
@endphp

@if(!empty($messages))
    <div class="p-4 mb-4 border-l-4 {{ $alertClasses }}">
        @foreach ($messages as $message)
            <p class="text-sm">{{ $message }}</p>
        @endforeach
    </div>
@endif