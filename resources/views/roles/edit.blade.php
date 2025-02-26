{{-- filepath: /home/cwells/projects/file-server/resources/views/roles/edit.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Role') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <x-button-link href="{{ route('roles.index') }}"
                    class="bg-blue-500 text-white float-right">Back</x-button-link>
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    @if (count($errors) > 0)
                        <x-alert type="danger">
                            <strong>Whoops!</strong> There were some problems with your input.<br><br>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </x-alert>
                    @endif

                    <form action="{{ route('roles.update', $role->id) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <div class="grid gap-6">
                            <x-form-group label="Name">
                                <x-input type="text" name="name" value="{{ $role->name }}" placeholder="Name" />
                            </x-form-group>
                            <x-form-group label="Permission">
                                <x-select name="permission[]" multiple>
                                    @foreach($permission as $value)
                                        <option value="{{ $value->id }}" {{ in_array($value->id, $rolePermissions) ? 'selected' : '' }}>{{ $value->name }}</option>
                                    @endforeach
                                </x-select>
                            </x-form-group>
                            <div class="text-center">
                                <x-button type="submit" class="bg-blue-500 text-white">Submit</x-button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>