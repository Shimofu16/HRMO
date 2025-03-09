<div class="overflow-hidden  sm:rounded-md">
    <form wire:submit.prevent="save" enctype="multipart/form-data">
        {{-- <form action="{{ route('employees.store') }}" method="POST" enctype="multipart/form-data"> --}}
        @csrf
        <div class="px-4 py-5 bg-white sm:p-6 shadow">
            <h1 class="text-xl font-bold">Employee Information</h1>
            <hr class="mb-3">
            <div class="grid grid-cols-6 gap-6">
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
                    <label for="category_id" class="block font-medium text-gray-700">Type of Employment</label>
                    <select name="category_id" id="category_id" wire:model.live='category_id'
                        class="block w-full mt-1 rounded form-select" required>
                        <option value="" selected>--Please select here--</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}"
                                {{ $category->id == $employee->data->category_id ? 'selected' : '' }}
                                wire:key='{{ $category->id }}'>
                                {{ $category->category_code }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-span-6 sm:col-span-2">
                    <label for="department_id" class="block font-medium text-gray-700">Department</label>
                    <select name="department_id" id="department_id" wire:model.live='department_id'
                        class="block w-full mt-1 rounded form-select" required>
                        <option value="" selected>--Please select here--</option>
                        @foreach ($departments as $department)
                            <option value="{{ $department->id }}"
                                {{ $department->id == $employee->data->department_id ? 'selected' : '' }}>
                                {{ $department->dep_code }}</option>
                        @endforeach
                    </select>
                </div>
                @if ($category_id)
                    @if ($isJOSelected)
                        <div class="col-span-6 sm:col-span-2">
                            <label for="level_id" class="block font-medium text-gray-700">Classification</label>
                            <select name="level_id" id="level_id" wire:model='level_id'
                                class="block w-full mt-1 rounded form-select" required>
                                <option value="" selected>--Please select here--</option>
                                @foreach ($levels as $level)
                                    <option value="{{ $level->id }}"
                                        {{ $level->id == $employee->data->level_id ? 'selected' : '' }}>
                                        {{ $level->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    @elseif ($isCOSSelected)
                        <div class="col-span-6 sm:col-span-2">
                            <label for="cos_monthly_salary" class="block font-medium text-gray-700">Monthly
                                Salary</label>
                            <input type="text" name="cos_monthly_salary" id="cos_monthly_salary"
                                wire:model.live='cos_monthly_salary' class="block w-full mt-1 rounded" required>
                        </div>
                    @else
                        <div class="col-span-6 sm:col-span-2">
                            <label for="salary_grade_id" class="block font-medium text-gray-700">Salary
                                Grade</label>
                            <select name="salary_grade_id" id="salary_grade_id" wire:model.live='salary_grade_id'
                                class="block w-full mt-1 rounded form-select" required>
                                <option value="" selected>--Please select here--</option>
                                @foreach ($salary_grades as $salary_grade)
                                    <option value="{{ $salary_grade->id }}"
                                        {{ $salary_grade->id == $employee->data->salary_grade_id ? 'selected' : '' }}
                                        wire:key='{{ $salary_grade->id }}'>
                                        Salary
                                        Grade
                                        {{ $salary_grade->id }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-span-6 sm:col-span-2">
                            <label for="salary_grade_step" class="block font-medium text-gray-700">Salary
                                Grade Step</label>
                            <select name="salary_grade_step" id="salary_grade_step"
                                wire:model.live='salary_grade_step' class="block w-full mt-1 rounded form-select"
                                required>
                                @if ($salary_grade_steps)
                                    <option value="" selected>--Please select here--</option>
                                    @foreach ($salary_grade_steps as $key => $salary_grade_step)
                                        <option value="{{ $salary_grade_step['step'] }}"
                                            {{ $salary_grade_step['step'] == $employee->data->salary_grade_step ? 'selected' : '' }}>
                                            {{ $salary_grade_step['step'] }} -
                                            {{ number_format($salary_grade_step['amount']) }}
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
                    <label for="designation_id" class="block font-medium text-gray-700">Position Title</label>
                    <select name="designation_id" id="designation_id" wire:model='designation_id'
                        class="block w-full mt-1 rounded form-select" required>
                        <option value="" selected>--Please select here--</option>
                        @foreach ($designations as $designation)
                            <option value="{{ $designation->id }}"
                                {{ $designation->id == $employee->data->designation_id ? 'selected' : '' }}>
                                {{ $designation->designation_code }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-span-6 sm:col-span-2">
                    <label for="payroll_type" class="block font-medium text-gray-700">Payroll Type</label>
                    <select name="payroll_type" id="payroll_type" wire:model='payroll_type'
                        class="block w-full mt-1 rounded form-select" required>
                        <option value="" selected>--Please select here--</option>

                        <option value="ATM" {{ $employee->data->payroll_type == 'ATM' ? 'selected' : ''}}>ATM</option>
                        <option value="Cash" {{ $employee->data->payroll_type == 'Cash' ? 'selected' : '' }}>Cash</option>

                    </select>
                </div>
                <div class="col-span-6 sm:col-span-2">
                    <label for="employee_photo"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Picture</label>
                    <input type="file" name="employee_photo" id="employee_photo" wire:model='employee_photo'
                        class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"
                        >
                </div>
            </div>
        </div>
        @if (!$isJOSelected || $isCOSSelected)
            <div class="px-4 py-5 bg-white sm:p-6 shadow my-3">
                <h1 class="text-xl font-bold">Salary</h1>
                <hr class="mb-3">
                <div class="grid grid-cols-6 gap-6">
                    <div class="col-span-6 sm:col-span-2">
                        <label class="block font-medium text-gray-700">Allowance</label>
                        <div class="flex flex-col">
                            @if ($allowances)
                                @forelse ($allowances as $key => $allowance)
                                    <div class="flex items-center mt-1" wire:key="{{ $allowance->id }}">
                                        <input type="checkbox" name="allowance_{{ $allowance->id }}"
                                            id="allowance_{{ $allowance->id }}"  class="mr-2 form-checkbox" checked disabled>
                                        <label for="allowance_{{ $allowance->id }}"
                                            class="text-gray-900">{{ $allowance->allowance_code }}</label>
                                    </div>
                                @empty
                                    <span class="text-gray-600">The selected category doesn't have
                                        allowances.</span>
                                @endforelse
                            @else
                                <span class="text-gray-600">Select Category First</span>
                            @endif
                        </div>
                    </div>


                    <div class="col-span-6 sm:col-span-2">
                        <label class="block font-medium text-gray-700">Contribution</label>
                        <div class="flex flex-wrap">
                            <div class="w-full">
                                <h4 class="text-sm">Mandatory</h4>
                            </div>
                            @forelse ($mandatory_deductions as $key => $mandatory_deduction)
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
                            @forelse ($non_mandatory_deductions as $key => $non_mandatory_deduction)
                                <div class="w-1/2 px-2" wire:key="{{ $non_mandatory_deduction->id }}">
                                    <input type="checkbox" name="deduction[]"
                                        id="deduction_{{ $non_mandatory_deduction->id }}"
                                        value="{{ $non_mandatory_deduction->id }}" class="mr-2 form-checkbox"
                                        wire:model="selectedNonMandatoryDeductionIds.{{ $non_mandatory_deduction->id }}"
                                        {{ isset($selectedNonMandatoryDeductionIds[$non_mandatory_deduction->id]) ? 'checked' : '' }}>
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
                    <label for="amount" class="block font-medium text-gray-700">{{ $selected_loan->name }}</label>
                        <div class="grid grid-cols-9 gap-6 mt-3 items-center" wire:key="{{ $selected_loan->id }}">
                            <div class="col-span-3">
                                <div>

                                    <div class="flex flex-col">
                                        <label for="amount_1_15" class="block font-medium text-gray-700">Amount (1-15)</label>
                                        <input type="number" name="amounts_1_15[]" id="amount_1_15" step="0.01"
                                            class="block w-full mt-1 rounded form-input"
                                            wire:model="arraySelectedLoans.{{ $selected_loan->id }}.amount_1_15">
                                        <label for="amount_16_31" class="block font-medium text-gray-700 mt-2">Amount (16-31)</label>
                                        <input type="number" name="amounts_16_31[]" id="amount_16_31" step="0.01"
                                            class="block w-full mt-1 rounded form-input"
                                            wire:model="arraySelectedLoans.{{ $selected_loan->id }}.amount_16_31">
                                    </div>
                                </div>
                            </div>
                            <div class="col-span-3">
                                <div class="flex space-x-3">
                                    <div>
                                        <label for="start_date" class="block font-medium text-gray-700">Start Date</label>
                                        <div class="flex">
                                            <input type="date" name="start_dates[]" id="start_date"
                                                class="block w-full mt-1 rounded form-input"
                                                wire:model="arraySelectedLoans.{{ $selected_loan->id }}.start_date">
                                        </div>
                                    </div>
                                    <div>
                                        <label for="end_date" class="block font-medium text-gray-700">End Date</label>
                                        <div class="flex">
                                            <input type="date" name="end_dates[]" id="end_date"
                                                class="block w-full mt-1 rounded form-input"
                                                wire:model="arraySelectedLoans.{{ $selected_loan->id }}.end_date">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-5">
                                <button type="button" wire:click='removeLoan({{ $selected_loan->id }})'
                                    class="px-4 py-2 font-bold text-white bg-red-500 rounded shadow hover:bg-red-700">
                                    X
                                </button>

                            </div>
                        </div>
                @endforeach
            @endif
            </div>
        @endif

        <div class="px-4 py-3 text-right sm:px-6">
            <x-primary-button class="ml-3">
                {{ __('Save Changes') }}
            </x-primary-button>
            <a href="{{ route('employees.index') }}"
                class="inline-flex items-center px-4 py-2 text-xs font-semibold tracking-widest text-white uppercase transition duration-150 ease-in-out bg-gray-800 border border-transparent rounded-md hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">Back</a>
        </div>
    </form>
    {{-- @if ($isAlreadyLogIn)
    @else
        <form wire:submit.prevent="login">
            <div class="px-4 py-5 bg-white sm:p-6 shadow my-3 flex items-center justify-center flex-col">
                @if (session()->has('error'))
                    <div class="px-3 mb-3">
                        <div class="text-white bg-red-600 px-3 py-2 rounded">
                            Error : {{ session('error') }}
                        </div>
                    </div>
                @endif
                <div class="flex flex-col w-1/2">
                    <label for="password" class="block font-medium text-gray-700">Password</label>
                    <input type="password" name="password" id="password" wire:model='password'
                        class="block w-full mt-1 rounded" required>
                </div>
                <div class="mt-3 text-right sm:px-6 w-1/2">
                    <x-primary-button class="ml-3">
                        {{ __('Login') }}
                    </x-primary-button>
                    <a href="{{ route('employees.index') }}"
                        class="inline-flex items-center px-4 py-2 text-xs font-semibold tracking-widest text-white uppercase transition duration-150 ease-in-out bg-gray-800 border border-transparent rounded-md hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">Back</a>
                </div>
            </div>
        </form>
    @endif --}}

</div>
