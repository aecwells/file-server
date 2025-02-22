{{-- filepath: /home/cwells/projects/file-server/resources/views/users/edit.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit User') }}
        </h2>
        <x-button-link href="{{ route('users.index') }}" class="bg-blue-500 text-white float-right">Back</x-button-link>
    </x-slot>
    <div class="container mx-auto px-4">
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <form action="{{ route('users.update', $user->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="grid gap-6">
                                <div class="mb-4">
                                    <x-form-group label="Name">
                                        <x-input type="text" name="name" value="{{ $user->name }}" required />
                                    </x-form-group>
                                </div>
                                <div class="mb-4">
                                    <x-form-group label="Email">
                                        <x-input type="email" name="email" value="{{ $user->email }}" required />
                                    </x-form-group>
                                </div>
                                <div class="mb-4">
                                    <x-button type="submit" class="bg-green-500 text-white">Update</x-button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
