<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Employee: {{ $employee->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
                    <form action="{{ route('employees.update', $employee) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="grid grid-cols-6 gap-6">
                            <div class="col-span-6 sm:col-span-2">
                                <label for="emp_no" class="block mb-2 font-bold text-gray-700">Employee ID</label>
                                <h1 class="text-2xl text-gray-600">{{ $employee->emp_no }}</h1>
                            </div>

                            <div class="col-span-6 sm:col-span-2">
                                <label for="oinumber" class="block mb-2 font-bold text-gray-700">Ordinance Item
                                    Number</label>
                                <h1 class="text-2xl text-gray-600">{{ $employee->oinumber }}</h1>
                            </div>

                            <div class="col-span-6 sm:col-span-2">
                                <label for="name" class="block mb-2 font-bold text-gray-700">Name</label>
                                <h1 class="text-2xl text-gray-600">{{ $employee->name }}</h1>
                            </div>

                            <div class="col-span-6 sm:col-span-2">
                                <label for="department_id" class="block mb-2 font-bold text-gray-700">Department</label>
                                <select name="department_id" id="department_id" class="form-select mt-1 block w-full"
                                    required>
                                    @foreach ($departments as $department)
                                        <option value="{{ $department->id }}"
                                            {{ $department->id === $employee->department_id ? 'selected' : '' }}>
                                            {{ $department->dep_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-span-6 sm:col-span-2">
                                <label for="designation_id" class="block mb-2 font-bold text-gray-700">Designation</label>
                                <select name="designation_id" id="designation_id" class="form-select mt-1 block w-full"
                                    required>
                                    @foreach ($designations as $designation)
                                        <option value="{{ $designation->id }}"
                                            {{ $designation->id === $employee->designation_id ? 'selected' : '' }}>
                                            {{ $designation->designation_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-span-6 sm:col-span-2">
                                <label for="category_id" class="block mb-2 font-bold text-gray-700">Category</label>
                                <select name="category_id" id="category_id" class="form-select mt-1 block w-full" required>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}"
                                            {{ $category->id === $employee->category_id ? 'selected' : '' }}>
                                            {{ $category->category_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-span-6 sm:col-span-2">
                                <label for="sgrade_id" class="block mb-2 font-bold text-gray-700">Salary Grade</label>
                                <select name="sgrade_id" id="sgrade_id" class="form-select mt-1 block w-full" required>
                                    @foreach ($sgrades as $sgrade)
                                        <option value="{{ $sgrade->id }}"
                                            {{ $sgrade->id === $employee->sgrade_id ? 'selected' : '' }}>
                                            {{ $sgrade->sg_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>



                            <div class="col-span-6 sm:col-span-2">
                                <label class="block font-medium text-gray-700">Allowance</label>
                                @foreach ($allowances as $allowance)
                                <div class="flex items-center mt-1">
                                    <input type="checkbox" name="allowance[]" id="allowance_{{ $allowance->id }}"
                                        value="{{ $allowance->id }}" class="mr-2 form-checkbox"
                                        {{ $employee->allowances->contains('allowance_id', $allowance->id) ? 'checked' : '' }}>
                                    <label for="allowance_{{ $allowance->id }}"
                                        class="text-gray-900">{{ $allowance->allowance_code }}</label>
                                </div>
                            @endforeach

                            </div>


                            <div class="col-span-6 sm:col-span-2">
                                <label class="block font-medium text-gray-700">Deduction</label>
                                @foreach ($deductions as $deduction)
    <div class="flex items-center mt-1">
        <input type="checkbox" name="deduction[]"
            id="deduction_{{ $deduction->id }}" value="{{ $deduction->id }}"
            class="mr-2 form-checkbox"
            {{ $employee->deductions->contains('deduction_id', $deduction->id) ? 'checked' : '' }}>
        <label for="deduction_{{ $deduction->id }}"
            class="text-gray-900">{{ $deduction->deduction_code }}</label>
    </div>
@endforeach

                            </div>
                        </div>
                        <div class="flex items-center justify-end mt-6">
                            <button
                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mr-4">Update</button>
                            <a href="{{ route('employees.index') }}"
                                class="text-gray-500 hover:text-gray-700 font-bold py-2 px-4 rounded">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>