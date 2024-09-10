<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Admin Dashboard') }}
            </h2>
            <!-- Add New User Button -->
            <a href="{{ route('admin.create') }}"
                class="btn btn-primary bg-blue-500 hover:bg-blue-700 font-bold py-2 px-4 rounded">
                Add New User
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <!-- Improved Table Styling -->
                    <table class="min-w-full bg-white border-collapse">
                        <thead>
                            <tr>
                                <th class="py-2 px-4 border-b-2 border-gray-300 text-left text-gray-700">
                                    Name
                                </th>
                                <th class="py-2 px-4 border-b-2 border-gray-300 text-left text-gray-700">
                                    Email
                                </th>
                                <th class="py-2 px-4 border-b-2 border-gray-300 text-left text-gray-700">
                                    Role
                                </th>
                                <th class="py-2 px-4 border-b-2 border-gray-300 text-left text-gray-700">
                                    Status
                                </th>
                                <th class="py-2 px-4 border-b-2 border-gray-300 text-left text-gray-700">
                                    Action
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data['users'] as $user)
                                <tr class="hover:bg-gray-100">
                                    <td class="py-2 px-4 border-b border-gray-300">
                                        {{ $user->name }}
                                    </td>
                                    <td class="py-2 px-4 border-b border-gray-300">
                                        {{ $user->email }}
                                    </td>
                                    <td class="py-2 px-4 border-b border-gray-300">
                                        {{ ucfirst($user->role->role_type) }}
                                    </td>
                                    <td class="py-2 px-4 border-b border-gray-300">
                                        @if ($user->deleted_at)
                                            <span class="badge bg-red-700">Disabled</span>
                                        @else
                                            <span class="badge bg-green-700">Active</span>
                                        @endif
                                    </td>
                                    <td class="py-2 px-4 border-b border-gray-300">
                                        @if ($user->deleted_at)
                                            <a href="{{route('admin.restore',$user->id)}}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Restore</a>
                                            <a href="{{route('admin.delete', $user->id)}}" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded" onclick="return confirm('Are you sure you want to delete this user permanently ?');">Delete Permanent</a>
                                        @else
                                            <a href="{{ route('admin.edit', $user->id) }}"
                                               class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-4 rounded">Edit</a>
                                            <form action="{{ route('admin.destroy', $user->id) }}" method="POST"
                                                style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded"
                                                    onclick="return confirm('Are you sure you want to disbale this user?');">
                                                    Delete
                                                </button>
                                            </form>
                                        @endif

                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
