@extends('settings.index')
@section('contents')
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Allowance
        </h2>
    </x-slot>
    <div class="bg-white mt-8 p-5 mx-8 shadow rounded-md">
        <form action="{{ route('allowances.store') }}" method="POST">
            @csrf
            <div class="grid grid-cols-6 gap-6">
                <div class="col-span-6 sm:col-span-2">
                    <label for="allowance_code" class="block font-medium text-gray-700">Code</label>
                    <input type="text" name="allowance_code" id="allowance_code"
                        class="block w-full mt-1 rounded" required>
                </div>
                <div class="col-span-6 sm:col-span-2">
                    <label for="allowance_name" class="block font-medium text-gray-700">Name</label>
                    <input type="text" name="allowance_name" id="allowance_name"
                        class="block w-full mt-1 rounded" required>
                </div>
                <div class="col-span-6 sm:col-span-2">
                    <label for="allowance_amount" class="block font-medium text-gray-700">Amount</label>
                    <input type="number" name="allowance_amount" id="allowance_amount"
                        class="block w-full mt-1 rounded" required>
                </div>
            </div>
            <div class="grid grid-cols-6 gap-6">
                <div class="col-span-3 sm:col-span-3">
                    <label for="allowance_range" class="block font-medium text-gray-700">Range</label>
                    <input type="text" name="allowance_range" id="allowance_range"
                        class="block w-full mt-1 rounded" required placeholder="Ex: 1-15 or 16-31">
                </div>
                <div class="col-span-3 sm:col-span-3">
                    <label for="category_id" class="block font-medium text-gray-700">Type</label>
                    <select name="category_id" id="category_id" class="block w-full mt-1 rounded form-select"
                        required>
                        <option value="" disabled selected>--Please select here--</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                        @endforeach
                    </select>
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

        <table class="min-w-full border bg-white">
            <thead>
                <tr>
                    <th class="border-b px-4 py-2 text-left">#</th>
                    <th class="border-b px-4 py-2 text-left">Code</th>
                    <th class="border-b px-4 py-2 text-left">Name</th>
                    <th class="border-b px-4 py-2 text-left">Amount</th>
                    <th class="border-b px-4 py-2 text-left">Rage</th>
                    <th class="border-b px-4 py-2 text-left">Category</th>
                    <th class="border-b px-4 py-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($allowances as $allowance)
                    <tr>
                        <td class="border-b px-4 py-2">{{ $loop->iteration }}</td>
                        <td class="border-b px-4 py-2">{{ $allowance->allowance_code }}</td>
                        <td class="border-b px-4 py-2">{{ $allowance->allowance_name }}</td>
                        <td class="border-b px-4 py-2">{{ $allowance->allowance_amount }}</td>
                        <td class="border-b px-4 py-2">{{ $allowance->allowance_range }}</td>
                        <td class="border-b px-4 py-2">{{ $allowance->category->category_name }}</td>
                        <td class="border-b px-4 py-2">
                            <a href="{{ route('allowances.edit', $allowance) }}"
                                class="text-blue-500 hover:text-blue-700">Edit</a>
                            <form class="inline-block" action="{{ route('allowances.destroy', $allowance) }}"
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
