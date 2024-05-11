<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Employee Information
            </h2>

    </x-slot>

    <div class="flex mx-auto mt-8 space-x-3 max-w-7xl">

        <div class="w-1/4 p-5 bg-white rounded-md shadow ">
            <div class="mb-3 border-b border-gray-100">
                <h1 class="text-2xl font-bold text-center">Actions</h1>
            </div>
            <div class="flex flex-col space-y-2">
                <a href="#"
                    class="text-blue-700 hover:text-white border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2 dark:border-blue-500 dark:text-blue-500 dark:hover:text-white dark:hover:bg-blue-500 dark:focus:ring-blue-800">
                    Edit
                </a>

                <form class="flex flex-col" action="{{ route('employees.destroy', $employee) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="text-red-700 hover:text-white border border-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2 dark:border-red-500 dark:text-red-500 dark:hover:text-white dark:hover:bg-red-600 dark:focus:ring-red-900">
                        Delete
                    </button>
                </form>
                <hr>
                {{-- <a href="{{ route('seminars.payslip', ['employee_id' => $employee->id]) }}"
                    class="inline-flex items-center px-4 py-2 font-bold text-gray-800 bg-gray-300 rounded hover:bg-gray-400">
                    <svg class="w-4 h-4 mr-2 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                        <path d="M13 8V2H7v6H2l8 8 8-8h-5zM0 18h20v2H0v-2z" />
                    </svg>
                    <span>Payslip (Seminars)</span>
                </a> --}}
                <a href="{{ route('employees.index') }}"
                    class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                    Back to Employee List
                </a>
            </div>
        </div>
        <div class="w-3/4 p-5 bg-white rounded-md shadow">
            <div class="mb-3 border-b border-gray-100">
                <h1 class="text-2xl font-bold">Personal Information</h1>
            </div>
            <div class="flex">
                <div class="mr-3">
                    <img src="{{ asset('storage/photos/' . $employee->employee_photo) }}" class="rounded"
                        style="height: 150px; width: 150px;">
                </div>
                <div>
                    <h3><strong>Employee No.: </strong>{{ $employee->employee_number }}</h3>
                    <h3><strong>Ordinance Item No.: </strong>{{ $employee->ordinance_number }}</h3>
                    <h3><strong>Name: </strong>{{ $employee->full_name }}</h3>

                    <h3><strong>Department: </strong>{{ $employee->data->department->dep_name }}</h3>
                    <h3><strong>Designation: </strong>{{ $employee->data->designation->designation_name }}</h3>
                    <h3><strong>Type of Employment: </strong>{{ $employee->data->category->category_name }}</h3>
                    @if ($employee->data->salary_grade_id != null)
                        <h3><strong>Salary Grade: </strong> Salary Grade {{ $employee->data->salary_grade_id }}</h3>
                        <h3><strong>Salary Grade Step: </strong> {{ $employee->data->salary_grade_step }} -
                            {{ number_format($employee->data->monthly_salary, 2) }}</h3>
                    @else
                        @if ($employee->data->category->category_code == 'COS')
                            <h3><strong>Monthly Salary: </strong>
                                {{ number_format($employee->data->monthly_salary, 2) }}</h3>
                        @else
                            <h3><strong>Level: </strong> {{ $employee->data->level->name }} -
                                {{ number_format($employee->data->monthly_salary * 15, 2) }}</h3>
                        @endif
                    @endif
                </div>
            </div>

            @if ($employee->data->category->category_code != 'JO')
                <h3><strong>Sick Leave Points: </strong>{{ number_format($employee->data->sick_leave_points, 2) }}</h3>
                <div class="my-3 border-b border-gray-100">
                    <h1 class="text-2xl font-bold">Deductions & Allowances</h1>
                </div>
                @if (count($employee->allowances) > 0)
                    <div class="w-2/4">
                        <h3><strong>Allowances</strong></h3>
                        @php
                            $total_allowances = $employee->computeAllowance();
                        @endphp
                        @forelse ($employee->allowances as $allowance)
                            <span>{{ $allowance->allowance->allowance_name }} -
                                {{ number_format($allowance->allowance->allowance_amount, 2) }}
                            </span>
                            <br>
                        @empty
                            <span class="text-center">No Allowance</span>
                        @endforelse
                        <br>
                        <span>Total Allowance: {{ number_format($total_allowances) }}</span>
                    </div>
                @endif
                @if (count($employee->deductions) > 0)
                    <div class="w-2/4">
                        <h3><strong>Deductions</strong></h3>
                        @php
                            $total_deductions = $employee->computeDeduction();
                        @endphp
                        @forelse ($employee->deductions as $deduction)
                            <span>{{ $deduction->deduction->deduction_name }} -
                                {{ $deduction->deduction->deduction_amount_type == 'percentage' ? percentage($deduction->deduction->deduction_amount) : number_format($deduction->deduction->deduction_amount, 2) }}</span>
                            <br>
                        @empty
                            <span class="text-center">No Deductions</span>
                        @endforelse
                        @if ($employee->data->holding_tax)
                            @php
                                $total_deductions = $total_deductions + $employee->data->holding_tax;
                            @endphp
                            <span>With Holding Tax -
                                {{ number_format($employee->data->holding_tax) }}</span>
                        @endif
                        <br>
                        <span>Total: {{ number_format($total_deductions) }}</span>
                    </div>
                @endif
            @endif

            <div class="my-3 border-b border-gray-100">
                <h1 class="text-2xl font-bold">Other Information</h1>
            </div>
            <h2><strong>Loan - (amount of total Loan)</strong></h2> <br>
            <h3 style="margin-left: 4rem"><strong>(paid amount)</strong> ---------- (date mm/dd/yyyy)</h3>
            <h3 style="margin-left: 4rem"><strong>(paid amount)</strong> ---------- (date mm/dd/yyyy)</h3>
            <h3 style="margin-left: 4rem"><strong>(paid amount)</strong> ---------- (date mm/dd/yyyy)</h3>
            <h3 style="margin-left: 4rem"><strong>2,500.00</strong> ---------- 01/15/2024</h3> <br>
            <h3><strong>Balance:</strong></h3>
        </div>


    </div>
</x-app-layout>
