@extends('settings.index')
@section('contents')
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Backups
        </h2>
    </x-slot>
    <div class="bg-white p-5 mt-5">
        <div class="flex items-center justify-end mb-3">
            <a href="{{ route('backup.create') }}"
                class="'inline-flex items-center px-4 py-2 bg-purple-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-purple-700 focus:bg-gray-700 active:bg-purple-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                Create Backup
            </a>
        </div>
        <table class="min-w-full border data-table">
            <thead>
                <tr>
                    <th class="border-b px-4 py-2 text-left">#</th>
                    <th class="border-b px-4 py-2 text-left">Name</th>
                    <th class="border-b px-4 py-2 text-left">Size</th>
                    <th class="border-b px-4 py-2 text-left">Date Created</th>
                    <th class="border-b px-4 py-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($backups as $backup)
                    <tr>
                        <td class="border-b px-4 py-2">{{ $loop->iteration }}</td>
                        <td class="border-b px-4 py-2">{{ $backup['name'] }}</td>
                        <td class="border-b px-4 py-2">{{ $backup['size'] }}</td>
                        <td class="border-b px-4 py-2">
                            {{ \Carbon\Carbon::parse($backup['created_at'])->format('F d, Y') }}</td>
                        <td class="border-b px-4 py-2">
                            <a href="{{ route('backup.download', $backup['name']) }}"
                                class="text-blue-500 hover:text-blue-700">Download</a>
                            {{-- <a href="{{ route('backup.delete', $backup['name']) }}"
                                    class="text-red-500 hover:text-red-700">Delete</a> --}}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
