<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            Payroll for {{ $payroll['department'] }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="flex items-center justify-between space-x-2 mb-3 mx-5">
            <div class="relative ">

            </div>
            <div class="relative ">
                <a href="{{ route('payrolls.index') }}"
                    class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    Back to Payroll
                </a>

            </div>

        </div>
        <div class="mx-auto bg-white max-w-9xl sm:px-6 lg:p-8">
            <table class="min-w-full border data-table">
                <thead>
                    <tr>
                        <th class="px-4 py-2 text-left border-b">#</th>
                        <th class="px-4 py-2 text-left border-b">Employee ID</th>
                        <th class="px-4 py-2 text-left border-b">Name</th>
                        <th class="px-4 py-2 text-left border-b">Monthly Salary</th>
                        <th class="px-4 py-2 text-left border-b">Total Salary</th>
                        <th class="px-4 py-2 text-left border-b">Allowance</th>
                        <th class="px-4 py-2 text-left border-b">Total Allowance</th>
                        <th class="px-4 py-2 text-left border-b">Deduction</th>
                        <th class="px-4 py-2 text-left border-b">Total Deduction</th>
                        <th class="px-12 py-2 text-left border-b">Net Pay</th>
                        <th class="px-12 py-2 text-left border-b">DTR</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $totalNetPay = 0; // Variable to store the total net pay

                    @endphp
                    @foreach ($employees as $employee)
                        @php
                            $totalSalary = 0; // Variable to store the total salary
                            $dates = explode('-', $payroll['date_from_to']);
                            $from = $dates[0];
                            $to = $dates[1];
                            $totalSalary = $employee->getTotalSalaryBy($payroll['month'], $payroll['year'], $from, $to); // Get the total salary of the employee
                            $netPay = ($totalSalary + $employee->computeAllowance()) - $employee->computeDeduction();
                            $netPay = $netPay < 0 ? 0 : $netPay;
                            $totalNetPay += $netPay; // Accumulate the net pay value

                        @endphp
                        <tr>
                            <td class=" p-3">{{ $loop->iteration }}</td>
                            <td class=" p-3">{{ $employee->employee_number }}</td>
                            <td class=" p-3">{{ $employee->full_name }}</td>

                            <td class=" p-3 ">{{  number_format($employee->salaryGradeStep->amount, 2) }}</td>
                            <td class=" p-3 ">{{ number_format($totalSalary, 2) }}</td>
                            <td class=" p-3 border-b">
                                <div class="flex flex-col">
                                    @foreach ($employee->allowances as $allowance)
                                        <span>{{ $allowance->allowance->allowance_code }} -
                                            {{ $allowance->allowance->allowance_amount }}</span>
                                    @endforeach
                                </div>
                            </td>
                            <td class=" p-3 ">{{ number_format($employee->computeAllowance(), 2) }}</td>
                            <td class=" p-3 border-b">
                                <div class="flex flex-col">
                                    @foreach ($employee->deductions as $deduction)
                                        <span>{{ $deduction->deduction->deduction_code }} -
                                            {{ $deduction->deduction->deduction_amount }}</span>
                                    @endforeach
                                </div>

                            </td>
                            <td class=" p-3 ">{{ number_format($employee->computeDeduction(), 2) }}
                            </td>
                            <td class=" p-3 ">{{ number_format($netPay, 2) }}</td>
                            <td class="px-4 py-2 text-center border-b">
                                @php
                                    $encoded = urlencode(json_encode($payroll));

                                @endphp
                                <a href="{{ route('payrolls.dtr', ['id' => $employee->id, 'payroll' => $encoded]) }}"
                                    class="text-green-500 hover:text-green-700">View</a>
                            </td>
                        </tr>
                    @endforeach

                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="11" class="px-4 py-2 font-bold text-end border-t-4 border-black border-double">
                            Total Net Pay: {{ number_format($totalNetPay, 2) }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</x-app-layout>

<x-app-layout>
    <x-slot name="header">
        <h1 class="text-xl font-semibold leading-tight text-gray-800">
            Payroll List
        </h1>
    </x-slot>

    <div class="p-5 mx-auto mt-8 bg-white rounded-md shadow max-w-7xl">

        <div class="flex items-center justify-between mb-3">
            <div>

            </div>
            <div class="flex items-center space-x-2">
                <div class="relative">
                    {{-- reset button --}}
                    <a href="{{ route('payrolls.index') }}"
                    class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    Back to Payroll
                </a>

                </div>
            </div>
        </div>
        <table class="min-w-full border data-table">
            <thead>
                <tr>
                    <th class="px-4 py-2 text-left border-b">Employee ID</th>
                    <th class="px-4 py-2 text-left border-b">Name</th>
                    <th class="px-4 py-2 text-left border-b">Monthly Salary</th>
                    <th class="px-4 py-2 text-left border-b">Total Salary</th>
                    <th class="px-4 py-2 text-left border-b">Allowance</th>
                    <th class="px-4 py-2 text-left border-b">Total Allowance</th>
                    <th class="px-4 py-2 text-left border-b">Deduction</th>
                    <th class="px-4 py-2 text-left border-b">Total Deduction</th>
                    <th class="px-12 py-2 text-left border-b">Net Pay</th>
                    <th class="px-12 py-2 text-left border-b">DTR</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $totalNetPay = 0; // Variable to store the total net pay

                @endphp
                @foreach ($employees as $employee)
                    @php
                        $totalSalary = 0; // Variable to store the total salary
                        $dates = explode('-', $payroll['date_from_to']);
                        $from = $dates[0];
                        $to = $dates[1];
                        $totalSalary = $employee->getTotalSalaryBy($payroll['month'], $payroll['year'], $from, $to); // Get the total salary of the employee
                        $netPay = ($totalSalary + $employee->computeAllowance()) - $employee->computeDeduction();
                        $netPay = $netPay < 0 ? 0 : $netPay;
                        $totalNetPay += $netPay; // Accumulate the net pay value

                    @endphp
                    <tr>
                        <td class=" p-3">{{ $employee->employee_number }}</td>
                        <td class=" p-3">{{ $employee->full_name }}</td>

                        <td class=" p-3 ">{{  number_format($employee->data->salary_grade_step_amount, 2) }}</td>
                        <td class=" p-3 ">{{ number_format($totalSalary, 2) }}</td>
                        <td class=" p-3 border-b">
                            <div class="flex flex-col">
                                @foreach ($employee->allowances as $allowance)
                                    <span>{{ $allowance->allowance->allowance_code }} -
                                        {{ $allowance->allowance->allowance_amount }}</span>
                                @endforeach
                            </div>
                        </td>
                        <td class=" p-3 ">{{ number_format($employee->computeAllowance(), 2) }}</td>
                        <td class=" p-3 border-b">
                            <div class="flex flex-col">
                                @foreach ($employee->deductions as $deduction)
                                    <span>{{ $deduction->deduction->deduction_code }} -
                                        {{ $deduction->deduction->deduction_amount }}</span>
                                @endforeach
                            </div>

                        </td>
                        <td class=" p-3 ">{{ number_format($employee->computeDeduction(), 2) }}
                        </td>
                        <td class=" p-3 ">{{ number_format($netPay, 2) }}</td>
                        <td class="px-4 py-2 text-center border-b">
                            @php
                                $encoded = urlencode(json_encode($payroll));
                            @endphp
                            <a href="{{ route('payrolls.dtr', ['id' => $employee->id, 'payroll' => $encoded]) }}"
                                class="text-green-500 hover:text-green-700">View DTR</a>
                        </td>
                    </tr>
                @endforeach

            </tbody>
            <tfoot>
                <tr>
                    <td colspan="11" class="px-4 py-2 font-bold text-end border-t-4 border-black border-double">
                        Total Net Pay: {{ number_format($totalNetPay, 2) }}</td>
                </tr>
            </tfoot>
        </table>
    </div>
</x-app-layout>
