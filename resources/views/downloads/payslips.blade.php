<!DOCTYPE html>
<html>

<head>
    <title>Generate Payslip</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    {{-- <link rel="stylesheet" href="{{ asset('assets/bootstrap/bootstrap.min.css') }}"> --}}
    <link rel="stylesheet" href="./assets/bootstrap/bootstrap.min.css" type="text/css" />
    <style>
        .border-2 {
            border: 2px solid #1a1a1a;
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
            margin: 2px;
        }
        .page-break {
    page-break-after: always;
}
    </style>
</head>

<body>
    @foreach ($employees as $employee)
        @php
            $mandatoryDeductions = $employee->getDeductionsBy('Mandatory');
            $nonmandatoryDeductions = $employee->getDeductionsBy('Non Mandatory');
            $allowances = $employee->allowances;
            $salary_grade = $employee->sgrade->sg_amount / 2;
            $totalDeduction = $employee->computeDeduction();
            $totalAllowance = $employee->computeAllowance();
            $totalAmountEarned = $salary_grade + $totalAllowance;
            $netpay = $totalAmountEarned - $totalDeduction;
            // dd($mandatoryDeductions,$nonmandatoryDeductions,$totalDeduction);
        @endphp
        {{-- page break every 2 --}}
        <div class="{{  ($loop->iteration % 2) ? '' : 'page-break' ; }}" id="canvas" >
            <table class="table  border-2">
                <tr class="border p-4 m-2">
                    <td colspan="9" class="border-dashed-right">
                        <div class="title mb-2 text-center">
                            <h6 class="text-xl font-semibold">MUNICIPALITY OF CALAUAN</h6>
                            <span class="block">{{ $department->dep_name }}</span>
                        </div>
                        <table class="no-padding">
                            <tr>
                                <td>
                                    <span class="font-semibold">Name: {{ $employee->name }}</span>
                                </td>
                                <td class="text-right">
                                    <span class="font-semibold ">Period:
                                        {{ $filter['from'] }}-{{ $filter['to'] }}</span>
                                </td>
                            </tr>
                        </table>
                        <table class=" mt-4 ">
                            <tr>
                                <td colspan="4" class="border-dashed-right">
                                    <h6 class="text-center font-semibold mb-2">EARNINGS</h6>
                                    <span class="font-semibold">MONTHLY SALARY:
                                        {{ number_format($salary_grade) }}</span><br>
                                    <span class="font-semibold">AMOUNT EARNED:
                                        {{ number_format($salary_grade / 2) }}</span><br>
                                    <h6 class="text-center font-semibold mb-2">ALLOWANCES</h6>
                                    @foreach ($allowances as $itemallowance)
                                        <span class="mb- block">{{ $itemallowance->allowance->allowance_name }} -
                                            {{ number_format($itemallowance->allowance->allowance_amount) }}</span><br>
                                    @endforeach
                                </td>
                                <td colspan="4 px-2">
                                    <h6 class="text-center font-semibold mb-2">DEDUCTION</h6>
                                    <span class="font-semibold">MANDATORY</span>
                                    @foreach ($mandatoryDeductions as $mandatoryDeduction)
                                        <span class="mb- block">{{ $mandatoryDeduction->deduction->deduction_name }} -
                                            {{ number_format($mandatoryDeduction->deduction->deduction_amount) }}</span><br>
                                    @endforeach
                                    <span class="mt-3 font-semibold">NON-MANDATORY</span>
                                    @foreach ($nonmandatoryDeductions as $nonmandatoryDeduction)
                                        <span class="mb- block">{{ $nonmandatoryDeduction->deduction->deduction_name }}
                                            -
                                            {{ number_format($nonmandatoryDeduction->deduction->deduction_amount) }}</span><br>
                                    @endforeach
                                </td>
                            </tr>
                        </table>

                        <table class="no-padding">
                            <tr>
                                <td>
                                    <h6 class="mt-3 font-semibold">Total Amount Earned:
                                        {{ number_format($totalAmountEarned) }}
                                    </h6>
                                </td>
                                <td>
                                    <h6 class="mt-3 font-semibold">Total Deduction:
                                        {{ number_format($totalDeduction) }}
                                    </h6>
                                </td>
                                <td>
                                    <h6 class="mt-3 font-semibold">NET PAY: {{ number_format($netpay) }}</h6>
                                </td>
                            </tr>
                        </table>

                    </td>
                    <td>
                        <div class="text-center mb-2">
                            <h6 class="text-xl font-semibold">MUNICIPALITY OF CALAUAN</h6>
                            <h6 class="font-semibold">RECEIPT {{ $employee->emp_no }}</h6>
                            <span> &nbsp;</span>
                        </div>
                        <div class="contents">
                            <h6>Received: </h6>
                            <h6 class="mb-3 text-center">NET PAY ₱ {{ number_format($netpay) }}</h6>
                            <h6>For Period:</h6>
                            <h6 class="mb-4 text-center">{{ $filter['from'] }}-{{ $filter['to'] }}</h6>
                            <h6 class="mb-5">Received By: </h6>
                            <h6 class="px-3 border-bottom-2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</h6>
                            <h6 class="mb-3 text-center">{{ $employee->name }}</h6>
                            <h6 class="px-3 border-bottom-2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</h6>
                            <h6 class="text-center">DATE </h6>
                        </div>
                    </td>
                </tr>
            </table>
        </div>
    @endforeach
</body>

</html>

    0