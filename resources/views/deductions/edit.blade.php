<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Deduction: {{ $deduction->deduction_name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
                    <form action="{{ route('deductions.update', $deduction) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="grid grid-cols-6 gap-6">
                            <div class="col-span-6 sm:col-span-4">
                                <label for="deduction_code" class="block mb-2 font-bold text-gray-700">Code</label>
                                <input type="text" name="deduction_code" id="deduction_code" value="{{ $deduction->deduction_code }}"
                                    class="block w-full p-2 border rounded" required>
                            </div>
                            <div class="col-span-6 sm:col-span-4">
                                <label for="deduction_name" class="block mb-2 font-bold text-gray-700">Name</label>
                                <input type="text" name="deduction_name" id="deduction_name" value="{{ $deduction->deduction_name }}"
                                    class="block w-full p-2 border rounded" required>
                            </div>
                            <div class="col-span-6 sm:col-span-4">
                                <label for="deduction_amount" class="block mb-2 font-bold text-gray-700">Amount</label>
                                <input type="text" name="deduction_amount" id="deduction_amount" value="{{ $deduction->deduction_amount }}"
                                    class="block w-full p-2 border rounded" required>
                            </div>
                        </div>
                        <div class="flex items-center justify-end mt-6">
                            <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mr-4">
                                Update
                            </button>
                            <a href="{{ route('deductions.index') }}"
                                class="text-gray-500 hover:text-gray-700 font-bold py-2 px-4 rounded">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
