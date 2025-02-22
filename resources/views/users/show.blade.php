{{-- filepath: /home/cwells/projects/file-server/resources/views/users/show.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Show User') }}
        </h2>
        <x-button-link href="{{ route('users.index') }}" class="bg-blue-500 text-white float-right">Back</x-button-link>
    </x-slot>
    <div class="container mx-auto px-4">

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">

                        <div class="grid gap-6">
                            <div class="mb-4">
                                <strong>Name:</strong>
                                <p>{{ $user->name }}</p>
                            </div>
                            <div class="mb-4">
                                <strong>Email:</strong>
                                <p>{{ $user->email }}</p>
                            </div>
                            <div class="mb-4">
                                <strong>Roles:</strong>
                                @if(!empty($user->getRoleNames()))
                                    @foreach($user->getRoleNames() as $role)
                                        <label class="badge bg-success">{{ $role }}</label>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>