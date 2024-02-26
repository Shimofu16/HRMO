<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Backups
        </h2>
    </x-slot>
    @include('layouts.sidebar')
    <div class="sm:ml-64">
        @yield('contents')
    </div>
</x-app-layout>
