{{-- filepath: /home/cwells/projects/file-server/resources/views/users/index.blade.php --}}
<x-app-layout>


    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Users Management') }}
        </h2>
        
    </x-slot>
   
    <div class="py-12">

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    @if ($message = Session::get('success'))
                        <x-alert type="success" :message="$message" />
                    @endif
                   
                    <div class="overflow-x-auto">
                        @can('user-create')
                        <x-button-link href="{{ route('users.create') }}" class="btn btn-accent float-right">Create New
                            User</x-button-link>
                        @endcan
                    <x-table>
                        <x-slot name="head">
                            <tr>
                                <th class="">No</th>
                                <th class="">Name</th>
                                <th class="">Email</th>
                                <th class="">Action</th>
                            </tr>
                        </x-slot>
                        <x-slot name="body">
                            @foreach ($data as $key => $user)
                                <tr class="hover:bg-base-300">
                                    <td class="">{{ ++$i }}</td>
                                    <td class="">{{ $user->name }}</td>
                                    <td class="">{{ $user->email }}</td>
                                    <td class="">
                                        <x-button-link href="{{ route('users.show', $user->id) }}"
                                            class="bg-blue-500 text-white">Show <i class="fas fa-eye"></i></x-button-link>
                                        @can('user-edit')
                                            <x-button-link href="{{ route('users.edit', $user->id) }}"
                                                class="bg-yellow-500 text-white">Edit <i class="fas fa-edit"></i></x-button-link>
                                        @endcan
                                        @can('user-delete')
                                            <form action="{{ route('users.destroy', $user->id) }}" method="POST"
                                                style="display:inline">
                                                @csrf
                                                @method('DELETE')
                                                <x-button type="submit" class="bg-red-500 text-white">Delete <i class="fas fa-trash"></i></x-button>
                                            </form>
                                        @endcan
                                    </td>
                                </tr>
                            @endforeach
                        </x-slot>
                    </x-table>

                    {!! $data->links() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>