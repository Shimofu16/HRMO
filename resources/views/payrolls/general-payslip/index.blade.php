<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {{-- <link rel="stylesheet" href="{{ asset('assets/bootstrap/bootstrap.min.css') }}"> --}}
    {{-- <link rel="stylesheet" href="./assets/bootstrap/bootstrap.min.css" type="text/css" /> --}}
    <style>
        table.table-bordered,
        table.table-bordered tr,
        table.table-bordered thead th,
        table.table-bordered tbody td {
            border-color: rgb(31 41 55 / 1)
        }

        table.table-bordered thead>tr.btlr-2 th {
            border-top: 2px;
            border-left: 2px;
            border-right: 2px;
            border-color: rgb(31 41 55 / 1)
        }

        td,
        tr {
            /* padding: 0;
            margin: 0; */
            height: auto;
        }

        .page-break {
            page-break-before: always;
        }

        .border-2 {
            border-width: 2px;
            border-color: rgb(31 41 55 / 1)
        }

        .border-top-2 {
            border-top-width: 2px;
            border-color: rgb(31 41 55 / 1)
        }

        .border-bottom-2 {
            border-bottom-width: 2px;
            border-color: rgb(31 41 55 / 1)
        }

        .border-left-2 {
            border-left-width: 2px;
            border-color: rgb(31 41 55 / 1)
        }

        .border-right-2 {
            border-right-width: 2px;
            border-color: rgb(31 41 55 / 1)
        }

        .border-x-2 {
            border-left-width: 2px;
            border-right-width: 2px;
            border-color: rgb(31 41 55 / 1)
        }

        .border-y-2 {
            border-top-width: 2px;
            border-bottom-width: 2px;
            border-color: rgb(31 41 55 / 1)
        }

        /* .px-30{
            padding: 0 30px;
        } */
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
                    onclick="generatePDF('{{ $filename }}')">
                    Download
                </button>
                <a href="{{ route('payrolls.index') }}"
                    class="text-center text-white bg-gray-800 hover:bg-gray-900 focus:outline-none focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-xs px-5 py-2.5 mb-2 dark:bg-gray-800 dark:hover:bg-gray-700 dark:focus:ring-gray-700 dark:border-gray-700">
                    Back to Payroll
                </a>
            </div>
        </div>
        <div id="element-to-print" class="overflow-x-auto">
            <div class="w-full border-2 rounded">
                <div class="flex flex-col header">
                    <div class="flex items-center justify-between ">
                        <div></div>
                        <div>
                            <h1 class="mb-2 text-xl font-semibold text-center">GENERAL PAYROLL</h1>
                            <h3 class="mb-0 text-sm font-semibold text-center">Municipal of CALAUAN</h3>
                            <h5 class="mb-0 text-xl font-semibold text-center">Province of LAGUNA</h5>
                            <h3 class="mb-0 text-sm font-semibold text-center">{{ $department->dep_name }}</h3>
                            <h5 class="mb-0 text-xl font-semibold text-center">{{ $dateTitle }}</h5>
                        </div>
                        <div></div>
                    </div>
                    <h1 class="px-3 text-xs">We acknowledge receipt of the sum shown opposite our name as full
                        compensation for services rendered for the period stated:</h1>
                </div>
                <div class="body">
                    <table class="table w-full table-bordered" style="width: 100%; table-layout: fixed;">
                        <thead>
                            <tr style="height: 15px;" class="border-top-2 ">
                                <th class="border-right-2" style="width: 40px;">

                                </th>
                                <th>

                                </th>
                                <th>

                                </th>
                                <th class="border-right-2">

                                </th>
                                <th class="border-right-2">

                                </th>
                                <th class="border-right-2">

                                </th>
                                <th class="border-right-2">

                                </th>
                                <th class="border-right-2">

                                </th>
                                <th class="border-right-2">

                                </th>
                                <th class=" border-bottom-2">

                                </th>
                                @php
                                    $total_deductions_column_count = $loans->count() + $deductions->count();
                                    $middle = $total_deductions_column_count / 2;
                                @endphp
                                @for ($i = 1; $i <= $total_deductions_column_count; $i++)
                                    @if ($i == $total_deductions_column_count)
                                        <th class="border-right-2 border-bottom-2">

                                        </th>
                                    @else
                                        <th class=" border-bottom-2">
                                            @if ($middle == $i)
                                                <h1 class="text-xs text-center">DEDUCTIONS</h1>
                                            @endif
                                        </th>
                                    @endif
                                @endfor
                                <th class=" border-bottom-2">

                                </th>
                                <th class=" border-bottom-2">

                                </th>
                                <th class=" border-bottom-2">

                                </th>
                                <th class=" border-bottom-2 border-right-2">

                                </th>
                                <th class="">

                                </th>
                            </tr>
                            <tr style="height: 15px;" class="">
                                <th class="border-right-2">No.</th>
                                <th class="py-5 px-30 border-right-2" colspan="3">
                                    <h1 class="text-xs text-center">Name</h1>
                                </th>
                                <th class="border-right-2">
                                    <h1 class="text-xs text-center">Position</h1>
                                </th>
                                <th class="border-right-2">
                                    <h1 class="text-xs text-center">Monthly Salary</h1>
                                </th>
                                <th class="border-right-2">
                                    <h1 class="text-xs text-center">Allowance</h1>
                                </th>
                                <th class="border-right-2">
                                    <h1 class="text-xs text-center">Amount Earned</h1>
                                </th>
                                <th class="border-right-2">
                                    <h1 class="text-xs text-center">Adjustment</h1>
                                </th>
                                <th class="border-right-2" colspan="{{ $deductions->count() + 1 }}">
                                    <h1 class="text-xs text-center">Contribution P/S</h1>
                                </th>
                                <th class="border-right-2" colspan="{{ $loans->count() }}">
                                    <h1 class="text-xs text-center">Loan</h1>
                                </th>
                                <th class="border-right-2" colspan="4">
                                    <h1 class="text-xs text-center">Government Share</h1>
                                </th>
                                <th class="">
                                    <h1 class="text-xs text-center">NET AMOUNT RECEIVED</h1>
                                </th>
                            </tr>
                            <tr style="height: 10px;" class="border-bottom-2">
                                <th class="border-right-2">

                                </th>
                                <th class="">

                                </th>
                                <th class="">

                                </th>
                                <th class="border-right-2">

                                </th>
                                <th class="border-right-2">

                                </th>
                                <th class="border-right-2">

                                </th>
                                <th class="border-right-2">

                                </th>
                                <th class="border-right-2">

                                </th>
                                <th class="border-right-2">

                                </th>
                                <th class="border-right-2 border-top-2">
                                    <h1 class="text-xs text-center">W/H Tax</h1>
                                </th>
                                @foreach ($deductions as $deduction)
                                    <th class="border-right-2 border-top-2">
                                        <h1 class="text-xs text-center">{{ $deduction->deduction_code }}</h1>
                                    </th>
                                @endforeach
                                @foreach ($loans as $loan)
                                    <th class="border-right-2 border-top-2">
                                        <h1 class="text-xs text-center">{{ $loan->name }}</h1>
                                    </th>
                                @endforeach
                                <th class="border-right-2 border-top-2">
                                    GSIS
                                </th>
                                <th class="border-right-2 border-top-2">
                                    Medicare
                                </th>
                                <th class="border-right-2 border-top-2">
                                    Pag-ibig
                                </th>
                                <th class="border-right-2 border-top-2">
                                    S. Ins.
                                </th>
                                <th class="">

                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @php

                                $total_contributions = 0;
                                $total_amount_earned = 0;
                                $total_tax;
                                $total_loans = [];
                                $total_dedcutions = [];
                                $total_allowances = 0;
                                $total_montly_salary = 0;
                            @endphp
                            @foreach ($employees as $employee)
                                @php
                                    $sub_total_net_amount_recieved[$employee->id] = 0;
                                    $sub_total_amount_earned[$employee->id] = attendanceCount(
                                        $employee,
                                        $payroll['month'],
                                        $payroll['year'],
                                        $from,
                                        $to,
                                    )['total_salary'];
                                    $sub_total_contributions = 0;
                                    $sub_total_holding_tax[$employee->id] = 0;
                                    $sub_total_loans;
                                    $sub_total_dedcutions;
                                    $sub_total_allowances[$employee->id] = $employee->computeAllowance(
                                        $payroll['date_from_to'],
                                    );
                                    $sub_total_montly_salary[$employee->id] = $employee->data->monthly_salary;
                                    $total_montly_salary =
                                        $total_montly_salary + $sub_total_montly_salary[$employee->id];
                                    $total_allowances = $total_allowances + $sub_total_allowances[$employee->id];
                                    foreach ($deductions as $deduction) {
                                        $total_dedcutions[$deduction->id] = 0;
                                        $sub_total_dedcutions[$employee->id][$deduction->id] = 0;
                                    }
                                    foreach ($loans as $loan) {
                                        $total_loans[$loan->id] = 0;
                                        $sub_total_loans[$employee->id][$loan->id] = 0;
                                    }
                                @endphp

                                <tr>
                                    <td class="text-center border-right-2 border-bottom-2">{{ $loop->iteration }}</td>
                                    <td colspan="3" class="pl-2 border-right-2 border-bottom-2">
                                        {{ $employee->full_name }}</td>
                                    <td class="pl-2 border-right-2 border-bottom-2">
                                        {{ $employee->data->designation->designation_name }}</td>
                                    <td class="pl-2 border-right-2 border-bottom-2">
                                        {{ number_format($sub_total_montly_salary[$employee->id], 2) }}</td>
                                    <td class="pl-2 border-right-2 border-bottom-2">
                                        {{ number_format($sub_total_allowances[$employee->id], 2) }}
                                    </td>
                                    <td class="pl-2 border-right-2 border-bottom-2">
                                        {{ number_format($sub_total_amount_earned[$employee->id], 2) }}
                                    </td>
                                    <td class="pl-2 border-right-2 border-bottom-2"> </td>
                                    <td class="pl-2 border-right-2 border-bottom-2">
                                        @if ($employee->data->has_holding_tax)
                                            @php
                                                $sub_total_holding_tax[$employee->id] = computeHoldingTax(
                                                    $sub_total_montly_salary[$employee->id],
                                                    $employee->computeDeduction(),
                                                );
                                            @endphp
                                            {{ number_format(computeHoldingTax($sub_total_montly_salary[$employee->id], $employee->computeDeduction()), 2) }}
                                        @endif
                                    </td>
                                    @foreach ($deductions as $deduction)
                                        @if ($employee->getDeduction($deduction->id, $payroll['date_from_to']) != 0)
                                            @php
                                                $sub_total_dedcutions[$employee->id][
                                                    $deduction->id
                                                ] = $employee->getDeduction($deduction->id, $payroll['date_from_to']);
                                            @endphp
                                            <td class="pl-2 border-right-2 border-bottom-2">
                                                {{ number_format($employee->getDeduction($deduction->id, $payroll['date_from_to']), 2) }}
                                            </td>
                                        @else
                                            <td class="pl-2 border-right-2 border-bottom-2"> </td>
                                        @endif
                                    @endforeach
                                    @foreach ($loans as $loan)
                                        @if ($employee->getLoan($loan->id, $payroll['date_from_to'], $payroll['date']) != 0)
                                            @php
                                                $sub_total_loans[$employee->id][$loan->id] = $employee->getLoan(
                                                    $loan->id,
                                                    $payroll['date_from_to'],
                                                    $payroll['date']
                                                );
                                            @endphp
                                            <td class="pl-2 border-right-2 border-bottom-2">
                                                {{ number_format($employee->getLoan($loan->id, $payroll['date_from_to'],$payroll['date']), 2) }}
                                            </td>
                                        @else
                                            <td class="pl-2 border-right-2 border-bottom-2"> </td>
                                        @endif
                                    @endforeach
                                    <td class="pl-2 border-right-2 border-bottom-2">
                                        {{ number_format($sub_total_montly_salary[$employee->id] * 0.12, 2) }}</td>
                                    <td class="pl-2 border-right-2 border-bottom-2">
                                        {{ number_format($sub_total_montly_salary[$employee->id] * 0.025, 2) }}</td>
                                    <td class="pl-2 border-right-2 border-bottom-2">200.00</td>
                                    <td class="pl-2 border-right-2 border-bottom-2">100.00</td>
                                    @php
                                        $total_deductions_for_nar = 0;
                                        $total_allowances_for_nar = 0;
                                        $total_amount_earned_for_nar[$employee->id] = 0;
                                        foreach ($deductions as $deduction) {
                                            $total_deductions_for_nar =
                                                $total_deductions_for_nar +
                                                $sub_total_dedcutions[$employee->id][$deduction->id];
                                        }
                                        foreach ($loans as $loan) {
                                            $total_deductions_for_nar =
                                                $total_deductions_for_nar + $sub_total_loans[$employee->id][$loan->id];
                                        }
                                        $total_deductions_for_nar =
                                                $total_deductions_for_nar +$sub_total_holding_tax[$employee->id];
                                        // $total_deductions_for_nar =
                                        //     $total_deductions_for_nar + $employee->data->monthly_salary * 0.12;
                                        // $total_deductions_for_nar =
                                        //     $total_deductions_for_nar + $employee->data->monthly_salary * 0.025;
                                        // $total_deductions_for_nar = $total_deductions_for_nar + 300;
                                        $total_allowances_for_nar =
                                            $sub_total_allowances[$employee->id] +
                                            $sub_total_amount_earned[$employee->id];
                                        $total_amount_earned_for_nar[$employee->id] =
                                            $total_allowances_for_nar - $total_deductions_for_nar;
                                        if ($total_amount_earned_for_nar[$employee->id] < 0) {
                                            $total_amount_earned_for_nar[$employee->id] = 0;
                                        }
                                    @endphp
                                    <td class="pl-2 border-right-2 border-bottom-2">
                                        {{ number_format($total_amount_earned_for_nar[$employee->id], 2) }}</td>
                                    <!-- Other empty cells -->
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            @php
                                $total_net_amount_recieved = 0;
                                $total_holding_tax = 0;
                                $total_gsis = 0;
                                $total_medicare = 0;
                            @endphp
                            @foreach ($employees as $employee)
                                @php
                                    foreach ($deductions as $deduction) {
                                        $total_dedcutions[$deduction->id] =
                                            $total_dedcutions[$deduction->id] +
                                            $sub_total_dedcutions[$employee->id][$deduction->id];
                                    }
                                    foreach ($loans as $loan) {
                                        $total_loans[$loan->id] =
                                            $total_loans[$loan->id] + $sub_total_loans[$employee->id][$loan->id];
                                    }
                                    $total_amount_earned =
                                        $total_amount_earned + $sub_total_amount_earned[$employee->id];
                                    $total_holding_tax = $total_holding_tax + $sub_total_holding_tax[$employee->id];
                                    $total_gsis = $total_gsis + $employee->data->monthly_salary * 0.12;
                                    $total_medicare = $total_medicare + $employee->data->monthly_salary * 0.025;
                                    $total_net_amount_recieved =
                                        $total_net_amount_recieved + $total_amount_earned_for_nar[$employee->id];
                                @endphp
                            @endforeach

                            <tr>
                                <td class="border-right-2">

                                </td>
                                <td colspan="4" class="border-right-2">

                                    <h1 class="text-xs text-center">Sub Total >></h1>
                                </td>
                                <td class="border-right-2">
                                    <h1 class="text-xs text-center">{{ number_format($total_montly_salary, 2) }}</h1>
                                </td>
                                <td class="border-right-2">
                                    <h1 class="text-xs text-center">{{ number_format($total_allowances, 2) }}</h1>
                                </td>
                                <td class="border-right-2">
                                    <h1 class="text-xs text-center">{{ number_format($total_amount_earned, 2) }}</h1>
                                </td>
                                <td class="border-right-2">
                                    {{-- <h1 class="text-xs text-center">{{ number_format($total_holding_tax, 2) }}</h1> --}}
                                </td>
                                <td class="border-right-2">
                                    <h1 class="text-xs text-center">{{ number_format($total_holding_tax, 2) }}</h1>
                                </td>
                                {{-- @dd($deductions, $total_dedcutions ,$sub_total_dedcutions) --}}

                                @foreach ($deductions as $deduction)
                                    <td class="border-right-2 ">
                                        <h1 class="text-xs text-center">
                                            {{ number_format($total_dedcutions[$deduction->id], 2) }}</h1>
                                    </td>
                                @endforeach
                                @foreach ($loans as $loan)
                                    <td class="border-right-2 ">
                                        <h1 class="text-xs text-center">
                                            {{ number_format($total_loans[$loan->id], 2) }}
                                        </h1>
                                    </td>
                                @endforeach
                                <td class="border-right-2">
                                    <h1 class="text-xs text-center">{{ number_format($total_gsis, 2) }}</h1>
                                </td>
                                <td class="border-right-2">
                                    <h1 class="text-xs text-center">{{ number_format($total_medicare, 2) }}</h1>
                                </td>
                                <td class="border-right-2">
                                    <h1 class="text-xs text-center">{{ number_format(200 * $employees->count(), 2) }}
                                    </h1>
                                </td>
                                <td class="border-right-2">
                                    <h1 class="text-xs text-center">{{ number_format(100 * $employees->count(), 2) }}
                                    </h1>
                                </td>
                                <td class="border-right-2">
                                    <h1 class="text-xs text-center">{{ number_format($total_net_amount_recieved, 2) }}
                                    </h1>
                                </td>
                            </tr>
                        </tfoot>
                    </table>

                </div>
            </div>

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
                margin: .1,
                filename: filename + '.pdf',
                image: {
                    type: 'jpeg',
                    quality: 0.98
                },
                html2canvas: {
                    scale: 2
                },
                jsPDF: {
                    unit: 'in', // Maintain inches for compatibility
                    format: [30, 8.5], // Custom format for long paper (14" x 8.5")
                    orientation: 'landscape'
                }
            };

            // New Promise-based usage:
            html2pdf().set(opt).from(element).save();
        }
    </script>
</body>

</html>
