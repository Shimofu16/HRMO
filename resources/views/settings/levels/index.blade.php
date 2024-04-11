@extends('settings.index')
@section('header')
    Level
@endsection
@section('contents')
    <div class="bg-white mt-8 p-5 mx-8 shadow rounded-md">
        <form action="{{ route('levels.store') }}" method="POST">
            @csrf
            <div class="grid grid-cols-6 gap-6">
                <div class="col-span-6 sm:col-span-3">
                    <label for="name" class="block font-medium text-gray-700">Name</label>
                    <input type="text" name="name" id="name" class="form-input mt-1 block w-full text-xl" required>
                </div>
                <div class="col-span-6 sm:col-span-3">
                    <label for="amount" class="block font-medium text-gray-700">Amount</label>
                    <input type="number" name="amount" id="amount" class="form-input mt-1 block w-full text-xl"
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

        <table class="min-w-full border data-table">
            <thead>
                <tr>
                    <th class="border-b px-4 py-2 text-left">#</th>
                    <th class="border-b px-4 py-2 text-left">Name</th>
                    <th class="border-b px-4 py-2 text-left">Amount</th>
                    <th class="border-b px-4 py-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($levels as $level)
                    <tr>
                        <td class="border-b px-4 py-2">{{ $loop->iteration }}</td>
                        <td class="border-b px-4 py-2">{{ $level->name }}</td>
                        <td class="border-b px-4 py-2">{{ number_format($level->amount, 2) }}</td>
                        <td class="border-b px-4 py-2">
                            <a href="{{ route('levels.edit', $level) }}" class="text-blue-500 hover:text-blue-700">Edit</a>
                            <form class="inline-block" action="{{ route('levels.destroy', $level) }}" method="POST">
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
