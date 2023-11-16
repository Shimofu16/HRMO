<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Add Deduction
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mt-5 md:mt-0 md:col-span-2">
                <form action="{{ route('deductions.store') }}" method="POST">
                    @csrf
                    <div class="shadow overflow-hidden sm:rounded-md">
                        <div class="px-4 py-5 bg-white sm:p-6">
                            <div class="grid grid-cols-6 gap-6">
                                <div class="col-span-6 sm:col-span-6">
                                    <label for="deduction_name" class="block font-medium text-gray-700">Deduction Name</label>
                                    <input type="text" name="deduction_name" id="deduction_name" class="form-input mt-1 block w-full rounded-md" required>
                                </div>
                                <div class="col-span-6 sm:col-span-6">
                                    <label for="deduction_amount" class="block font-medium text-gray-700">Amount</label>
                                    <input type="number" name="deduction_amount" id="deduction_amount" class="form-input mt-1 block w-full rounded-md" required>
                                </div>
                                <div class="col-span-6 sm:col-span-6">
                                    <label for="deduction_range" class="block font-medium text-gray-700">Range</label>
                                    <select name="deduction_range" id="deduction_range" class="block w-full mt-1 form-select"
                                        required>
                                        <option value="" disabled selected>--Please select here--</option>
                                        <option value="1-15">1-15</option>
                                        <option value="16-30">16-30</option>
                                    </select>
                                </div>
                                <div class="col-span-6 sm:col-span-6">
                                    <label for="dediction_type" class="block font-medium text-gray-700">Type</label>
                                    <select name="dediction_type" id="dediction_type" class="block w-full mt-1 form-select"
                                        required>
                                        <option value="" disabled selected>--Please select here--</option>
                                        <option value="Mandatory">Mandatory</option>
                                        <option value="Non-Madatory">Non-Madatory</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-600 active:bg-blue-700 focus:outline-none focus:border-blue-700 focus:shadow-outline-blue disabled:opacity-25 transition ease-in-out duration-150">
                                Create
                            </button>
                            <a href="{{ route('deductions.index') }}" class="text-gray-500 hover:text-gray-700 font-bold py-2 px-4 rounded">Back</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
