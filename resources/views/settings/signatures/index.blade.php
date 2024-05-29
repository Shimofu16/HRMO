@extends('settings.index')
@section('header')
    Signature
@endsection
@section('contents')

    <div class="bg-white mt-8 p-5 mx-8 shadow rounded-md">
        <form action="{{ route('signatures.store') }}" method="POST">
            @csrf
            <div class="grid grid-cols-6 gap-6">
                <div class="col-span-6 sm:col-span-3">
                    <label for="name" class="block font-medium text-gray-700">
                        Name
                    </label>
                    <input type="text" name="name" id="name" class="block w-full mt-1 rounded" required>
                </div>
                <div class="col-span-6 sm:col-span-3">
                    <label for="position" class="block font-medium text-gray-700">
                        Position
                    </label>
                    <input type="text" name="position" id="position" class="block w-full mt-1 rounded" required>
                </div>
            </div>
            <div class=" py-3 text-right sm:px-6">
                <x-primary-button class="mr-1">
                    {{ __('Create') }}
                </x-primary-button>
            </div>
        </form>
    </div>

    <div class="bg-white  mt-5 p-5 shadow rounded-md">

        <table class="min-w-full border data-table">
            <thead>
                <tr>
                    <th class="border-b px-4 py-2 text-left">#</th>
                    <th class="border-b px-4 py-2 text-left">Name</th>
                    <th class="border-b px-4 py-2 text-left">Position</th>
                    <th class="border-b px-4 py-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($signatures as $signature)
                    <tr>
                        <td class="border-b px-4 py-2">{{ $loop->iteration }}</td>
                        <td class="border-b px-4 py-2">{{ $signature->name }}</td>
                        <td class="border-b px-4 py-2">{{ $signature->position }}</td>
                        <td class="border-b px-4 py-2">
                            <form class="inline-block" action="{{ route('signatures.destroy', $signature) }}"
                                method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
