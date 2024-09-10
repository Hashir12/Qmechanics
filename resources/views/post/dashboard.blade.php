<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Post Dashboard') }}
            </h2>
            <!-- Add New User Button -->
            <a href="{{ route('posts.create') }}"
               class="btn btn-primary bg-blue-500 hover:bg-blue-700 font-bold py-2 px-4 rounded">
                Add New Post
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
                                Title
                            </th>
                            <th class="py-2 px-4 border-b-2 border-gray-300 text-left text-gray-700">
                                Content
                            </th>
                            <th class="py-2 px-4 border-b-2 border-gray-300 text-left text-gray-700">
                                Created at
                            </th>

                            <th class="py-2 px-4 border-b-2 border-gray-300 text-left text-gray-700">
                                Action
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($data['posts'] as $post)
                            <tr class="hover:bg-gray-100">
                                <td class="py-2 px-4 border-b border-gray-300">
                                    {{ $post->title }}
                                </td>
                                <td class="py-2 px-4 border-b border-gray-300">
                                    {{ substr($post->content,0, 50) }}
                                </td>
                                <td class="py-2 px-4 border-b border-gray-300">
                                    {{ date($post->created_at) }}
                                </td>
                                <td class="py-2 px-4 border-b border-gray-300">
                                    <a href="{{route('posts.show',$post->id)}}" class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded">View</a>
                                    <a href="{{ route('posts.edit', $post->id) }}"
                                       class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-4 rounded">Edit</a>
                                    <form action="{{ route('posts.destroy', $post->id) }}" method="POST"
                                          style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded"
                                                onclick="return confirm('Are you sure you want to disbale this user?');">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    {!! $data['posts']->links() !!}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
