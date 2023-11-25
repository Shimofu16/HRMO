<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Allowance: {{ $allowance->allowance_name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
                    <form action="{{ route('allowances.update', $allowance) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="grid grid-cols-6 gap-6">
                            <div class="col-span-6 sm:col-span-2">
                                <label for="allowance_code" class="block font-medium text-gray-700">Code</label>
                                <input type="text" name="allowance_code" id="allowance_code"
                                    class="block w-full mt-1 rounded" required value="{{ $allowance->allowance_name }}">
                            </div>
                            <div class="col-span-6 sm:col-span-2">
                                <label for="allowance_name" class="block font-medium text-gray-700">Name</label>
                                <input type="text" name="allowance_name" id="allowance_name"
                                    class="block w-full mt-1 rounded" required value="{{ $allowance->allowance_name }}">
                            </div>
                            <div class="col-span-6 sm:col-span-2">
                                <label for="allowance_amount" class="block font-medium text-gray-700">Amount</label>
                                <input type="number" name="allowance_amount" id="allowance_amount"
                                    class="block w-full mt-1 rounded" required value="{{ $allowance->allowance_amount }}">
                            </div>
                        </div>
                        <div class="grid grid-cols-6 gap-6">
                            <div class="col-span-3 sm:col-span-3">
                                <label for="allowance_range" class="block font-medium text-gray-700">Range</label>
                                <input type="text" name="allowance_range" id="allowance_range"
                                    class="block w-full mt-1 rounded" required placeholder="Ex: 1-15 or 16-31" value="{{ $allowance->allowance_range }}">
                            </div>
                            <div class="col-span-3 sm:col-span-3">
                                <label for="category_id" class="block font-medium text-gray-700">Type</label>
                                <select name="category_id" id="category_id" class="block w-full mt-1 rounded form-select"
                                    required>
                                    <option value="" disabled selected>--Please select here--</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}" {{ ($category->id == $allowance->category_id) ? 'selected' : '' }}>{{ $category->category_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="flex items-center justify-end mt-6">
                            <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mr-4">
                                Update
                            </button>
                            <a href="{{ route('allowances.index') }}"
                                class="text-gray-500 hover:text-gray-700 font-bold py-2 px-4 rounded">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
