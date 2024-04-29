@extends('settings.index')
@section('header')
    Type of Employment
@endsection
@section('contents')
    <div class="bg-white mt-8 p-5 mx-8 shadow rounded-md">
        <form action="{{ route('categories.store') }}" method="POST">
            @csrf
                <div class="grid grid-cols-6 gap-6">
                    <div class="col-span-6 sm:col-span-3">
                        <label for="category_code" class="block font-medium text-gray-700">Code</label>
                        <input type="text" name="category_code" id="category_code" class="block w-full mt-1 rounded"
                            required>
                    </div>
                    <div class="col-span-6 sm:col-span-3">
                        <label for="category_name" class="block font-medium text-gray-700">Name</label>
                        <input type="text" name="category_name" id="category_name" class="block w-full mt-1 rounded"
                            required>
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

        <table class="min-w-full  border data-table">
            <thead>
                <tr>
                    <th class="border-b px-4 py-2 text-left">#</th>
                    <th class="border-b px-4 py-2 text-left">Code</th>
                    <th class="border-b px-4 py-2 text-left">Name</th>
                    <th class="border-b px-4 py-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($categories as $category)
                    <tr>
                        <td class="border-b px-4 py-2">{{ $loop->iteration }}</td>
                        <td class="border-b px-4 py-2">{{ $category->category_code }}</td>
                        <td class="border-b px-4 py-2">{{ $category->category_name }}</td>
                        <td class="border-b px-4 py-2">
                            <a href="{{ route('categories.edit', $category) }}"
                                class="text-blue-500 hover:text-blue-700">Edit</a>
                            {{-- <form class="inline-block" action="{{ route('categories.destroy', $category) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700">Delete</button>
                            </form> --}}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
