<!DOCTYPE html>
<html>

<head>
    <title>Generate Payslip</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" href="{{ asset('assets/bootstrap/bootstrap.min.css') }}">
    {{-- <link rel="stylesheet" href="./assets/bootstrap/bootstrap.min.css" type="text/css" /> --}}
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

        table tr th,
        table tr td {
            border: none !important;
        }
        table tr th,
        table tr td {
            border: none !important;
        }

        table.no-padding>thead>tr>th{
            padding: 0;
            padding-bottom: 10px;
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
    {{-- page break every 2 payslip per page --}}
    <div class="" id="canvas">
        <table class="table  border-2">
            <tr class="border p-4 m-2">
                <td colspan="9" class="border-dashed-right">
                    <div class="title mb-2 text-center">
                        <h6 class="title">MUNICIPALITY OF CALAUAN</h6>
                        <span class="block sub-title">{{ $employee->department->dep_name }}</span>
                    </div>
                    <table class="no-padding">
                        <tr>
                            <td>
                                <span class="text-right">
                                    <span class="sub-title font-semibold">Name:</span>
                                    <span class="fw-400">{{ $employee->full_name }}</span>
                                </span>
                            </td>
                        </tr>
                    </table>
                    <table class="mt-2">
                        <tr>
                            <td colspan="5" class="">
                                <h6 class="text-center  mb-2 sub-title">Seminars</h6>
                                @php
                                    $totalAmountEarned = 0;
                                @endphp
                                <table class="no-padding">
                                    <thead>
                                        <tr>
                                            <th class="text-start">
                                                <span class="text-right">Seminar
                                                </span>
                                            </th>
                                            <th class="text-start">
                                                <span class="text-right">Date
                                                </span>
                                            </th>
                                            <th class="text-start">
                                                <span class="text-right">Amount
                                                </span>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($attendances as $attendance)
                                            <tr>
                                                <td>{{ $attendance->seminar->name }}</td>
                                                <td>{{ date('M d, Y', strtotime($attendance->seminar->date)) }}</td>
                                                <td>PHP {{ number_format($attendance->seminar->amount) }}</td>
                                                @php
                                                    $totalAmountEarned = $totalAmountEarned + $attendance->seminar->amount;
                                                @endphp
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                    </table>

                    <table class="no-padding mt-4">
                        <tr>
                            <td>
                                <h6 class="mt-3 sub-title">Total Amount Earned:
                                    {{ number_format($totalAmountEarned) }}
                                </h6>
                            </td>
                        </tr>
                    </table>
                </td>
                <td>
                    <div class="text-center mb-2">
                        <h6 class="title">MUNICIPALITY OF CALAUAN</h6>
                        <h6 class="sub-title">RECEIPT {{ $employee->employee_number }}</h6>
                        <span> &nbsp;</span>
                    </div>
                    <div class="contents">
                        <h6 class="sub-title">Received: </h6>
                        <h6 class="mb-5 text-center sub-title">NET PAY ₱ {{ number_format($totalAmountEarned) }}</h6>
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
</body>

</html>
