<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            Payroll for {{ $payroll->pr_department }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto max-w-9xl sm:px-6 lg:px-8">
            <table class="min-w-full bg-white border">
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
                    </tr>
                </thead>
                <tbody>
                    @php
                        $totalNetPay = 0; // Variable to store the total net pay
                        $totalSalary = 0; // Variable to store the total salary
                    @endphp
                    @foreach ($employees as $employee)
                        @if ($employee->department->dep_name == $payroll->pr_department)
                            @php
                               $dates = explode(' - ', $payroll->date_from_to);
                                $from = $dates[0];
                                $to = $dates[1];
                                $totalSalary = $employee->getTotalSalaryBy($payroll->month,$payroll->year,$from,$to); // Get the total salary of the employee
                                $netPay = $totalSalary + $employee->computeAllowance() - $employee->computeDeduction();
                                $totalNetPay += $netPay; // Accumulate the net pay value

                            @endphp
                            <tr>
                                <td class=" p-3">{{ $loop->iteration }}</td>
                                <td class=" p-3">{{ $employee->emp_no }}</td>
                                <td class=" p-3">{{ $employee->name }}</td>

                                <td class=" p-3 text-right">{{ $employee->sgrade->sg_amount }}</td>
                                <td class=" p-3 text-right">{{ number_format($totalSalary, 2);  }}</td>
                                <td class=" p-3 border-b">
                                    <div class="flex flex-col">
                                        @foreach ($employee->allowances as $allowance)
                                            <span>{{ $allowance->allowance->allowance_code }} - {{ $allowance->allowance->allowance_amount }}</span>
                                        @endforeach
                                    </div>
                                </td>
                                <td class=" p-3 text-right">{{ number_format($employee->computeAllowance(), 2, '.', ',') }}
                                </td>
                                <td class=" p-3 border-b">
                                    <div class="flex flex-col">
                                        @foreach ($employee->deductions as $deduction)
                                            <span>{{ $deduction->deduction->deduction_code }} - {{ $deduction->deduction->deduction_amount }}</span>
                                        @endforeach
                                    </div>

                                </td>
                                <td class=" p-3 text-right">{{ number_format($employee->computeDeduction(), 2, '.', ',') }}
                                </td>
                                <td class=" p-3 text-right">{{ number_format($netPay, 2, '.', ',') }}</td>

                            </tr>
                        @endif
                    @endforeach
                    <tr>
                        <td colspan="10" class="px-4 py-2 font-bold text-right border-t-4 border-black border-double">
                            Total Net Pay: {{ number_format($totalNetPay, 2, '.', ',') }}</td>
                    </tr>
                </tbody>
            </table>
            <div class="px-4 py-3 text-right bg-gray-50 sm:px-6">
                <a href="{{ route('payrolls.index') }}"
                    class="px-4 py-2 font-bold text-gray-500 rounded hover:text-gray-700">Back</a>
            </div>
        </div>
    </div>
</x-app-layout>
