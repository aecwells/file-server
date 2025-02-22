<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Add SMB Host') }}
        </h2>
    </x-slot>
    <div class="container mx-auto p-4">
        <form action="{{ route('smb_hosts.store') }}" method="POST" class="space-y-4">
            @csrf
            <x-form-group label="Name">
                <x-input type="text" name="name" placeholder="Name" class="input input-bordered w-full" required />
            </x-form-group>
            <x-form-group label="Host">
                <x-input type="text" name="host" placeholder="Host" class="input input-bordered w-full" required />
            </x-form-group>
            <x-form-group label="Username">
                <x-input type="text" name="username" placeholder="Username" class="input input-bordered w-full" required />
            </x-form-group>
            <x-form-group label="Password">
                <x-input type="password" name="password" placeholder="Password" class="input input-bordered w-full" required />
            </x-form-group>
            <x-form-group label="Confirm Password">
                <x-input type="password" name="password_confirmation" placeholder="Confirm Password" class="input input-bordered w-full" required />
            </x-form-group>
            <x-form-group label="Remote Path">
                <x-input type="text" name="remote_path" placeholder="Remote Path" class="input input-bordered w-full" required />
            </x-form-group>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</x-app-layout>
