{{-- filepath: /home/cwells/projects/file-server/resources/views/roles/index.blade.php --}}
<x-app-layout>
@section('content')
<div class="container mx-auto px-4">
<x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Roles Management') }}
        </h2>
        @can('role-create')
        <x-button-link href="{{ route('roles.create') }}" class="bg-green-500 text-white float-right">Create New Role</x-button-link>
        @endcan
    </x-slot>
    <div class="flex justify-between items-center py-4">
        <h2 class="text-2xl font-semibold">Roles Management</h2>
        @can('role-create')
        <x-button-link href="{{ route('roles.create') }}" class="bg-green-500 text-white float-right">Create New Role</x-button-link>
        @endcan
    </div>

    @if ($message = Session::get('success'))
    <x-alert type="success" :message="$message" />
    @endif

    <x-table>
        <x-slot name="head">
            <tr>
                <th class="py-2">No</th>
                <th class="py-2">Name</th>
                <th class="py-2">Action</th>
            </tr>
        </x-slot>
        <x-slot name="body">
            @foreach ($roles as $role)
            <tr class="bg-white dark:bg-gray-700">
                <td class="border px-4 py-2">{{ ++$i }}</td>
                <td class="border px-4 py-2">{{ $role->name }}</td>
                <td class="border px-4 py-2">
                    <x-button-link href="{{ route('roles.show', $role->id) }}" class="bg-blue-500 text-white">Show</x-button-link>
                    @can('role-edit')
                    <x-button-link href="{{ route('roles.edit', $role->id) }}" class="bg-yellow-500 text-white">Edit</x-button-link>
                    @endcan
                    @can('role-delete')
                    <form action="{{ route('roles.destroy', $role->id) }}" method="POST" style="display:inline">
                        @csrf
                        @method('DELETE')
                        <x-button type="submit" class="bg-red-500 text-white">Delete</x-button>
                    </form>
                    @endcan
                </td>
            </tr>
            @endforeach
        </x-slot>
    </x-table>

    {!! $roles->links() !!}
</div>
@endsection

</x-app-layout>
