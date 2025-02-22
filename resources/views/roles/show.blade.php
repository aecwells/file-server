{{-- filepath: /home/cwells/projects/file-server/resources/views/roles/show.blade.php --}}
<x-app-layout>
<x-slot name="header">
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    {{ __('Show Role') }}
                </h2>
                
            </x-slot>
        <div class="container mx-auto px-4">
        
            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="flex justify-between items-center py-4 float-right">
                            <x-button-link href="{{ route('roles.index') }}" class="bg-blue-500 text-white float-right">Back</x-button-link>
                        </div>
                        <div class="p-6 text-gray-900 dark:text-gray-100">

                        <div class="grid gap-6">
                            <div class="mb-4">
                                <strong>Name:</strong>
                                <p>{{ $role->name }}</p>
                            </div>
                            <div class="mb-4">
                                <strong>Permissions:</strong>
                                @if(!empty($rolePermissions))
                                    @foreach($rolePermissions as $permission)
                                        <label class="badge bg-success">{{ $permission->name }}</label>
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
