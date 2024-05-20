<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            Edit Allowance: {{ $allowance->allowance_name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-xl sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200 sm:px-20">
                    <form action="{{ route('allowances.update', $allowance) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="grid grid-cols-6 gap-6 mb-3">
                            <div class="col-span-6 sm:col-span-2">
                                <label for="allowance_code" class="block font-medium text-gray-700">Code</label>
                                <input type="text" name="allowance_code" id="allowance_code"
                                    class="block w-full mt-1 rounded" value="{{ $allowance->allowance_code }}" required>
                            </div>
                            <div class="col-span-6 sm:col-span-2">
                                <label for="allowance_name" class="block font-medium text-gray-700">Name</label>
                                <input type="text" name="allowance_name" id="allowance_name"
                                    class="block w-full mt-1 rounded" value="{{ $allowance->allowance_name }}" required>
                            </div>
                            <div class="col-span-6 sm:col-span-2">
                                <label for="allowance_amount" class="block font-medium text-gray-700">Amount</label>
                                <input type="number" name="allowance_amount" id="allowance_amount"
                                    class="block w-full mt-1 rounded" value="{{ $allowance->allowance_amount }}" required>
                            </div>
                        </div>
                        <div class="grid grid-cols-6 gap-6">
                            <div class="col-span-3 sm:col-span-3">
                                <label for="category_id" class="block font-medium text-gray-700">Category</label>
                                <select name="category_id[]" id="category_id"
                                    class="block w-full mt-1 rounded form-select" multiple="multiple" required>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-span-6 sm:col-span-3">
                                <label for="allowance_ranges" class="block font-medium text-gray-700">Range</label>
                                <select name="allowance_ranges[]" id="allowance_ranges"
                                    class="block w-full mt-1 rounded form-select" multiple="multiple" required>
                                    <option value="1-15">1-15</option>
                                    <option value="16-31">16-31</option>
                                </select>
                            </div>
                        </div>
                        <div class="grid grid-cols-6 gap-6">
                            <div class="col-span-3 sm:col-span-3">
                                <label for="department_id" class="block font-medium text-gray-700">Department</label>
                                <select name="department_id[]" id="department_id"
                                    class="block w-full mt-1 rounded form-select" multiple="multiple" required>
                                    @foreach ($departments as $department)
                                        <option value="{{ $department->id }}">{{ $department->dep_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-span-6 sm:col-span-3">
                                <label for="rata_types" class="block font-medium text-gray-700">RA/TA Type</label>
                                <select name="rata_types[]" id="rata_types"
                                    class="block w-full mt-1 rounded form-select" multiple="multiple" required>
                                    @foreach ($rataTypes as $key => $rataType)
                                        <option value="{{ $key }}">{{ $rataType['type'] }} -
                                            {{ $rataType['amount'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <p id="helper-text-explanation" class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                            Note:To update the range and category, select all the data you want to change.
                        </p>

                        <div class="flex items-center justify-end mt-6">
                            <button class="px-4 py-2 mr-4 font-bold text-white bg-blue-500 rounded hover:bg-blue-700">
                                Update
                            </button>
                            <a href="{{ route('allowances.index') }}"
                                class="px-4 py-2 font-bold text-gray-500 rounded hover:text-gray-700">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @push('styles')
        <link rel="stylesheet" href="{{ asset('assets/select2-4.1.0-rc.0/css/select2.min.css') }}">
    @endpush
    @push('scripts')
        <script src="{{ asset('assets/select2-4.1.0-rc.0/js/select2.min.js') }}"></script>
        <script>
            $(document).ready(function() {
                $('#category_id').select2();
                $('#allowance_ranges').select2();
                $('#department_id').select2();
                $('#rata_types').select2();
            });
        </script>
    @endpush
</x-app-layout>
