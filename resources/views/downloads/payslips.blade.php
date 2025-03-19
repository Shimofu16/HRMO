<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {{-- <link rel="stylesheet" href="{{ asset('assets/bootstrap/bootstrap.min.css') }}"> --}}
    {{-- <link rel="stylesheet" href="./assets/bootstrap/bootstrap.min.css" type="text/css" /> --}}
    {{-- <style>
        .border-2 {
            border-bottom: 2px solid #1a1a1a !important;
        }

        .border-dashed-right {
            border-right: 2px dashed #1a1a1a !important;
        }

        .border-bottom-2 {
            border-bottom: 2px solid #1a1a1a !important;
        }

        table {
            width: 100%;
        }

        /* remove border from table*/

        table tr td {
            border: none !important;
        }

        table.no-padding>tbody>tr>td {
            padding: 0 !important;
        }



        .page-break {
            page-break-after: always;
        }

        .title {
            font-size: 17px;
            font-weight: 700;
        }

        .sub-title {
            font-size: 16px;
            font-weight: 700;
        }

        body {
            font-family: Calibri !important;
            margin: 0 !important;
        }
    </style>  --}}
    <style>
        td,
        tr {
            padding: 0;
            margin: 0;
            height: auto;
        }

        .page-break {
            page-break-before: always;
        }
        .border-t {
            border-top: 1px solid #1a1a1a !important;
        }
    </style>
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased">

    <div class="container mx-auto">
        <div class="flex items-center justify-center my-5">
            <div class="flex flex-col " style="width: 200px">
                <button type="button"
                    class="text-center text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-xs px-5 py-2.5 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800"
                    onclick="generatePDF('{{ $file_name }}')">
                    Download
                </button>
                <a href="{{ route('payrolls.index') }}"
                    class="text-center text-white bg-gray-800 hover:bg-gray-900 focus:outline-none focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-xs px-5 py-2.5 mb-2 dark:bg-gray-800 dark:hover:bg-gray-700 dark:focus:ring-gray-700 dark:border-gray-700">
                    Back to Payroll
                </a>
            </div>
        </div>
        <div id="element-to-print" class="">
            @php
                $count = 1;

            @endphp
            @foreach ($employees as $employee)
                @if ($count > 3)
                    @php
                        $count = 1;
                    @endphp
                @endif
                @if ($count == 1)
                    <div class="grid grid-cols-3 gap-1">
                @endif
                @php
                    $totalAmountEarned = 0;
                    $totalAllowance = 0;
                    $totalDeduction = 0;
                    $netpay = 0;
                    $amountEarned = attendanceCount($employee, $payroll['month'], $payroll['year'], $from, $to)[
                        'total_salary'
                    ];
                    $monthlySalary = $employee->data->monthly_salary;
                    $hazards = \App\Models\Hazard::where('category_id', $employee->data->category_id)
                                                    ->where('department_id', $employee->data->department_id)
                                                    ->whereJsonContains('ranges', $from.'-'.$to)
                                                    ->whereHas('salaryGrades', function ($query) use ($employee) {
                                                        $query->where('salary_grade_id', $employee->data->salary_grade_id);
                                                    })
                                                    ->get();
                                                    // dd($hazards, $rata_types, $from.'-'.$to, $employee->data->salary_grade_id);
                                                    $rata_types = \App\Models\Rata::where('id', $employee->data->rata_id)->get();
                @endphp
                <div class="flex flex-col p-2 border border-dark">
                    <div class="head">
                        <h1 class="text-xs font-bold text-center">MUNICIPALITY OF CALAUAN</h1>
                        <h1 class="text-[10px] text-center font-bold">{{ $department->dep_name }}</h1>
                        <h1 class="text-[10px] font-bold mt-3">Payslip for the period of: {{ $period }}</h1>
                    </div>
                    <div class="w-full body">
                        <table class="w-full ">
                            <thead>
                                <tr>
                                    <th class="text-left">
                                        <span class="text-[10px] font-bold">Name:</span>
                                    </th>
                                    <th class="">
                                        <span class="text-[10px] font-bold"></span>
                                    </th>
                                    <th class="">
                                        <span class="text-[10px] font-bold">{{ $employee->full_name }}</span>
                                    </th>
                                    <th class="">
                                        <span class="text-[10px] font-bold"></span>
                                    </th>
                                </tr>
                                <tr>
                                    <th class="text-left">
                                        <span class="text-[10px]">Designation:</span>
                                    </th>
                                    <th class="">
                                        <span class="text-[10px]"></span>
                                    </th>
                                    <th class="">
                                        <span
                                            class="text-[10px]">{{ $employee->data->designation->designation_code }}</span>
                                    </th>
                                    <th class="">
                                        <span class="text-[10px]"></span>
                                    </th>
                                </tr>
                                <tr>
                                    <th class="text-left">
                                        <span class="text-[10px]">Monthly Salary:</span>
                                    </th>
                                    <th class="">
                                        <span class="text-[10px]"></span>
                                    </th>
                                    <th class="">
                                        <span class="text-[10px]">{{ number_format($monthlySalary, 2) }}</span>
                                    </th>
                                    <th class="">
                                        <span class="text-[10px]"></span>
                                    </th>
                                </tr>
                                <tr>
                                    <th class="text-left">
                                        <span class="text-[10px]">Amount Earned:</span>
                                    </th>
                                    <th class="">
                                        <span class="text-[10px]"></span>
                                    </th>
                                    <th class="">
                                        <span class="text-[10px]">{{ number_format($amountEarned, 2) }}</span>
                                    </th>
                                    <th class="">
                                        <span class="text-[10px]"></span>
                                    </th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($allowances as $allowance)
                                    <tr>
                                        <td>
                                            <span class="text-[10px]">{{ $allowance->allowance_code }}:</span>
                                        </td>
                                        <td><span class="text-[10px]"></span></td>
                                        <td class="text-[10px] text-center">
                                            @if ($employee->getAllowance($allowance->id, $payroll['date_from_to']) != 0)
                                                @php
                                                    $totalAllowance =
                                                        $totalAllowance +
                                                        $employee->getAllowance(
                                                            $allowance->id,
                                                            $payroll['date_from_to'],
                                                        );
                                                @endphp
                                                <span>
                                                    {{ number_format($employee->getAllowance($allowance->id, $payroll['date_from_to']), 2) }}
                                                </span>
                                            @else
                                                <span class="text-center">
                                                    -
                                                </span>
                                            @endif
                                        </td>
                                        <td><span class="text-[10px]"></span></td>
                                    </tr>
                                @endforeach
                                @if($hazards)
                                @foreach ($hazards as $hazard)
                                    @php
                                        if($hazard->amount_type == 'percentage'){
                                            $totalAllowance = $totalAllowance + ($monthlySalary * ($hazard->amount / 100));
                                        }else{
                                            $totalAllowance = $totalAllowance + $hazard->amount;
                                        }
                                    @endphp
                                    <tr>
                                        <td>
                                            <span class="text-[10px]">{{ $hazard->name }}:</span>
                                        </td>
                                        <td><span class="text-[10px]"></span></td>
                                        <td class="text-[10px] text-center">
                                                <span>
                                                    @if ($hazard->amount_type == 'percentage')
                                                        {{ number_format($monthlySalary * $hazard->amount,2) }}
                                                    @else
                                                        {{ number_format($hazard->amount, 2) }}
                                                    @endif
                                                </span>

                                        </td>
                                        <td><span class="text-[10px]"></span></td>
                                    </tr>
                                @endforeach
                                @endif
                                @if($rata_types)
                                @foreach ($rata_types as $rata)
                                    <tr>
                                        <td>
                                            <span class="text-[10px]">{{ $rata->type }}:</span>
                                        </td>
                                        <td><span class="text-[10px]"></span></td>
                                        <td class="text-[10px] text-center">
                                                <span>
                                                    {{ number_format($rata->amount, 2) }}
                                                </span>

                                        </td>
                                        <td><span class="text-[10px]"></span></td>
                                    </tr>
                                @endforeach
                                @endif
                                @php
                                    $totalAmountEarned = $amountEarned + $totalAllowance;
                                @endphp
                                <tr>
                                    <td>
                                        <span class="text-[10px] font-bold">TOTAL AMOUNT EARNED:</span>
                                    </td>
                                    <td><span class="text-[10px]"></span></td>
                                    <td><span class="text-[10px]"></span></td>
                                    <td>
                                        <span
                                            class="text-[10px] font-bold">{{ number_format($totalAmountEarned, 2) }}</span>
                                    </td>
                                </tr>
                                @foreach ($deductions as $deduction)
                                    <tr>
                                        <td>
                                            <span class="text-[10px]">{{ $deduction->deduction_code }}:</span>
                                        </td>
                                        <td><span class="text-[10px]"></span></td>
                                        <td class="text-[10px] text-center">
                                            @if ($employee->getDeduction($deduction->id, $payroll['date_from_to']) != 0)
                                                @php
                                                    $totalDeduction =
                                                        $totalDeduction +
                                                        $employee->getDeduction(
                                                            $deduction->id,
                                                            $payroll['date_from_to'],
                                                        );
                                                @endphp
                                                <span>
                                                    {{ number_format($employee->getDeduction($deduction->id, $payroll['date_from_to']), 2) }}
                                                </span>
                                            @else
                                                <span class="text-center">
                                                    -
                                                </span>
                                            @endif
                                        </td>
                                        <td><span class="text-[10px]"></span></td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <td>
                                        <span class="text-[10px]">With Holding Tax:</span>
                                    </td>
                                    <td><span class="text-[10px]"></span></td>
                                    <td class="text-[10px] text-center">
                                        @if ($employee->data->has_holding_tax)
                                            @php
                                                $totalDeduction =
                                                    $totalDeduction +
                                                    computeHoldingTax(
                                                        $employee->data->monthly_salary,
                                                        $employee->computeDeduction(),
                                                    );
                                            @endphp
                                            <span>
                                                {{ number_format(computeHoldingTax($employee->data->monthly_salary, $employee->computeDeduction()), 2) }}
                                            </span>
                                        @else
                                            <span class="text-center">
                                                -
                                            </span>
                                        @endif
                                    </td>
                                    <td><span class="text-[10px]"></span></td>
                                </tr>

                                @foreach ($loans as $loan)
                                    <tr>
                                        <td>
                                            <span class="text-[10px]">{{ $loan->name }}:</span>
                                        </td>
                                        <td><span class="text-[10px]"></span></td>
                                        <td class="text-[10px] text-center">
                                            @if ($employee->getLoan($loan->id, $payroll['date_from_to'], $payroll['date']) != 0)
                                                @php
                                                    $totalDeduction =
                                                        $totalDeduction +
                                                        $employee->getLoan($loan->id, $payroll['date_from_to'], $payroll['date']);
                                                @endphp
                                                <span>
                                                    {{ number_format($employee->getLoan($loan->id, $payroll['date_from_to'], $payroll['date']), 2) }}
                                                </span>
                                            @else
                                                <span class="text-center">
                                                    -
                                                </span>
                                            @endif
                                        </td>
                                        <td><span class="text-[10px]"></span></td>
                                    </tr>
                                @endforeach
                                @php
                                    $netpay = $totalAmountEarned - $totalDeduction;
                                    if ($netpay < 0) {
                                        $netpay = 0;
                                    }
                                @endphp
                                <tr>
                                    <td>
                                        <span class="text-[10px] font-bold">TOTAL DEDUCTIONS:</span>
                                    </td>
                                    <td><span class="text-[10px]"></span></td>
                                    <td><span class="text-[10px]"></span></td>
                                    <td>
                                        <span
                                            class="text-[10px] font-bold border-b-2 border-dark">{{ number_format($totalDeduction, 2) }}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <span class="text-[10px] font-bold text-blue-700">NET PAY:</span>
                                    </td>
                                    <td><span class="text-[10px]"></span></td>
                                    <td><span class="text-[10px]"></span></td>
                                    <td>
                                        <span
                                            class="text-[10px] font-bold text-blue-700  border-b-2 border-gray-500">{{ number_format($netpay, 2) }}</span>
                                    </td>
                                </tr>

                            </tbody>
                            <tfoot>
                                <tr >
                                    <td>
                                        <span class="text-[10px]">&nbsp;</span>
                                    </td>
                                    <td>
                                        <span class="text-[10px]">&nbsp;</span>
                                    </td>
                                    <td>
                                        <span class="text-[10px]">&nbsp;</span>
                                    </td>
                                    <td>
                                        <span class="text-[10px]">&nbsp;</span>
                                    </td>
                                </tr>
                                <tr >
                                    <td>
                                        <span class="text-[10px]">&nbsp;</span>
                                    </td>
                                    <td>
                                        <span class="text-[10px]">&nbsp;</span>
                                    </td>
                                    <td>
                                        <span class="text-[10px]">&nbsp;</span>
                                    </td>
                                    <td>
                                        <span
                                            class="text-[10px] font-bold  border-t border-gray-500 mt-[10px]">&nbsp;&nbsp;&nbsp;SIGNATURE&nbsp;&nbsp;&nbsp;</span>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>

                @if ($count == 3 || $loop->last)
                    </div>
                    <div class="page-break"></div> <!-- Page break for printing -->
                @endif
                @php
                    $count++;
                @endphp
            @endforeach
        </div>
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
                    orientation: 'landscape'
                }
            };

            // New Promise-based usage:
            html2pdf().set(opt).from(element).save();
        }
    </script>
</body>

</html>
