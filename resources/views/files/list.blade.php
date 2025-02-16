<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('All Files') }}
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

                <div class="mb-6">
                    <div class="bg-gray-100 dark:bg-gray-900 p-4 rounded-lg">
                        <ul>
                            <li class="flex justify-between items-center py-2 border-b border-gray-300 dark:border-gray-700 font-semibold">
                                <span class="text-gray-700 dark:text-gray-300">{{ __('File Name') }}</span>
                                <span class="text-gray-700 dark:text-gray-300">{{ __('Size') }}</span>
                                <span class="text-gray-700 dark:text-gray-300">{{ __('MIME Type') }}</span>
                                <span class="text-gray-700 dark:text-gray-300">{{ __('Uploaded') }}</span>
                                <span class="text-gray-700 dark:text-gray-300">{{ __('Actions') }}</span>
                            </li>
                            @foreach ($files as $file)
                                <li class="flex flex-col py-2 border-b border-gray-300 dark:border-gray-700">
                                    <div class="flex justify-between items-center">
                                        <span class="text-gray-700 dark:text-gray-300">{{ $file->name }}</span>
                                        <span class="text-gray-700 dark:text-gray-300">{{ $file->size }} bytes</span>
                                        <span class="text-gray-700 dark:text-gray-300">{{ $file->mime_type }}</span>
                                        <span class="text-gray-700 dark:text-gray-300">{{ $file->created_at->diffForHumans() }}</span>
                                        <div class="flex items-center space-x-2">
                                            <a href="{{ Storage::url($file->path) }}" target="_blank" 
                                               class="text-indigo-600 dark:text-indigo-400 hover:underline" title="Download">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1M12 12v6m0 0l-3-3m3 3l3-3m-6-6h6a2 2 0 012 2v4a2 2 0 01-2 2H9a2 2 0 01-2-2V8a2 2 0 012-2z" />
                                                </svg>
                                            </a>
                                            <form action="{{ route('upload.delete', $file->id) }}" method="POST" class="inline-block" title="Remove Association">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" onclick="return confirm('Are you sure?')" class="text-red-600 dark:text-red-400 hover:underline">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                    </svg>
                                                </button>
                                            </form>
                                            <form action="{{ route('upload.forceDelete', $file->id) }}" method="POST" class="inline-block" title="Force Delete">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" onclick="return confirm('Are you sure? This will delete the file from disk.')" class="text-red-600 dark:text-red-400 hover:underline">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="mt-2">
                                        <span class="text-gray-700 dark:text-gray-300">{{ __('Collections:') }}</span>
                                        <ul class="list-disc list-inside">
                                            @foreach ($file->collections as $collection)
                                                <li class="text-gray-700 dark:text-gray-300 flex justify-between items-center">
                                                    <span>{{ $collection->name }}</span>
                                                    <form action="{{ route('upload.removeAssociation', ['mediaId' => $file->id, 'collectionId' => $collection->id]) }}" method="POST" class="inline-block" title="Remove Association">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" onclick="return confirm('Are you sure?')" class="text-red-600 dark:text-red-400 hover:underline">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                            </svg>
                                                        </button>
                                                    </form>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
