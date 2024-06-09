{{-- <x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            Payroll for {{ $payroll['department'] }}
        </h2>
    </x-slot>

    <div class="p-5 mx-auto mt-8 bg-white rounded-md shadow max-w-7xl">

        <div class="flex items-center justify-between mb-3">
            <div>

            </div>
            <div class="flex items-center space-x-2">
                <div class="relative">

                    <a href="{{ route('payrolls.index') }}"
                        class="inline-flex items-center px-4 py-2 text-xs font-semibold tracking-widest text-white uppercase transition duration-150 ease-in-out bg-gray-800 border border-transparent rounded-md hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                        Back to Payroll
                    </a>

                </div>
            </div>
        </div>
        <table class="min-w-full border data-table">
            <thead>
                <tr>
                    <th class="px-4 py-2 text-left border-b">Name</th>
                    <th class="px-4 py-2 text-left border-b">Monthly Salary</th>
                    <th class="px-4 py-2 text-left border-b">Total Salary</th>
                    <th class="px-4 py-2 text-left border-b">Total Allowance</th>
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
                        $totalSalary = attendanceCount($employee, $payroll, $from,  $to)['total_salary']; // Get the total salary of the employee
                        $netPay =
                            $employee->computeAllowance($payroll['date_from_to']) +
                            $totalSalary -
                            $employee->computeDeduction($payroll['date_from_to']);
                        $netPay = $netPay < 0 ? 0 : $netPay;
                        $totalNetPay += $netPay; // Accumulate the net pay value

                    @endphp
                    <tr>
                        <td class="p-3 ">{{ $employee->full_name }}</td>

                        <td class="p-3 ">
                            {{ number_format($employee->data->monthly_salary, 2) }}
                        </td>
                        <td class="p-3 ">{{ number_format($totalSalary, 2) }}</td>
                        <td class="p-3 ">{{ number_format($employee->computeAllowance($payroll['date_from_to']), 2) }}
                        </td>
                        <td class="p-3 ">{{ number_format($employee->computeDeduction($payroll['date_from_to']), 2) }}
                        </td>
                        <td class="p-3 ">{{ number_format($netPay, 2) }}</td>
                        <td class="px-4 py-2 text-center border-b">
                            <a href="{{ route('employees.show', $employee) }}"
                                class="mr-1 text-blue-500 hover:text-blue-700">
                                View Info.
                            </a>
                            @php
                                $encoded = urlencode(json_encode($payroll));
                            @endphp
                            <a href="{{ route('payrolls.dtr', ['id' => $employee->id, 'payroll' => $encoded]) }}"
                                class="text-green-500 hover:text-green-700">
                                View DTR
                            </a>
                        </td>
                    </tr>
                @endforeach

            </tbody>
            <tfoot>
                <tr>
                    <td colspan="7" class="px-4 py-2 font-bold border-t-4 border-black border-double text-end">
                        Total Net Pay: {{ number_format($totalNetPay, 2) }}</td>
                </tr>
            </tfoot>
        </table>
    </div>
</x-app-layout> --}}

<x-app-layout>
    <x-slot name="header">
        <h1 class="text-xl font-semibold leading-tight text-gray-800">
            Payroll List - {{ $department->dep_name }}
        </h1>
    </x-slot>

    <div class="p-5 mx-auto mt-8 bg-white rounded-md shadow max-w-7xl">

        <div class="flex items-center justify-between mb-3">
            <div>

            </div>
            <div class="flex items-center space-x-2">
            </div>
        </div>
        <table class="min-w-full border data-table">
            <thead>
                <tr>
                    <th class="px-4 py-2 text-left border-b">#</th>
                    <th class="px-4 py-2 text-left border-b">Month</th>
                    <th class="px-4 py-2 text-left border-b">Year</th>
                    <th class="px-4 py-2 text-left border-b">Date From To</th>
                    <th class="px-4 py-2 text-center border-b">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($payrolls as $payroll)
                    <tr>
                        <td class="px-4 py-2 border-b">{{ $loop->iteration }}</td>
                        <td class="px-4 py-2 border-b">{{ $payroll['month'] }}</td>
                        <td class="px-4 py-2 border-b">{{ $payroll['year'] }}</td>
                        <td class="px-4 py-2 border-b">{{ $payroll['date_from_to'] }}</td>
                        <td class="px-4 py-2 border-b">
                            @php
                                $encoded = urlencode(json_encode($payroll));

                            @endphp
                            <a href="{{ route('payrolls.general-payslip', $encoded) }}"
                                class="mr-3 text-green-500 hover:text-green-700">General Payroll</a>
                                <a href="{{ route('payrolls.payslip', [
                                    'department' => $department,
                                    'payroll' => $encoded,
                                ]) }}"
                                    class="text-blue-500 hover:text-blue-700 ">Generate Payslip</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout>
