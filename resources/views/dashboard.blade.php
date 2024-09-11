<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1>
                        <b>
                            {{ __("Welcome to Qmechanics") }}
                        </b>
                    </h1>
                    <br>
                    @if(auth()->user()->role_id == 1)
                        <a class="bg-green-700 rounded p-3 text-white" href="{{route('admin.index')}}">Admin Dashboard</a>
                    @else
                        <a class="bg-green-700 rounded p-3 text-white" href="{{route('posts.index')}}">User Dashboard</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
