{{-- filepath: /home/cwells/projects/file-server/resources/views/users/index.blade.php --}}
<x-app-layout>
@section('content')

<x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Users Management') }}
        </h2>
        @can('user-create')
        <x-button-link href="{{ route('users.create') }}" class="bg-green-500 text-white">Create New User</x-button-link>
        @endcan
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

    @if ($message = Session::get('success'))
    <x-alert type="success" :message="$message" />
    @endif

    <x-table>
        <x-slot name="head">
            <tr>
                <th class="py-2">No</th>
                <th class="py-2">Name</th>
                <th class="py-2">Email</th>
                <th class="py-2">Action</th>
            </tr>
        </x-slot>
        <x-slot name="body">
            @foreach ($data as $key => $user)
            <tr class="bg-white dark:bg-gray-700">
                <td class="border px-4 py-2">{{ ++$i }}</td>
                <td class="border px-4 py-2">{{ $user->name }}</td>
                <td class="border px-4 py-2">{{ $user->email }}</td>
                <td class="border px-4 py-2">
                    <x-button-link href="{{ route('users.show', $user->id) }}" class="bg-blue-500 text-white">Show</x-button-link>
                    @can('user-edit')
                    <x-button-link href="{{ route('users.edit', $user->id) }}" class="bg-yellow-500 text-white">Edit</x-button-link>
                    @endcan
                    @can('user-delete')
                    <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display:inline">
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

    {!! $data->links() !!}
</div></div></div></div>
@endsection
</x-app-layout>