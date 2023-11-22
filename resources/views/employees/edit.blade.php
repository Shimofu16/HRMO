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
                                <label for="sick_leave" class="block font-medium text-gray-700">Sick Leave</label>
                                <input type="number" step="0.01" name="sick_leave" id="sick_leave"
                                    class="block w-full mt-1 form-input" required
                                    value="{{ $employee->sickLeave->points }}">
                            </div>
                            <div class="col-span-6 sm:col-span-2">
                                <label for="designation_id"
                                    class="block mb-2 font-bold text-gray-700">Designation</label>
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
                                <select name="category_id" id="category_id" class="form-select mt-1 block w-full"
                                    required>
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
                                <label for="salary_grade_step_id" class="block font-medium text-gray-700">Salary Grade
                                    Step</label>
                                <select name="salary_grade_step_id" id="salary_grade_step_id"
                                    class="block w-full mt-1 form-select" required>
                                    <option value="" selected>--Please select here--</option>
                                </select>
                            </div>

                            <script>
                                // Use an event listener to trigger the AJAX request
                                document.getElementById('sgrade_id').addEventListener('change', function() {
                                    var sgrade_id = this.value;
                                    var select = document.getElementById('salary_grade_step_id');
                                    var employeeSalaryGradeStepId = {!! json_encode($employee->salary_grade_step_id) !!};
                                    console.log(employeeSalaryGradeStepId);
                                    if (sgrade_id) {
                                        // Send an AJAX request to fetch steps based on the selected salary grade
                                        var xhr = new XMLHttpRequest();
                                        xhr.open('GET', '/getSteps?sgrade_id=' + sgrade_id, true);

                                        xhr.onload = function() {
                                            if (xhr.status >= 200 && xhr.status < 400) {
                                                // Parse the JSON response
                                                var steps = JSON.parse(xhr.responseText);

                                                // Populate the steps container with select
                                                select.innerHTML = '<option value="" selected>--Please select here--</option>';
                                                steps.forEach(function(step) {
                                                    select.innerHTML += '<option value="' + step.id + '" ' +
                                                        (step.id === employeeSalaryGradeStepId ? 'selected' : '') +
                                                        '>' + step.step + '</option>';
                                                });
                                            }
                                        };

                                        xhr.send();
                                    }
                                });

                                // Trigger the change event if a default value is present
                                var defaultSgradeId = document.getElementById('sgrade_id').value;
                                if (defaultSgradeId) {
                                    document.getElementById('sgrade_id').dispatchEvent(new Event('change'));
                                }
                            </script>


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
                                <div class="flex flex-col mt-4">
                                    <div>
                                        <h2 class="text-lg font-semibold">Mandatory Deductions</h2>
                                    </div>
                                    @foreach ($deductions as $deduction)
                                        @if ($deduction->deduction_type === 'Mandatory')
                                            <div class="flex items-center mt-1">
                                                <input type="checkbox" name="deduction[]"
                                                    id="deduction_{{ $deduction->id }}" value="{{ $deduction->id }}"
                                                    class="mr-2 form-checkbox"
                                                    {{ $employee->deductions->contains('deduction_id', $deduction->id) ? 'checked' : '' }}>
                                                <label for="deduction_{{ $deduction->id }}"
                                                    class="text-gray-900">{{ $deduction->deduction_code }}</label>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>

                                <div class="flex flex-col mt-4">
                                    <div>
                                        <h2 class="text-lg font-semibold">Non Mandatory Deductions</h2>
                                    </div>
                                    @foreach ($deductions as $deduction)
                                        @if ($deduction->deduction_type === 'Non-Mandatory')
                                            <div class="flex items-center mt-1">
                                                <input type="checkbox" name="deduction[]"
                                                    id="deduction_{{ $deduction->id }}" value="{{ $deduction->id }}"
                                                    class="mr-2 form-checkbox"
                                                    {{ $employee->deductions->contains('deduction_id', $deduction->id) ? 'checked' : '' }}>
                                                <label for="deduction_{{ $deduction->id }}"
                                                    class="text-gray-900">{{ $deduction->deduction_code }}</label>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>


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
