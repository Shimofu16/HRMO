<!DOCTYPE html>
<html>

<head>
    <title>Generate Payslip</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    {{-- <link rel="stylesheet" href="{{ asset('assets/bootstrap/bootstrap.min.css') }}"> --}}
    <link rel="stylesheet" href="./assets/bootstrap/bootstrap.min.css" type="text/css" />
    <style>
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

        body {
            margin: 0 !important;
        }

        @page {
            margin: 0px;
        }

        .page-break {
            page-break-after: always;
        }

        .title {
            font-size: 18px;
            font-weight: 900;
        }

        .sub-title {
            font-size: 15px;
            font-weight: 900;
        }

        .body {
            font-size: 13px;
        }

        .fw-400 {
            font-weight: 400;
        }

        .fw-700 {
            font-weight: 700;
        }

        body {
            /* font-family: sans-serif !important; */
        }
    </style>
</head>

<body>
    @foreach ($employees as $employee)
        @php
            $mandatoryDeductions = $employee->getDeductionsBy('Mandatory');
            $nonmandatoryDeductions = $employee->getDeductionsBy('Non-Mandatory');
            $allowances = $employee->allowances ?? '';
            $loans = $employee->loans ?? '';
            $totalAllowance = $employee->computeAllowance();
            $totalDeduction = $employee->computeDeduction();
            $totaAmountlLoan = 0;
            $salaryGrade = $employee->salaryGradeStep->amount;

            $dates = explode('-', $payroll['date_from_to']);
            $from = $dates[0];
            $to = $dates[1];
            $amountEarned = $employee->getTotalSalaryBy($payroll['month'], $payroll['year'], $from, $to); // Get the total salary of the employee
            $totalAmountEarned = $amountEarned + $totalAllowance;

            // dd($mandatoryDeductions,$nonmandatoryDeductions,$totalDeduction);
        @endphp
        {{-- page break every 2 payslip per page --}}
        <div class="{{ $loop->iteration % 2 ? '' : 'page-break' }}" id="canvas">
            <table class="table border-2">
                <tr class="p-4 m-2 border">
                    <td colspan="9" class="border-dashed-right">
                        <div class="mb-2 text-center title">
                            <h6 class="title">MUNICIPALITY OF CALAUAN</h6>
                            <span class="block sub-title">{{ $department->dep_name }}</span>
                        </div>
                        <table class="no-padding">
                            <tr>
                                <td>
                                    <span class="text-right">
                                        <span class="font-semibold sub-title">Name:</span>
                                        <span class="fw-400">{{ $employee->full_name }}</span>
                                    </span>
                                </td>
                                <td>
                                    <span class="text-right">
                                        <span class="font-semibold sub-title">Period:</span>
                                        <span class="fw-400">{{ $filter['from'] }}-{{ $filter['to'] }}</span>
                                    </span>
                                </td>
                            </tr>
                        </table>
                        <table class="mt-4 ">
                            <tr>
                                <td colspan="4" class="border-dashed-right">
                                    <h6 class="mb-2 text-center sub-title">EARNINGS</h6>
                                    <span>
                                        <span class="font-semibold sub-title">Monthly Salary:</span>
                                        <span class="fw-400">{{ number_format($salaryGrade) }}</span>
                                    </span>
                                    <br>
                                    <span>
                                        <span class="font-semibold sub-title">Amount Earned:</span>
                                        <span class="fw-400">{{ number_format($amountEarned) }}</span>
                                    </span>
                                    <br>
                                    <h6 class="mt-3 mb-2 text-center">ALLOWANCES</h6>
                                    @foreach ($allowances as $itemallowance)
                                        <span class="mb-1">
                                            <span class="fw-400">{{ $itemallowance->allowance->allowance_code }} -
                                                {{ number_format($itemallowance->allowance->allowance_amount) }}</span>
                                        </span>
                                        <br>
                                    @endforeach
                                </td>
                                <td colspan="4 px-2">
                                    <h6 class="mb-2 text-center sub-title">DEDUCTION</h6>
                                    @if ($mandatoryDeductions)
                                        <span class="sub-title">MANDATORY</span>
                                        <br>
                                        @foreach ($mandatoryDeductions as $mandatoryDeduction)
                                            <span class="mb-1">
                                                <span
                                                    class="fw-400">{{ $mandatoryDeduction->deduction->deduction_code }}
                                                    -
                                                    {{ $mandatoryDeduction->deduction->deduction_amount_type == 'percentage' ? percentage($mandatoryDeduction->deduction->deduction_amount) : number_format($mandatoryDeduction->deduction->deduction_amount) }}
                                                </span>
                                            </span>
                                            <br>
                                        @endforeach
                                    @endif
                                    @if  (count($nonmandatoryDeductions) > 0)
                                        <span class="mt-3 sub-title">NON-MANDATORY</span>
                                        <br>
                                        @foreach ($nonmandatoryDeductions as $nonmandatoryDeduction)
                                            <span class="mb-1">
                                                <span
                                                    class="fw-400">{{ $nonmandatoryDeduction->deduction->deduction_code }}
                                                    -
                                                    {{ $nonmandatoryDeduction->deduction->deduction_amount_type == 'percentage' ? percentage($nonmandatoryDeduction->deduction->deduction_amount) : number_format($nonmandatoryDeduction->deduction->deduction_amount) }}
                                                </span>
                                            </span>
                                            <br>
                                        @endforeach
                                    @endif
                                    @if (count($loans) > 0)
                                        <span class="mt-3 sub-title">LOANS</span>
                                        <br>
                                        @foreach ($loans as $loan)
                                            <span class="mb-1">
                                                @php
                                                    $totaAmountlLoan = $totaAmountlLoan + $loan->amountToPay();
                                                @endphp
                                                <span class="fw-400">{{ $loan->loan->name }}
                                                    -
                                                    {{ $loan->amountToPay() }}
                                                </span>
                                            </span>
                                            <br>
                                        @endforeach
                                    @endif
                                </td>
                            </tr>
                        </table>

                        <table class="no-padding">
                            @php
                                $totalDeduction = $totalDeduction + $totaAmountlLoan;
                                $totalAmountEarned =$totalAmountEarned - $totaAmountlLoan;
                                $totalAmountEarned = ($totalAmountEarned < 0) ? 0 : $totalAmountEarned;
                                $netPay = $totalAmountEarned - $totalDeduction;
                                $netPay = ($netPay < 0) ? 0 : $netPay;
                            @endphp
                            <tr>
                                <td>
                                    <h6 class="mt-3 sub-title">Total Amount Earned:
                                        {{ number_format($totalAmountEarned) }}
                                    </h6>
                                </td>
                                <td>
                                    <h6 class="mt-3 sub-title">Total Deduction:
                                        {{ number_format($totalDeduction) }}
                                    </h6>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <h6 class="mt-3 sub-title">NET PAY: {{ number_format($netPay) }}</h6>
                                </td>

                            </tr>
                        </table>

                    </td>
                    <td>
                        <div class="mb-2 text-center">
                            <h6 class="title">MUNICIPALITY OF CALAUAN</h6>
                            <h6 class="sub-title">RECEIPT {{ $employee->employee_number }}</h6>
                            <span> &nbsp;</span>
                        </div>
                        <div class="contents">
                            <h6 class="sub-title">Received: </h6>
                            <h6 class="mb-3 text-center sub-title">NET PAY ₱ {{ number_format($netPay) }}</h6>
                            <h6 class="sub-title">For Period:</h6>
                            <h6 class="mb-4 text-center sub-title">{{ $filter['from'] }}-{{ $filter['to'] }}</h6>
                            <h6 class="mb-5 sub-title">Received By: </h6>
                            <h6 class="px-3 border-bottom-2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</h6>
                            <h6 class="mb-3 text-center title">{{ $employee->full_name }}</h6>
                            <h6 class="px-3 border-bottom-2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</h6>
                            <h6 class="text-center title">DATE </h6>
                        </div>
                    </td>
                </tr>
            </table>
        </div>
    @endforeach
</body>

</html>
