<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('SMB Hosts') }}
        </h2>
    </x-slot>
    <div class="container mx-auto p-4">

        <a href="{{ route('smb_hosts.create') }}" class="btn btn-primary">Add SMB Host</a>
        <table class="table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Host</th>
                    <th>Username</th>
                    <th>Remote Path</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($smbHosts as $smbHost)
                    <tr>
                        <td>{{ $smbHost->name }}</td>
                        <td>{{ $smbHost->host }}</td>
                        <td>{{ $smbHost->username }}</td>
                        <td>{{ $smbHost->remote_path }}</td>
                        <td>
                            <a href="{{ route('smb_hosts.show', $smbHost->id) }}" class="btn btn-info">View</a>
                            <a href="{{ route('smb_hosts.edit', $smbHost->id) }}" class="btn btn-warning">Edit</a>
                            <form action="{{ route('smb_hosts.destroy', $smbHost->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout>