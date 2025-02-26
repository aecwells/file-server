<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('SMB Host Details') }}
        </h2>
    </x-slot>
    <div class="container mx-auto p-4">
        <table class="table">
            <tr>
                <th>Name</th>
                <td>{{ $smbHost->name }}</td>
            </tr>
            <tr>
                <th>Host</th>
                <td>{{ $smbHost->host }}</td>
            </tr>
            <tr>
                <th>Username</th>
                <td>{{ $smbHost->username }}</td>
            </tr>
            <tr>
                <th>Password</th>
                <td>{{ $smbHost->password }}</td>
            </tr>
            <tr>
                <th>Remote Path</th>
                <td>{{ $smbHost->remote_path }}</td>
            </tr>
        </table>
        <a href="{{ route('smb_hosts.index') }}" class="btn btn-primary float-right">Back</a>
    </div>

</x-app-layout>