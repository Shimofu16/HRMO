<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            Edit Hazard: {{ $hazard->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-xl sm:rounded-lg">
                <div class="border-b border-gray-200 bg-white p-6 sm:px-20">
                    <form action="{{ route('hazards.update', $hazard) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3 grid grid-cols-6 gap-6">
                            <div class="col-span-6 sm:col-span-2">
                                <label for="name" class="block font-medium text-gray-700">Name</label>
                                <input type="text" name="name" id="name" class="mt-1 block w-full rounded" value="{{ $hazard->name }}" required>
                            </div>
                            <div class="col-span-6 sm:col-span-2">
                                <label for="category_id" class="block font-medium text-gray-700">Category</label>
                                <select name="category_id" id="category_id" class="form-select mt-1 block w-full rounded" required>
                                    <option value="" disabled>--Please select here--</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}" {{ $hazard->category_id == $category->id ? 'selected' : '' }}>{{ $category->category_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-span-6 sm:col-span-2">
                                <label for="department_id" class="block font-medium text-gray-700">Department</label>
                                <select name="department_id" id="department_id" class="form-select mt-1 block w-full rounded" required>
                                    <option value="" disabled>--Please select here--</option>
                                    @foreach ($departments as $department)
                                        <option value="{{ $department->id }}" {{ $hazard->department_id == $department->id ? 'selected' : '' }}>{{ $department->dep_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="mb-3 grid grid-cols-6 gap-6">
                            <div class="col-span-6 sm:col-span-2">
                                <label for="salary_grades" class="block font-medium text-gray-700">Salary Grade</label>
                                <select name="salary_grades[]" id="salary_grades" class="form-select mt-1 block w-full rounded" multiple="multiple" required>
                                    @foreach ($salary_grades as $grade)
                                        <option value="{{ $grade->id }}" {{ in_array($grade->id, $hazard->salaryGrades->pluck('salary_grade_id')->toArray()) ? 'selected' : '' }}>Salary Grade {{ $grade->id }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-span-6 sm:col-span-2">
                                <label for="ranges" class="block font-medium text-gray-700">Range</label>
                                <select name="ranges[]" id="ranges" class="form-select mt-1 block w-full rounded" multiple="multiple" required>
                                    <option value="1-15" {{ in_array('1-15', $hazard->ranges) ? 'selected' : '' }}>1-15</option>
                                    <option value="16-31" {{ in_array('16-31', $hazard->ranges) ? 'selected' : '' }}>16-31</option>
                                </select>
                            </div>
                            <div class="col-span-6 sm:col-span-2">
                                <label for="amount" class="block font-medium text-gray-700">Amount</label>
                                <input type="number" name="amount" id="amount" class="mt-1 block w-full rounded" value="{{ $hazard->amount }}" required>
                            </div>
                            <div class="col-span-6 sm:col-span-2">
                                <label for="amount_type" class="block font-medium text-gray-700">Amount Type</label>
                                <select name="amount_type" id="amount_type" class="form-select mt-1 block w-full rounded" required>
                                    <option value="" disabled>--Please select here--</option>
                                    <option value="percentage" {{ $hazard->amount_type == 'percentage' ? 'selected' : '' }}>Percentage (%)</option>
                                    <option value="fixed_amount" {{ $hazard->amount_type == 'fixed_amount' ? 'selected' : '' }}>Fixed Amount</option>
                                </select>
                            </div>
                        </div>

                        <div class="mt-6 flex items-center justify-end">
                            <button class="mr-4 rounded bg-blue-500 px-4 py-2 font-bold text-white hover:bg-blue-700">
                                Update
                            </button>
                            <a href="{{ route('hazards.index') }}"
                                class="rounded px-4 py-2 font-bold text-gray-500 hover:text-gray-700">Cancel</a>
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
                $('#salary_grades').select2();
                $('#ranges').select2();
            });
        </script>
    @endpush
</x-app-layout>
