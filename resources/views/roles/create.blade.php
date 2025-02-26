{{-- filepath: /home/cwells/projects/file-server/resources/views/roles/create.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Create New Role') }}
        </h2>
        <div class="flex justify-between items-center py-4">

            <a class="btn btn-primary bg-blue-500 text-white px-4 py-2 rounded" href="{{ route('roles.index') }}">
                Back</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    @if (count($errors) > 0)
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                            <strong class="font-bold">Whoops!</strong> There were some problems with your input.<br><br>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('roles.store') }}" method="POST">
                        @csrf
                        <div class="grid grid-cols-1 gap-6">
                            <div class="form-group">
                                <x-input name="name" placeholder="Name"
                                    class="form-control border rounded w-full py-2 px-3" />
                            </div>
                            <div class="form-group">
                                <strong>Permission:</strong>
                                <br />
                                @foreach($permission as $value)
                                    <label><input type="checkbox" name="permission[]" value="{{ $value->id }}" class="name">
                                        {{ $value->name }}</label>
                                    <br />
                                @endforeach
                            </div>
                            <div class="text-center">
                                <button type="submit"
                                    class="btn btn-primary bg-blue-500 text-white px-4 py-2 rounded">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>