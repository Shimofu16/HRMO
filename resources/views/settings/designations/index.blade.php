
@extends('settings.index')
@section('contents')
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Department
        </h2>
    </x-slot>
    <div class="bg-white mt-8 p-5 mx-8 shadow rounded-md">
        <form action="{{ route('designations.store') }}" method="POST">
            @csrf
            <div class="grid grid-cols-6 gap-6">
                <div class="col-span-6 sm:col-span-3">
                    <label for="designation_code" class="block font-medium text-gray-700">Designation
                        Code</label>
                    <input type="text" name="designation_code" id="designation_code"
                        class="block w-full mt-1 rounded" required>
                </div>
                <div class="col-span-6 sm:col-span-3">
                    <label for="designation_name" class="block font-medium text-gray-700">Designation
                        Name</label>
                    <input type="text" name="designation_name" id="designation_name"
                        class="block w-full mt-1 rounded" required>
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
                    <th class="px-4 py-2 text-left border-b">#</th>
                    <th class="px-4 py-2 text-left border-b">Code</th>
                    <th class="px-4 py-2 text-left border-b">Name</th>
                    <th class="px-4 py-2 border-b">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($designations as $designation)
                    <tr>
                        <td class="px-4 py-2 border-b">{{ $loop->iteration }}</td>
                        <td class="px-4 py-2 border-b">{{ $designation->designation_code }}</td>
                        <td class="px-4 py-2 border-b">{{ $designation->designation_name }}</td>
                        <td class="px-4 py-2 border-b">
                            <a href="{{ route('designations.edit', $designation) }}"
                                class="text-blue-500 hover:text-blue-700">Edit</a>
                            <form class="inline-block" action="{{ route('designations.destroy', $designation) }}"
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
