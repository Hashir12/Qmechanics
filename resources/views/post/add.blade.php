<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @if (isset($post))
                {{ __('Update Post') }}
            @else
                {{ __('Add New Post') }}
            @endif
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <form action="{{ isset($post) ? route('posts.update', $post->id) : route('posts.store') }}" method="POST">
                        @csrf
                        @isset($post)
                            @method('PUT')
                            <input type="hidden" name="id" value="{{ $post->id }}">
                        @endisset

                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="title">
                                Title
                            </label>
                            <input type="text" name="title" id="title"
                                   class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                   value="{{ $post->title ?? old('title') }}">

                            @error('title')
                            <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="content">
                                Content
                            </label>
                            <textarea name="content" id="content" cols="30" rows="10" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"></textarea>
                            @error('content')
                            <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                            @enderror
                        </div>
                        <button type="submit"
                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            {{ isset($post) ? 'Update Post' : 'Create Post' }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
