<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ __('Files by Collection') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                @if(session('success'))
                    <div class="bg-green-100 text-green-800 p-4 rounded-lg mb-4">
                    <span class="text-gray-700 dark:text-gray-300">{{ session('success') }}</span>
                    </div>
                @endif

                @forelse ($collections as $collection)
                    <div class="mb-6">
                        <h2 class="text-xl font-semibold text-indigo-600 dark:text-indigo-400 mb-2">{{ $collection->name }}</h2>
                        <div class="bg-gray-100 dark:bg-gray-900 p-4 rounded-lg">
                            <ul>
                                <li class="flex justify-between items-center py-2 border-b border-gray-300 dark:border-gray-700 font-semibold">
                                    <span class="text-gray-700 dark:text-gray-300">{{ __('File Name') }}</span>
                                    <span class="text-gray-700 dark:text-gray-300">{{ __('Disk') }}</span>
                                    <span class="text-gray-700 dark:text-gray-300">{{ __('Size') }}</span>
                                    <span class="text-gray-700 dark:text-gray-300">{{ __('MIME Type') }}</span>
                                    <span class="text-gray-700 dark:text-gray-300">{{ __('Uploaded') }}</span>
                                    <span class="text-gray-700 dark:text-gray-300">{{ __('Actions') }}</span>
                                </li>
                                @foreach ($collection->media as $file)
                                    <li class="flex justify-between items-center py-2 border-b border-gray-300 dark:border-gray-700">
                                        <span class="text-gray-700 dark:text-gray-300 break-words">{{ $file->name }}</span>
                                        <span class="text-gray-700 dark:text-gray-300">{{ $file->disk }}</span>
                                        <span class="text-gray-700 dark:text-gray-300">{{ humanReadableSize($file->size) }}</span>
                                        <span class="text-gray-700 dark:text-gray-300">{{ $file->mime_type }}</span>
                                        <span class="text-gray-700 dark:text-gray-300">{{ $file->created_at->diffForHumans() }}</span>

                                        <div>
                                            <a href="{{ route('download.file', ['collection' => $collection->name, 'filename' => $file->name . '.' . pathinfo($file->file_name, PATHINFO_EXTENSION)]) }}" target="_blank" 
                                               class="text-indigo-600 dark:text-indigo-400 hover:underline mr-4">
                                               <i class="fas fa-circle-down"></i>
                                            </a>
                                            <form action="{{ route('upload.delete', $file->id) }}" method="POST" class="inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" onclick="return confirm('Are you sure?')"
                                                    class="text-red-600 dark:text-red-400 hover:underline">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @empty
                    <p class="text-gray-600 dark:text-gray-400">{{ __('No files uploaded yet') }}.</p>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>

@php
function humanReadableSize($size)
{
    $units = ['B', 'KB', 'MB', 'GB', 'TB'];
    $power = $size > 0 ? floor(log($size, 1024)) : 0;
    return number_format($size / pow(1024, $power), 2, '.', ',') . ' ' . $units[$power];
}
@endphp