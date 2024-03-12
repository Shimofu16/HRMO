<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Employee: {{ $employee->name }}
        </h2>
    </x-slot>


    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="mt-5 md:mt-0 md:col-span-2">
                <form action="{{ route('employees.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="overflow-hidden  sm:rounded-md">
                        <div class="px-4 py-5 bg-white sm:p-6 shadow">
                            <h1 class="text-xl font-bold">Employee Information</h1>
                            <hr class="mb-3">
                            <div class="grid grid-cols-6 gap-6">
                                <div class="col-span-6 sm:col-span-2">
                                    <label for="emp_no" class="block font-bold text-gray-700">Employee ID</label>
                                    <h1 class="text-2xl text-gray-600">{{ $employee->emp_no }}</h1>
                                </div>

                                <div class="col-span-6 sm:col-span-2">
                                    <label for="oinumber" class="block font-bold text-gray-700">Ordinance Item
                                        Number</label>
                                    <h1 class="text-2xl text-gray-600">{{ $employee->oinumber }}</h1>
                                </div>

                                <div class="col-span-6 sm:col-span-2">
                                    <label for="name" class="block font-bold text-gray-700">Name</label>
                                    <h1 class="text-2xl text-gray-600">{{ $employee->name }}</h1>
                                </div>
                                <div class="col-span-6 sm:col-span-2">
                                    <label for="department_id" class="block font-bold text-gray-700">Department</label>
                                    <select name="department_id" id="department_id"
                                        class="form-select block w-full mt-1 rounded" required>
                                        @foreach ($departments as $department)
                                            <option value="{{ $department->id }}"
                                                {{ $department->id === $employee->department_id ? 'selected' : '' }}>
                                                {{ $department->dep_code }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-span-6 sm:col-span-2">
                                    <label for="sick_leave" class="block font-medium text-gray-700">Sick Leave</label>
                                    <input type="number" step="0.01" name="sick_leave" id="sick_leave"
                                        class="block w-full mt-1 rounded form-input" required
                                        value="{{ $employee->sickLeave->points }}">
                                </div>
                                <div class="col-span-6 sm:col-span-2">
                                    <label for="designation_id"
                                        class="block font-bold text-gray-700">Designation</label>
                                    <select name="designation_id" id="designation_id"
                                        class="form-select block w-full mt-1 rounded" required>
                                        @foreach ($designations as $designation)
                                            <option value="{{ $designation->id }}"
                                                {{ $designation->id === $employee->designation_id ? 'selected' : '' }}>
                                                {{ $designation->designation_code }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-span-6 sm:col-span-2">
                                    <label for="category_id" class="block font-bold text-gray-700">Category</label>
                                    <select name="category_id" id="category_id"
                                        class="form-select block w-full mt-1 rounded" required>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}"
                                                {{ $category->id === $employee->category_id ? 'selected' : '' }}>
                                                {{ $category->category_code }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-span-6 sm:col-span-2">
                                    <label for="sgrade_id" class="block font-bold text-gray-700">Salary
                                        Grade</label>
                                    <select name="sgrade_id" id="sgrade_id"
                                        class="form-select block w-full mt-1 rounded" required>
                                        @foreach ($salary_grades as $sgrade)
                                            <option value="{{ $sgrade->id }}"
                                                {{ $sgrade->id === $employee->sgrade_id ? 'selected' : '' }}>
                                                {{ $sgrade->sg_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-span-6 sm:col-span-2">
                                    <label for="salary_grade_step_id" class="block font-medium text-gray-700">Salary
                                        Grade
                                        Step</label>
                                    <select name="salary_grade_step_id" id="salary_grade_step_id"
                                        class="block w-full mt-1 rounded form-select" required>
                                        <option value="" selected>--Please select here--</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="px-4 py-5 bg-white sm:p-6 shadow my-3">
                            <h1 class="text-xl font-bold">Salary</h1>
                            <hr class="mb-3">
                            <div class="grid grid-cols-6 gap-6">
                                <div class="col-span-6 sm:col-span-2">
                                    <label class="block font-medium text-gray-700">Allowance</label>
                                    <div id="allowanceContainer">
                                        @foreach ($allowances as $allowance)
                                            <div class="flex items-center mt-1" id="allowanceContainer">
                                                <input type="checkbox" name="allowance[]"
                                                    id="allowance_{{ $allowance->id }}" value="{{ $allowance->id }}"
                                                    class="mr-2 form-checkbox"
                                                    {{ $employee->allowances->contains('allowance_id', $allowance->id) ? 'checked' : '' }}>
                                                <label for="allowance_{{ $allowance->id }}"
                                                    class="text-gray-900">{{ $allowance->allowance_code }}</label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="col-span-6 sm:col-span-2">
                                    <label class="block font-medium text-gray-700">Deduction</label>
                                    <div class="flex flex-col mt-4">
                                        <div>
                                            <h2 class="text-sm">Mandatory</h2>
                                        </div>
                                        @foreach ($deductions as $deduction)
                                            @if ($deduction->deduction_type === 'Mandatory')
                                                <div class="flex items-center mt-1">
                                                    <input type="checkbox" name="deduction[]"
                                                        id="deduction_{{ $deduction->id }}"
                                                        value="{{ $deduction->id }}" class="mr-2 form-checkbox"
                                                        {{ $employee->deductions->contains('deduction_id', $deduction->id) ? 'checked' : '' }}>
                                                    <label for="deduction_{{ $deduction->id }}"
                                                        class="text-gray-900">{{ $deduction->deduction_code }}</label>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>

                                    <div class="flex flex-col mt-4">
                                        <div>
                                            <h2 class="text-sm">Non Mandatory</h2>
                                        </div>
                                        @foreach ($deductions as $deduction)
                                            @if ($deduction->deduction_type === 'Non-Mandatory')
                                                <div class="flex items-center mt-1">
                                                    <input type="checkbox" name="deduction[]"
                                                        id="deduction_{{ $deduction->id }}"
                                                        value="{{ $deduction->id }}" class="mr-2 form-checkbox"
                                                        {{ $employee->deductions->contains('deduction_id', $deduction->id) ? 'checked' : '' }}>
                                                    <label for="deduction_{{ $deduction->id }}"
                                                        class="text-gray-900">{{ $deduction->deduction_code }}</label>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>

                                <div class="col-span-6 sm:col-span-2">
                                    <div>
                                        <label class="block font-medium text-gray-700">Loans</label>
                                        @foreach ($employee->loans as $loan)
                                            <h2 class="text-sm">{{ $loan->loan->name }} - {{ $loan->amount }}
                                            </h2>
                                        @endforeach
                                    </div>
                                    {{-- <div class="col-span-6 sm:col-span-2">
                                        <label for="loan_id" class="block font-medium text-gray-700">Add Loan</label>
                                        <select name="loan_id" id="loan_id"
                                            class="block w-full mt-1 rounded form-select">
                                            <option value="" disabled selected>--Please select here--</option>
                                            @foreach ($loans as $laon)
                                                <option value="{{ $laon->id }}">{{ $laon->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-span-6 sm:col-span-2">
                                        <label for="amount" class="block font-medium text-gray-700">Amount</label>
                                        <input type="text" name="amount" id="amount"
                                            class="block w-full mt-1 rounded">
                                    </div> --}}
                                </div>
                            </div>
                        </div>

                        <div class="px-4 py-3 text-right sm:px-6">
                            <x-primary-button class="ml-3">
                                {{ __('Save changes') }}
                            </x-primary-button>
                            <a href="{{ route('employees.index') }}"
                                class="px-4 py-2 font-bold text-gray-500 rounded hover:text-gray-700">Back</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        // Use an event listener to trigger the AJAX request
        document.getElementById('sgrade_id').addEventListener('change', function() {
            var sgrade_id = this.value;
            var select = document.getElementById('salary_grade_step_id');
            var employeeSalaryGradeStepId = {!! json_encode($employee->salary_grade_step_id) !!};

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


        document.getElementById('category_id').addEventListener('change', function() {
            var categoryId = this.value;
            var allowanceContainer = document.getElementById('allowanceContainer');
            // Clear the allowance container
            allowanceContainer.innerHTML = '';

            if (categoryId) {
                // Send an AJAX request to fetch allowances based on the selected category
                var xhr = new XMLHttpRequest();
                xhr.open('GET', '/getAllowances?category_id=' + categoryId, true);

                xhr.onload = function() {
                    if (xhr.status >= 200 && xhr.status < 400) {
                        // Parse the JSON response
                        var allowances = JSON.parse(xhr.responseText);

                        // Populate the allowance container with checkboxes
                        allowances.forEach(function(allowance) {
                            var checkbox = document.createElement('input');
                            checkbox.type = 'checkbox';
                            checkbox.name = 'allowance[]';
                            checkbox.value = allowance.id;
                            checkbox.id = 'allowance_' + allowance.id;
                            checkbox.classList.add('mr-2');

                            if (employee.allowances.find(function(employeeAllowance) {
                                    return employeeAllowance.id === allowance.id;
                                })) {
                                checkbox.checked = true;
                            }

                            var label = document.createElement('label');
                            label.htmlFor = 'allowance_' + allowance.id;
                            label.classList.add('me-2');
                            label.appendChild(document.createTextNode(allowance.allowance_code));

                            var div = document.createElement('div');
                            div.classList.add('flex', 'items-center', 'mt-1');
                            div.appendChild(checkbox);
                            div.appendChild(label);

                            allowanceContainer.appendChild(div);
                        });
                    }
                };

                xhr.send();
            }
        });

        // document.getElementById('loan_id').addEventListener('change', function() {
        //     var loanId = this.value;
        //     var loanAmount = document.getElementById('amount');
        //     if (loanId) {
        //         var xhr = new XMLHttpRequest();
        //         xhr.open('GET', '/getLoan?loan_id=' + loanId, true);
        //         xhr.onload = function() {
        //             if (xhr.status >= 200 && xhr.status < 400) {
        //                 var amount = xhr.responseText;
        //                 loanAmount.value = amount;
        //             }
        //         };

        //         xhr.send();
        //     }
        // });
        // Trigger the change event if a default value is present
        var defaultSalaryGradeId = document.getElementById('sgrade_id').value;
        if (defaultSalaryGradeId) {
            document.getElementById('sgrade_id').dispatchEvent(new Event('change'));
        }
    </script>
</x-app-layout>
