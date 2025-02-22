{{-- filepath: /home/cwells/projects/file-server/resources/views/users/create.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ __('Create New User<') }}
        </h2>
    </x-slot>


<div class="container mx-auto px-4">
    <div class="flex justify-between items-center py-4">
        <h2 class="text-2xl font-semibold">Create New User</h2>
        <x-button-link href="{{ route('users.index') }}" class="bg-blue-500 text-white float-right">Back</x-button-link>
    </div>

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

    <form action="{{ route('users.store') }}" method="POST">
        @csrf
        <div class="grid gap-6">
            <x-form-group label="Name">
                <x-input type="text" name="name" placeholder="Name" />
            </x-form-group>
            <x-form-group label="Email">
                <x-input type="text" name="email" placeholder="Email" />
            </x-form-group>
            <x-form-group label="Password">
                <x-input type="password" name="password" placeholder="Password" />
            </x-form-group>
            <x-form-group label="Confirm Password">
                <x-input type="password" name="confirm-password" placeholder="Confirm Password" />
            </x-form-group>
            <x-form-group label="Role">
                <x-select name="roles[]" multiple>
                    @foreach($roles as $role)
                        <option value="{{ $role }}">{{ $role }}</option>
                    @endforeach
                </x-select>
            </x-form-group>
            <div class="text-center">
                <x-button type="submit" class="bg-blue-500 text-white">Submit</x-button>
            </div>
        </div>
    </form>
</div>
@endsection