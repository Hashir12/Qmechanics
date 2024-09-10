<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @if (isset($user))
                {{ __('Update User') }}
            @else
                {{ __('Add New User') }}
            @endif
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ isset($user) ? route('admin.update', $user->id) : route('admin.store') }}"
                        method="POST">
                        @csrf
                        @isset($user)
                            @method('PUT')
                            <input type="hidden" name="id" value="{{ $user->id }}">
                        @endisset

                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="name">
                                Name
                            </label>
                            <input type="text" name="name" id="name"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                value="{{ $user->name ?? old('name') }}">

                            @error('name')
                                <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="email">
                                Email
                            </label>
                            <input type="email" name="email" id="email"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                value="{{ $user->email ?? old('email') }}" {{ isset($user) ? 'readonly' : '' }}>

                            @error('email')
                                <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        @if(!isset($user))
                            <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-bold mb-2" for="password">
                                    Password
                                </label>
                                <input type="password" name="password" id="password"
                                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                    {{ isset($user) ? 'readonly' : '' }}>
                                @error('password')
                                    <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                                @enderror
                            </div>
                        @endif

                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="role">
                                Role
                            </label>
                            <select name="role" id="role"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                <option value="1"
                                    {{ isset($user) ? ($user->role_id == 1 ? 'selected' : '') : (old('role') == 1 ? 'selected' : '') }}>
                                    Admin</option>
                                <option value="2"
                                    {{ isset($user) ? ($user->role_id == 2 ? 'selected' : '') : (old('role') == 2 ? 'selected' : '') }}>
                                    User</option>
                            </select>
                            @error('role')
                                <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <button type="submit"
                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            {{ isset($user) ? 'Update User' : 'Create User' }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
