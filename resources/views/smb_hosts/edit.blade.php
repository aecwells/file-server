<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit SMB Host') }}
        </h2>
    </x-slot>
    <div class="container mx-auto p-4">
        <form action="{{ route('smb_hosts.update', $smbHost->id) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')
            <x-form-group label="Name">
                <x-input type="text" name="name" class="input input-bordered w-full" value="{{ $smbHost->name }}" required />
            </x-form-group>
            <x-form-group label="Host">
                <x-input type="text" name="host" class="input input-bordered w-full" value="{{ $smbHost->host }}" required />
            </x-form-group>
            <x-form-group label="Username">
                <x-input type="text" name="username" class="input input-bordered w-full" value="{{ $smbHost->username }}" required />
            </x-form-group>
            <x-form-group label="Password">
                <x-input type="password" name="password" class="input input-bordered w-full" />
            </x-form-group>
            <x-form-group label="Confirm Password">
                <x-input type="password" name="password_confirmation" class="input input-bordered w-full" />
            </x-form-group>
            <x-form-group label="Remote Path">
                <x-input type="text" name="remote_path" class="input input-bordered w-full" value="{{ $smbHost->remote_path }}" required />
            </x-form-group>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</x-app-layout>