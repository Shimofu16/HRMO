<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            Add Employee
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="mt-5 md:mt-0 md:col-span-2">
                <form action="{{ route('employees.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="overflow-hidden shadow sm:rounded-md">
                        <div class="px-4 py-5 bg-white sm:p-6">
                            <div class="grid grid-cols-6 gap-6">    
                                <div class="col-span-6 sm:col-span-2">
                                    <label for="name" class="block font-medium text-gray-700">Name</label>
                                    <input type="text" name="name" id="name"
                                        class="block w-full mt-1 form-input" required>
                                </div>

                                <div class="col-span-6 sm:col-span-2">
                                    <label for="oinumber" class="block font-medium text-gray-700">Ordinance Item
                                        Number</label>
                                    <input type="text" name="oinumber" id="oinumber"
                                        class="block w-full mt-1 form-input" required>
                                </div>

                                <div class="col-span-6 sm:col-span-2">
                                    <label for="sgrade_id" class="block font-medium text-gray-700">Salary Grade</label>
                                    <select name="sgrade_id" id="sgrade_id" class="block w-full mt-1 form-select"
                                        required>
                                        <option value="" disabled selected>--Please select here--</option>
                                        @foreach ($sgrades as $sgrade)
                                            <option value="{{ $sgrade->id }}">{{ $sgrade->sg_code }}</option>
                                        @endforeach
                                    </select>
                                </div>


                                <div class="col-span-6 sm:col-span-2">
                                    <label for="department_id" class="block font-medium text-gray-700">Department</label>
                                    <select name="department_id" id="department_id" class="block w-full mt-1 form-select"
                                        required>
                                        <option value="" disabled selected>--Please select here--</option>
                                        @foreach ($departments as $department)
                                            <option value="{{ $department->id }}">{{ $department->dep_code }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-span-6 sm:col-span-2">
                                    <label for="designation_id" class="block font-medium text-gray-700">Designation</label>
                                    <select name="designation_id" id="designation_id" class="block w-full mt-1 form-select"
                                        required>
                                        <option value="" disabled selected>--Please select here--</option>
                                        @foreach ($designations as $designation)
                                            <option value="{{ $designation->id }}">{{ $designation->designation_code }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-span-6 sm:col-span-2">
                                    <label for="category_id" class="block font-medium text-gray-700">Category</label>
                                    <select name="category_id" id="category_id" class="block w-full mt-1 form-select"
                                        required>
                                        <option value="" disabled selected>--Please select here--</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->category_code }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                {{-- <div class="col-span-6 sm:col-span-2">
                                    <label for="schedule_id" class="block font-medium text-gray-700">Schedule</label>
                                    <select name="schedule_id" id="schedule_id" class="block w-full mt-1 form-select"
                                        required>
                                        <option value="" disabled selected>--Please select here--</option>
                                        @foreach ($schedules as $schedule)
                                            <option value="{{ $schedule->id }}">{{ $schedule->sched_name }}</option>
                                        @endforeach
                                    </select>
                                </div> --}}

                                <div class="col-span-6 sm:col-span-2">
                                    <label class="block font-medium text-gray-700">Allowance</label>
                                    @foreach ($allowances as $id => $allowance_code)
                                        <div class="flex items-center mt-1">
                                            <input type="checkbox" name="allowance[]" id="allowance_{{ $id }}"
                                                value="{{ $id }}" class="mr-2 form-checkbox">
                                            <label for="allowance_{{ $id }}"
                                                class="text-gray-900">{{ $allowance_code }}</label>
                                        </div>
                                    @endforeach
                                </div>

                                {{-- <div class="col-span-6 sm:col-span-2">
                                    <label for="deduction" class="block font-medium text-gray-700">Deduction</label>
                                    <select name="deduction" id="deduction" class="block w-full mt-1 form-select"
                                        required>
                                        <option value="" disabled selected>--Please select here--</option>
                                        @foreach ($deductions as $id => $deduction_code)
                                            <option value="{{ $deduction_code }}">{{ $deduction_code }}</option>
                                        @endforeach
                                    </select>
                                </div> --}}

                                <div class="col-span-6 sm:col-span-2">
                                    <label class="block font-medium text-gray-700">Deduction</label>
                                    @foreach ($deductions as $id => $deduction_code)
                                        <div class="flex items-center mt-1">
                                            <input type="checkbox" name="deduction[]" id="deduction_{{ $id }}"
                                            value="{{ $id }}" class="mr-2 form-checkbox">
                                            <label for="deduction_{{ $id }}"
                                                class="text-gray-900">{{ $deduction_code }}</label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="px-4 py-3 text-right bg-gray-50 sm:px-6">
                            <x-primary-button class="ml-3">
                                {{ __('Create') }}
                            </x-primary-button>
                            <a href="{{ route('employees.index') }}"
                                class="px-4 py-2 font-bold text-gray-500 rounded hover:text-gray-700">Back</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
