@extends('settings.index')
@section('header')
    Hazard
@endsection
@section('contents')
    <div class="mx-8 mt-8 rounded-md bg-white p-5 shadow">
        <form action="{{ route('hazards.store') }}" method="POST">
            @csrf
            <div class="mb-3 grid grid-cols-6 gap-6">
                <div class="col-span-6 sm:col-span-2">
                    <label for="name" class="block font-medium text-gray-700">Name</label>
                    <input type="text" name="name" id="name" class="mt-1 block w-full rounded" required>
                </div>
                <div class="col-span-6 sm:col-span-2">
                    <label for="category_id" class="block font-medium text-gray-700">Category</label>
                    <select name="category_id" id="category_id" class="form-select mt-1 block w-full rounded" required>
                        <option value="" selected>--Please select here--</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-span-6 sm:col-span-2">
                    <label for="department_id" class="block font-medium text-gray-700">Department</label>
                    <select name="department_id" id="department_id" class="form-select mt-1 block w-full rounded" required>
                        <option value="" selected>--Please select here--</option>
                        @foreach ($departments as $department)
                            <option value="{{ $department->id }}">{{ $department->dep_name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="mb-3 grid grid-cols-6 gap-6">
                <div class="col-span-6 sm:col-span-2">
                    <label for="salary_grades" class="block font-medium text-gray-700">Salary Grade</label>
                    <select name="salary_grades[]" id="salary_grades" class="form-select mt-1 block w-full rounded"
                        multiple="multiple" required>

                        @foreach ($salary_grades as $grade)
                            <option value="{{ $grade->id }}"> Salary
                                Grade
                                {{ $grade->id }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-span-6 sm:col-span-2">
                    <label for="ranges" class="block font-medium text-gray-700">Range</label>
                    <select name="ranges[]" id="ranges" class="form-select mt-1 block w-full rounded" multiple="multiple"
                        required>

                        <option value="1-15">1-15</option>
                        <option value="16-31">16-31</option>
                    </select>
                </div>
                <div class="col-span-6 sm:col-span-2">
                    <label for="amount" class="block font-medium text-gray-700">Amount</label>
                    <input type="number" name="amount" id="amount" class="mt-1 block w-full rounded"
                        required>
                </div>
                <div class="col-span-6 sm:col-span-2">
                    <label for="amount_type" class="block font-medium text-gray-700">Amount Type</label>
                    <select name="amount_type" id="amount_type" class="form-select mt-1 block w-full rounded" required>
                        <option value="" selected>--Please select here--</option>
                        <option value="percentage">Percentage (%)</option>
                        <option value="fixed_amount">Fixed Amount</option>
                    </select>
                </div>
            </div>
            <div class="py-3 text-right sm:px-6">
                <x-primary-button class="mr-1">
                    {{ __('Create') }}
                </x-primary-button>
            </div>
        </form>
    </div>
    <div class="mt-5 rounded-md bg-white p-5 shadow">

        <table class="min-w-full border bg-white data-table">
            <thead>
                <tr>
                    <th class="border-b px-4 py-2 text-left">#</th>
                    <th class="border-b px-4 py-2 text-left">Name</th>
                    <th class="border-b px-4 py-2 text-left">Category</th>
                    <th class="border-b px-4 py-2 text-left">Department</th>
                    <th class="border-b px-4 py-2 text-left">Salary Grade</th>
                    <th class="border-b px-4 py-2 text-left">Range</th>
                    <th class="border-b px-4 py-2 text-left">Amount</th>
                    <th class="border-b px-4 py-2 text-left">Amount Type</th>
                    <th class="border-b px-4 py-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($hazards as $hazard)
                    <tr>
                        <td class="border-b px-4 py-2">{{ $loop->iteration }}</td>
                        <td class="border-b px-4 py-2">{{ $hazard->name }}</td>
                        <td class="border-b px-4 py-2">{{ $hazard->category->category_name }}</td>
                        <td class="border-b px-4 py-2">{{ $hazard->department->dep_name }}</td>
                        <td class="border-b px-4 py-2">
                            @foreach ($hazard->salaryGrades as $grade)
                               Salary garade {{ $grade->salary_grade_id }}@if (!$loop->last)
                                    ,
                                @endif
                            @endforeach
                        </td>
                        <td class="border-b px-4 py-2">
                            @foreach ($hazard->ranges as $range)
                                {{ $range }}@if (!$loop->last)
                                    ,
                                @endif
                            @endforeach
                        </td>
                        <td class="border-b px-4 py-2">{{ $hazard->amount }}</td>
                        <td class="border-b px-4 py-2">{{ $hazard->amount_type }}</td>
                        <td class="border-b px-4 py-2">
                            <a href="{{ route('hazards.edit', $hazard) }}"
                                class="text-blue-500 hover:text-blue-700">Edit</a>
                            {{-- <form class="inline-block" action="{{ route('hazards.destroy', $hazard) }}" method="POST">
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
@endsection
