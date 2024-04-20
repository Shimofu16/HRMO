{{-- <form action="{{ route('employees.store') }}" method="POST" enctype="multipart/form-data"> --}}
<form wire:submit.prevent="save" enctype="multipart/form-data">
    @csrf
    <div class="overflow-hidden  sm:rounded-md">
        <div class="px-4 py-5 bg-white sm:p-6 shadow">
            <h1 class="text-xl font-bold">Employee Information</h1>
            <hr class="mb-3">
            <div class="grid grid-cols-6 gap-6">
                <div class="col-span-6 sm:col-span-2">
                    <label for="employee_number" class="block font-medium text-gray-700">ID Number</label>
                    <input type="text" name="employee_number" id="employee_number" wire:model='employee_number'
                        class="block w-full mt-1 rounded" required>
                </div>
                <div class="col-span-6 sm:col-span-2">
                    <label for="ordinance_number" class="block font-medium text-gray-700">Ordinance Item
                        Number</label>
                    <input type="text" name="ordinance_number" id="ordinance_number" wire:model='ordinance_number'
                        class="block w-full mt-1 rounded" required>
                </div>
                @if (!$isJOSelected)
                    <div class="col-span-6 sm:col-span-2">
                        <label for="sick_leave_points" class="block font-medium text-gray-700">Sick Leave Points</label>
                        <input type="number" step="0.01" name="sick_leave_points" id="sick_leave_points"
                            wire:model='sick_leave_points' class="block w-full mt-1 rounded" required>
                    </div>
                @endif


                <div class="col-span-6 sm:col-span-2">
                    <label for="first_name" class="block font-medium text-gray-700">First Name</label>
                    <input type="text" name="first_name" id="first_name" wire:model='first_name'
                        class="block w-full mt-1 rounded" required>
                </div>
                <div class="col-span-6 sm:col-span-2">
                    <label for="middle_name" class="block font-medium text-gray-700">Middle Name</label>
                    <input type="text" name="middle_name" id="middle_name" wire:model='middle_name'
                        class="block w-full mt-1 rounded" required>
                </div>
                <div class="col-span-6 sm:col-span-2">
                    <label for="last_name" class="block font-medium text-gray-700">Last Name</label>
                    <input type="text" name="last_name" id="last_name" wire:model='last_name'
                        class="block w-full mt-1 rounded" required>
                </div>

                <div class="col-span-6 sm:col-span-2">
                    <label for="category_id" class="block font-medium text-gray-700">Category</label>
                    <select name="category_id" id="category_id" wire:model.live='category_id'
                        class="block w-full mt-1 rounded form-select" required>
                        <option value="" selected>--Please select here--</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" wire:key='{{ $category->id }}'>
                                {{ $category->category_code }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-span-6 sm:col-span-2">
                    <label for="department_id" class="block font-medium text-gray-700">Departments</label>
                    <select name="department_id" id="department_id" wire:model='department_id'
                        class="block w-full mt-1 rounded form-select" required>
                        <option value="" selected>--Please select here--</option>
                        @foreach ($departments as $department)
                            <option value="{{ $department->id }}">{{ $department->dep_code }}</option>
                        @endforeach
                    </select>
                </div>
                @if ($category_id)
                    <input type="hidden" name="isJOSelected" id="isJOSelected" value="{{ $isJOSelected }}">
                    @if ($isJOSelected)
                        <div class="col-span-6 sm:col-span-2">
                            <label for="level_id" class="block font-medium text-gray-700">Level</label>
                            <select name="level_id" id="level_id" wire:model='level_id'
                                class="block w-full mt-1 rounded form-select" required>
                                <option value="" selected>--Please select here--</option>
                                @foreach ($levels as $level)
                                    <option value="{{ $level->id }}">{{ $level->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    @else
                        <div class="col-span-6 sm:col-span-2">
                            <label for="salary_grade_id" class="block font-medium text-gray-700">Salary Grade</label>
                            <select name="salary_grade_id" id="salary_grade_id" wire:model.live='salary_grade_id'
                                class="block w-full mt-1 rounded form-select" required>
                                <option value="" selected>--Please select here--</option>
                                @foreach ($salary_grades as $salary_grade)
                                    <option value="{{ $salary_grade->id }}" wire:key='{{ $salary_grade->id }}'>Salary
                                        Grade
                                        {{ $salary_grade->id }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-span-6 sm:col-span-2">
                            <label for="salary_grade_step" class="block font-medium text-gray-700">Salary
                                Grade Step</label>
                            <select name="salary_grade_step" id="salary_grade_step" wire:model='salary_grade_step'
                                class="block w-full mt-1 rounded form-select" required>
                                @if ($salary_grade_steps)
                                    <option value="" selected>--Please select here--</option>
                                    @foreach ($salary_grade_steps as $key => $salary_grade_step)
                                        <option value="{{ $salary_grade_step['step'] }}">
                                            {{ $salary_grade_step['step'] }}
                                        </option>
                                    @endforeach
                                @else
                                    <option value="" selected>--Please select salary grade first--</option>
                                @endif
                            </select>
                        </div>
                    @endif
                @endif


                <div class="col-span-6 sm:col-span-2">
                    <label for="designation_id" class="block font-medium text-gray-700">Designation</label>
                    <select name="designation_id" id="designation_id" wire:model='designation_id'
                        class="block w-full mt-1 rounded form-select" required>
                        <option value="" selected>--Please select here--</option>
                        @foreach ($designations as $designation)
                            <option value="{{ $designation->id }}">{{ $designation->designation_code }}
                            </option>
                        @endforeach
                    </select>
                </div>

            </div>
        </div>
        @if (!$isJOSelected)
            <div class="px-4 py-5 bg-white sm:p-6 shadow my-3">
                <h1 class="text-xl font-bold">Salary</h1>
                <hr class="mb-3">
                <div class="grid grid-cols-6 gap-6">
                    <div class="col-span-6 sm:col-span-2">
                        <label class="block font-medium text-gray-700">Allowance</label>
                        <div class="flex flex-col">
                            @if ($allowances)
                                @forelse ($allowances as $allowance)
                                    <div class="flex items-center mt-1" wire:key="{{ $allowance->id }}">
                                        <input type="checkbox" name="allowance_{{ $allowance->id }}"
                                            id="allowance_{{ $allowance->id }}"
                                            wire:model="selectedAllowanceIds.{{ $allowance->id }}"
                                            value="{{ $allowance->id }}" class="mr-2 form-checkbox">
                                        <label for="allowance_{{ $allowance->id }}"
                                            class="text-gray-900">{{ $allowance->allowance_code }}</label>
                                    </div>
                                @empty
                                    <span class="text-gray-600">The selected category doesnt have allowance.</span>
                                @endforelse
                            @else
                                <span class="text-gray-600">Select Category First</span>
                            @endif
                        </div>
                    </div>


                    <div class="col-span-6 sm:col-span-2">
                        <label class="block font-medium text-gray-700">Deductions</label>
                        <div class="flex flex-wrap">
                            <div class="w-full">
                                <h4 class="text-sm">Mandatory</h4>
                            </div>
                            @forelse ($mandatory_deductions as $mandatory_deduction)
                                <div class="w-1/2 px-2" wire:key="{{ $mandatory_deduction->id }}">
                                    <input type="checkbox" name="deductions[]"
                                        value="{{ $mandatory_deduction->id }}" class="mr-2 form-checkbox hidden"
                                        wire:model="selectedMandatoryDeductionIds.{{ $mandatory_deduction->id }}"
                                        checked>
                                    <input type="checkbox" id="deduction_{{ $mandatory_deduction->id }}"
                                        value="{{ $mandatory_deduction->id }}" class="mr-2 form-checkbox" checked
                                        disabled>
                                    <label for="deduction_{{ $mandatory_deduction->id }}"
                                        class="text-gray-900">{{ $mandatory_deduction->deduction_code }}</label>
                                </div>
                            @empty
                                <p>No deduction found.</p>
                            @endforelse
                        </div>

                        <div class="flex flex-wrap mt-4">
                            <div class="w-full">
                                <h4 class="text-sm">Non Mandatory </h4>
                            </div>
                            @forelse ($non_mandatory_deductions as $non_mandatory_deduction)
                                <div class="w-1/2 px-2" wire:key="{{ $non_mandatory_deduction->id }}">
                                    <input type="checkbox" name="deduction[]"
                                        id="deduction_{{ $non_mandatory_deduction->id }}"
                                        value="{{ $non_mandatory_deduction->id }}" class="mr-2 form-checkbox"
                                        wire:model="selectedNonMandatoryDeductionIds.{{ $non_mandatory_deduction->id }}">
                                    <label for="deduction_{{ $non_mandatory_deduction->id }}"
                                        class="text-gray-900">{{ $non_mandatory_deduction->deduction_code }}</label>
                                </div>
                            @empty
                                <p>No deduction found.</p>
                            @endforelse
                        </div>
                    </div>
                    <div class="col-span-6 sm:col-span-2">
                        <div class="col-span-6 sm:col-span-2">
                            <label for="loan_id" class="block font-medium text-gray-700">Loan </label>
                            <select name="loan_id" id="loan_id" wire:model.live='loan_id'
                                class="block w-full mt-1 rounded form-select">
                                <option value="" selected>--Please select here--</option>
                                @foreach ($loans as $loan)
                                    <option value="{{ $loan->id }}" wire:key='{{ $loan->id }}'>
                                        {{ $loan->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                @if ($selected_loans)
                    @foreach ($selected_loans as $selected_loan)
                        <div class="grid grid-cols-6 gap-6 mt-3" wire:key="{{ $selected_loan->id }}">

                            <div class="col-span-3 sm:col-span-2">
                                <input type="text" name="selected_loan_ids[]" value="{{ $selected_loan->id }}"
                                    hidden>
                                <div>
                                    <label for="amount"
                                        class="block font-medium text-gray-700">{{ $selected_loan->name }} </label>
                                    <div class="flex flex-col">
                                        <input type="number" name="amounts[]" id="amount" step="0.01"
                                            class="block w-full mt-1 rounded form-input"
                                            wire:model="arraySelectedLoans.{{ $selected_loan->id }}.amount">
                                        <span class="text-sm">Amount Per Deduction</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-span-3 sm:col-span-2">
                                <div>
                                    <label for="duration" class="block font-medium text-gray-700">
                                        Duration (Months)
                                    </label>
                                    <div class="flex">
                                        <input type="number" name="durations[]" id="duration" step="0.01"
                                            class="block w-full mt-1 rounded form-input"
                                            wire:model="arraySelectedLoans.{{ $selected_loan->id }}.duration">
                                    </div>
                                </div>
                            </div>
                            <div class="col-span-3 sm:col-span-2">
                                <h4 class="text-sm">Range </h4>
                                <div class="flex mt-1">
                                    <div class="flex flex-col space-y-2  w-1/2">
                                        <div class="w-1/2 px-2">
                                            <input type="checkbox" name="1-15_{{ $selected_loan->id }}" id="1-15_{{ $selected_loan->id }}" value="1-15"
                                                class="mr-2 form-checkbox"
                                                wire:model="arraySelectedLoans.{{ $selected_loan->id }}.range.1">
                                            <label for="1-15_{{ $selected_loan->id }}" class="text-gray-900">1-15</label>
                                        </div>
                                        <div class="w-1/2 px-2">
                                            <input type="checkbox" name="16-31_{{ $selected_loan->id }}" id="16-31_{{ $selected_loan->id }}" value="16-31"
                                                class="mr-2 form-checkbox"
                                                wire:model="arraySelectedLoans.{{ $selected_loan->id }}.range.2">
                                            <label for="16-31_{{ $selected_loan->id }}" class="text-gray-900">16-31</label>
                                        </div>
                                    </div>
                                    <div>
                                        <button type="button" wire:click='removeLoan({{ $selected_loan->id }})'
                                            class="bg-red-500 text-white font-bold py-2 px-4 rounded shadow hover:bg-red-700">
                                            X
                                        </button>

                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif


            </div>
        @endif

        <div class="px-4 py-3 text-right sm:px-6">
            <x-primary-button class="ml-3">
                {{ __('Create') }}
            </x-primary-button>
            <a href="{{ route('employees.index') }}"
                class="px-4 py-2 font-bold text-gray-500 rounded hover:text-gray-700">Back</a>
        </div>
    </div>
</form>
