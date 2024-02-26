
@extends('settings.index')
@section('contents')
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Deduction
        </h2>
    </x-slot>
    <div class="bg-white mt-8 p-5 mx-8 shadow rounded-md">
        <form action="{{ route('deductions.store') }}" method="POST">
            @csrf
            <div class="grid grid-cols-6 gap-6">
                <div class="col-span-6 sm:col-span-2">
                    <label for="deduction_code" class="block font-medium text-gray-700">Code</label>
                    <input type="text" name="deduction_code" id="deduction_code"
                        class="block w-full mt-1 rounded" required>
                </div>
                <div class="col-span-6 sm:col-span-2">
                    <label for="deduction_name" class="block font-medium text-gray-700">Name</label>
                    <input type="text" name="deduction_name" id="deduction_name"
                        class="block w-full mt-1 rounded" required>
                </div>
                <div class="col-span-6 sm:col-span-2">
                    <label for="deduction_amount" class="block font-medium text-gray-700">Amount</label>
                    <input type="number" name="deduction_amount" id="deduction_amount"
                        class="block w-full mt-1 rounded" required>
                </div>
            </div>
            <div class="grid grid-cols-6 gap-6">
                <div class="col-span-6 sm:col-span-2">
                    <label for="deduction_amount_type" class="block font-medium text-gray-700">Amount Type</label>
                    <select name="deduction_amount_type" id="deduction_amount_type"
                        class="block w-full mt-1 rounded form-select" required>
                        <option value="" disabled selected>--Please select here--</option>
                        <option value="percentage">Percentage (%)</option>
                        <option value="fixed_amount">Fixed Amount (000)</option>
                    </select>
                </div>
                <div class="col-span-6 sm:col-span-2">
                    <label for="deduction_range" class="block font-medium text-gray-700">Range</label>
                    <select name="deduction_range" id="deduction_range"
                        class="block w-full mt-1 rounded form-select" required>
                        <option value="" disabled selected>--Please select here--</option>
                        <option value="1-15">1-15</option>
                        <option value="16-30">16-30</option>
                    </select>
                </div>
                <div class="col-span-6 sm:col-span-2">
                    <label for="deduction_type" class="block font-medium text-gray-700">Type</label>
                    <select name="deduction_type" id="deduction_type"
                        class="block w-full mt-1 rounded form-select" required>
                        <option value="" disabled selected>--Please select here--</option>
                        <option value="Mandatory">Mandatory</option>
                        <option value="Non-Mandatory">Non-Mandatory</option>
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

        <table class="min-w-full border data-table">
            <thead>
                <tr>
                    <th class="border-b px-4 py-2 text-left">#</th>
                    <th class="border-b px-4 py-2 text-left">Code</th>
                    <th class="border-b px-4 py-2 text-left">Name</th>
                    <th class="border-b px-4 py-2 text-left">Amount</th>
                    <th class="border-b px-4 py-2 text-left">Range</th>
                    <th class="border-b px-4 py-2 text-left">Type</th>
                    <th class="border-b px-4 py-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($deductions as $deduction)
                    <tr>
                        <td class="border-b px-4 py-2">{{ $loop->iteration }}</td>
                        <td class="border-b px-4 py-2">{{ $deduction->deduction_code }}</td>
                        <td class="border-b px-4 py-2">{{ $deduction->deduction_name }}</td>
                        <td class="border-b px-4 py-2">
                            {{ $deduction->deduction_amount_type == 'percentage' ? percentage($deduction->deduction_amount) : number_format($deduction->deduction_amount) }}
                        </td>
                        <td class="border-b px-4 py-2">{{ $deduction->deduction_range }}</td>
                        <td class="border-b px-4 py-2">{{ $deduction->deduction_type }}</td>
                        <td class="border-b px-4 py-2">
                            <a href="{{ route('deductions.edit', $deduction) }}"
                                class="text-blue-500 hover:text-blue-700">Edit</a>
                            <form class="inline-block" action="{{ route('deductions.destroy', $deduction) }}"
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
