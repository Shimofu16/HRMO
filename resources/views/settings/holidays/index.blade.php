@extends('settings.index')
@section('header')
    Level
@endsection
@section('contents')
    <div class="bg-white mt-8 p-5 mx-8 shadow rounded-md">
        <form action="{{ route('holidays.store') }}" method="POST">
            @csrf
            <div class="grid grid-cols-6 gap-6">
                <div class="col-span-6 sm:col-span-3">
                    <label for="name" class="block font-medium text-gray-700">Name</label>
                    <input type="text" name="name" id="name" class="form-input mt-1 block w-full text-xl" required>
                </div>
                <div class="col-span-6 sm:col-span-3">
                    <label for="date" class="block font-medium text-gray-700">Date</label>
                    <input type="date" name="date" id="date" class="form-input mt-1 block w-full text-xl" required>
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
                    <th class="border-b px-4 py-2 text-left">Date</th>
                    <th class="border-b px-4 py-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($holidays as $holiday)
                    <tr>
                        <td class="border-b px-4 py-2">{{ $loop->iteration }}</td>
                        <td class="border-b px-4 py-2">{{ $holiday->name }}</td>
                        <td class="border-b px-4 py-2">{{ date('M d ----', strtotime($holiday->date)) }}</td>
                        <td class="border-b px-4 py-2">
                            <a href="{{ route('holidays.edit', $holiday) }}" class="text-blue-500 hover:text-blue-700">Edit</a>
                            <form class="inline-block" action="{{ route('holidays.destroy', $holiday) }}" method="POST">
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
