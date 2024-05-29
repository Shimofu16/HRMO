<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Employee Information
            </h2>

    </x-slot>
    <style>
          .page-break {
            page-break-before: always;
        }
    </style>
    <div class="flex mx-auto mt-8 space-x-3 max-w-7xl">

        <div class="w-1/4 p-5 bg-white rounded-md shadow ">
            <div class="mb-3 border-b border-gray-100">
                <h1 class="text-2xl font-bold text-center">Actions</h1>
            </div>
            <div class="flex flex-col space-y-2">
                <button type="button"
                    class="text-blue-700 hover:text-white border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2 dark:border-blue-500 dark:text-blue-500 dark:hover:text-white dark:hover:bg-blue-500 dark:focus:ring-blue-800"
                    onclick="generatePDF('{{ $employee->full_name }} - Information')">
                    Download to PDF
                </button>
                <a href="{{ route('employees.edit', $employee) }}"
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
                    class="inline-flex items-center px-4 py-2 text-xs font-semibold tracking-widest text-gray-700 uppercase transition duration-150 ease-in-out bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25">
                    Back to Employee List
                </a>
            </div>
        </div>
        <div class="w-3/4 p-5 bg-white rounded-md shadow" id="element-to-print">
            <div class="mb-3 border-b border-gray-100">
                <h1 class="text-2xl font-bold">Personal Information</h1>
            </div>
            <div class="flex justify-between">

                <div>
                    <h3><strong>Employee No.: </strong>{{ $employee->employee_number }}</h3>
                    <h3><strong>Ordinance Item No.: </strong>{{ $employee->ordinance_number }}</h3>
                    <h3><strong>Name: </strong>{{ $employee->full_name }}</h3>

                    <h3><strong>Department: </strong>{{ $employee->data->department->dep_name }}</h3>
                    <h3><strong>Designation: </strong>{{ $employee->data->designation->designation_name }}</h3>
                    <h3><strong>Type of Employment: </strong>{{ $employee->data->category->category_name }}</h3>
                    @if ($employee->data->category->category_code == 'JO')
                        <h3><strong>Level: </strong> {{ $employee->data->level->name }}</h3>
                    @elseif ($employee->data->category->category_code != 'COS' && $employee->data->category->category_code != 'JO')
                        <h3><strong>Salary Grade: </strong> Salary Grade {{ $employee->data->salary_grade_id }}</h3>
                        <h3><strong>Salary Grade Step: </strong> {{ $employee->data->salary_grade_step }} </h3>
                    @endif
                    <h3><strong>Monthly Salary: </strong>
                        {{ number_format($employee->data->monthly_salary, 2) }}</h3>
                    @if ($employee->data->category->category_code != 'JO')
                        <h3><strong>Sick Leave Points:
                            </strong>{{ number_format($employee->data->sick_leave_points, 2) }}</h3>
                    @endif
                </div>
                <div class="mr-3">
                    <img src="{{ asset('storage/photos/' . $employee->employee_photo) }}" class="rounded"
                        style="height: 170px; width: 170px;">
                </div>
            </div>

            @if ($employee->data->category->category_code != 'JO')
                <div class="my-3 border-b border-gray-100">
                    <h1 class="text-2xl font-bold">Deductions & Allowances</h1>
                </div>
                @if (count($employee->deductions) > 0)
                    <h3><strong>Deductions</strong></h3>
                    @php
                        $total_deductions = $employee->computeDeduction();
                    @endphp
                    <table class="min-w-full border">
                        <thead>
                            <tr>
                                <th class="px-4 py-4 text-left border-b">#</th>
                                <th class="px-4 py-4 text-left border-b">Deduction</th>
                                <th class="px-4 py-4 text-left border-b">Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($employee->deductions as $deduction)
                                <tr>
                                    <td class="px-4 py-3 border-b">
                                        {{ $loop->iteration }}
                                    </td>
                                    <td class="px-4 py-3 border-b">{{ $deduction->deduction->deduction_name }}</td>
                                    <td class="px-4 py-3 border-b">
                                        {{ number_format($employee->getDeduction($deduction->deduction_id, null), 2) }}
                                    </td>
                                </tr>
                            @endforeach
                            @if ($employee->data->has_holding_tax)
                                @php
                                    $total_deductions =
                                        $total_deductions +
                                        computeHoldingTax(
                                            $employee->data->monthly_salary,
                                            $employee->computeDeduction(),
                                        );
                                @endphp
                                <tr>
                                    <td class="px-4 py-3 border-b">
                                        {{ count($employee->deductions) + 1 }}
                                    </td>
                                    <td class="px-4 py-3 border-b">With Holding Tax</td>
                                    <td class="px-4 py-3 border-b">
                                        {{ number_format(computeHoldingTax($employee->data->monthly_salary, $employee->computeDeduction()), 2) }}
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                        <tfoot>
                            <tr>
                                <td class="px-4 py-3 border-b"></td>
                                <td class="px-4 py-3 border-b"></td>
                                <td class="px-4 py-3 border-b">Total: {{ number_format($total_deductions, 2) }}</td>
                            </tr>
                        </tfoot>
                    </table>
                @endif
                @if (count($employee->allowances) > 0)
                    <h3 class="mt-3"><strong>Allowances</strong></h3>
                    @php
                        $total_allowances = 0;
                    @endphp
                    <table class="min-w-full border mb-3">
                        <thead>
                            <tr>
                                <th class="px-4 py-4 text-left border-b">#</th>
                                <th class="px-4 py-4 text-left border-b">Allowance</th>
                                <th class="px-4 py-4 text-left border-b">Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($employee->allowances as $allowance)
                                @if ($employee->getAllowance($allowance->id) != 0)
                                    @php
                                        $total_allowances = $total_allowances + $employee->getAllowance($allowance->id);
                                    @endphp
                                    <tr>
                                        <td class="px-4 py-3 border-b">
                                            {{ $loop->iteration }}
                                        </td>
                                        <td class="px-4 py-3 border-b">{{ $allowance->allowance->allowance_code }}</td>
                                        <td class="px-4 py-3 border-b">
                                            {{ number_format($employee->getAllowance($allowance->id), 2) }}
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td class="px-4 py-3 border-b"></td>
                                <td class="px-4 py-3 border-b"></td>
                                <td class="px-4 py-3 border-b">Total: {{ number_format($total_allowances, 2) }}</td>
                            </tr>
                        </tfoot>
                    </table>
                @endif

            @endif
            <div class="page-break"></div> <!-- Page break for printing -->
            @if (count($employee->loans) > 0)
            <h3><strong>Loans</strong></h3>
                @foreach ($employee->loans as $loan)
                    @php
                        $balnce = 0;
                        $total_loan = 0;
                        $total_amount_paid = 0;
                        $loan_balance = 0;
                        $ranges = count($loan->ranges);
                        $duration = $total_loan = $loan->amount * $loan->duration;
                    @endphp
                    <table class="min-w-full border mb-3">
                        <thead>
                            <tr>
                                <th class="px-4 py-4 text-left border-b">
                                    <strong>{{ $loan->loan->name }} - {{ number_format($total_loan, 2) }}</strong>
                                </th>
                                <th class="px-4 py-4 text-left border-b"></th>
                            </tr>
                            <tr>
                                <th class="px-4 py-4 text-left border-b">Amount</th>
                                <th class="px-4 py-4 text-left border-b">Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach (getMonthsFromAttendance($employee) as $month)
                                @if (isBetweenDatesOfLoan($loan, $month->earliest_time_in))
                                    @if ($total_amount_paid <= $total_loan)
                                        @php
                                            $total_amount_paid = $total_amount_paid + $loan->amount * $ranges;
                                        @endphp
                                        <tr>
                                            <td class="px-4 py-3 border-b">
                                                {{ number_format($loan->amount * $ranges, 2) }}
                                            </td>
                                            <td class="px-4 py-3 border-b">
                                                {{ date('m', strtotime($month->earliest_time_in)) }}/{{ $ranges > 1 ? 30 : 15 }}/{{ date('Y', strtotime($month->earliest_time_in)) }}
                                            </td>
                                        </tr>
                                    @endif
                                @endif
                            @endforeach

                        </tbody>
                        <tfoot>
                            @php
                                $balance = $total_loan - $total_amount_paid;
                                if ($balance < 0) {
                                    $balance = 0;
                                }
                            @endphp
                            <tr>
                                <td class="px-4 py-3 border-b"></td>
                                <td class="px-4 py-3 border-b">Balance: {{ number_format($balance, 2) }}</td>
                            </tr>
                        </tfoot>
                    </table>
                @endforeach
            @endif
        </div>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.3/html2pdf.bundle.min.js"
            integrity="sha512-YcsIPGdhPK4P/uRW6/sruonlYj+Q7UHWeKfTAkBW+g83NKM+jMJFJ4iAPfSnVp7BKD4dKMHmVSvICUbE/V1sSw=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script>
            function generatePDF(filename) {
                console.log(filename);
                var element = document.getElementById('element-to-print');
                var opt = {
                    margin: .2,
                    filename: filename + '.pdf',
                    image: {
                        type: 'jpeg',
                        quality: 0.98
                    },
                    html2canvas: {
                        scale: 2
                    },
                    jsPDF: {
                        unit: 'in',
                        format: 'a4',
                        orientation: 'portrait'
                    }
                };

                // New Promise-based usage:
                html2pdf().set(opt).from(element).save();
            }
        </script>
    </div>
</x-app-layout>
