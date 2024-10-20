<div>
    <div class="container mx-auto">
        <div class="flex items-center justify-center my-5 flex-col">
            <div class="flex flex-col" style="width: 200px">
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
            <div class="flex mt-5 space-x-5">

                <div class="flex flex-col">
                    <h3 class="text-md mb-3">Signatures</h3>
                    <div class="flex space-x-3">
                        <!-- Payment Method Dropdown -->
                        <div class="flex flex-col">
                            <label for="paymentMethod" class="text-sm mb-1 text-gray">1</label>
                            <select id="paymentMethod" class="text-sm rounded-lg border-gray-300">
                                <option value="" disabled selected>Please select here</option>
                                <option value="atm">ATM</option>
                                <option value="cash">Cash</option>
                            </select>

                        </div>

                        <!-- Employment Type Dropdown -->
                        <div class="flex flex-col">
                            <label for="employmentType" class="text-sm mb-1 text-gray">2</label>
                            <select id="employmentType" class="text-sm rounded-lg border-gray-300">
                                <option value="" disabled selected>Please select here</option>
                                <option value="permanent">Permanent</option>
                                <option value="casual">Casual</option>
                                <option value="job_order">Job Order</option>
                            </select>

                        </div>
                    </div>
                </div>
                <div class="flex flex-col">
                    <h3 class="text-md mb-3">Types of Payroll</h3>
                    <div class="flex space-x-3">
                        <!-- Payment Method Dropdown -->
                        <div class="flex flex-col">
                            <label for="paymentMethod" class="text-sm mb-1 text-gray">Payment</label>
                            <select id="paymentMethod" class="text-sm rounded-lg border-gray-300">
                                <option value="" disabled selected>Please select here</option>
                                <option value="atm">ATM</option>
                                <option value="cash">Cash</option>
                            </select>

                        </div>

                        <!-- Employment Type Dropdown -->
                        <div class="flex flex-col">
                            <label for="employmentType" class="text-sm mb-1 text-gray">Employment</label>
                            <select id="employmentType" class="text-sm rounded-lg border-gray-300">
                                <option value="" disabled selected>Please select here</option>
                                <option value="permanent">Permanent</option>
                                <option value="casual">Casual</option>
                                <option value="job_order">Job Order</option>
                            </select>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="element-to-print" class="overflow-x-auto">
        <div class="w-full border-2 rounded">
            <div class="flex flex-col header">
                <div class="flex items-center justify-between ">
                    <div></div>
                    <div>
                        <h1 class="mb-0 text-xs font-bold text-center">G E N E R A L - P A Y R O L L</h1>
                        <h1 class="mb-0 text-xs font-semibold text-center">Municipal of CALAUAN</h1>
                        <h1 class="mb-0 text-xs font-semibold text-center">Province of LAGUNA</h1>
                        <h1 class="mb-0 text-xs font-semibold text-center">{{ $department->dep_name }}</h1>
                        <h1 class="mb-0 text-xs font-semibold text-center">{{ $dateTitle }}</h1>
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
                            <th class="border-right-2">

                            </th>
                            <!-- <th class="">

                                </th> -->
                        </tr>
                        <tr style="height: 15px;" class="">
                            <th class="border-right-2 text-xs">No.</th>
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
                            <th class="border-right-2">
                                <h1 class="text-xs text-center ">NET AMOUNT RECEIVED</h1>
                            </th>
                            <!-- <th class="">
                                    <h1 class="text-xs text-center">SIGNATURE</h1>
                                </th> -->
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
                            <th class="text-xs border-right-2 border-top-2">
                                GSIS
                            </th>
                            <th class="text-xs border-right-2 border-top-2">
                                Medicare
                            </th>
                            <th class="text-xs border-right-2 border-top-2">
                                Pag-ibig
                            </th>
                            <th class="text-xs border-right-2 border-top-2">
                                S. Ins.
                            </th>
                            <th class="text-xs border-right-2">

                            </th>
                            <!-- <th class="">

                                </th> -->
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
                                $total_montly_salary = $total_montly_salary + $sub_total_montly_salary[$employee->id];
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
                                <td colspan="3" class="text-xs pl-2 border-right-2 border-bottom-2">
                                    {{ $employee->full_name }}</td>
                                <td class="text-xs pl-2 border-right-2 border-bottom-2">
                                    {{ $employee->data->designation->designation_name }}</td>
                                <td class="text-xs pl-2 border-right-2 border-bottom-2">
                                    {{ number_format($sub_total_montly_salary[$employee->id], 2) }}</td>
                                <td class="text-xs pl-2 border-right-2 border-bottom-2">
                                    {{ number_format($sub_total_allowances[$employee->id], 2) }}
                                </td>
                                <td class="text-xs pl-2 border-right-2 border-bottom-2">
                                    {{ number_format($sub_total_amount_earned[$employee->id], 2) }}
                                </td>
                                <td class="text-xs pl-2 border-right-2 border-bottom-2"> </td>
                                <td class="text-xs pl-2 border-right-2 border-bottom-2">
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
                                        <td class="text-xs pl-2 border-right-2 border-bottom-2">
                                            {{ number_format($employee->getDeduction($deduction->id, $payroll['date_from_to']), 2) }}
                                        </td>
                                    @else
                                        <td class="text-xs pl-2 border-right-2 border-bottom-2"> </td>
                                    @endif
                                @endforeach
                                @foreach ($loans as $loan)
                                    @if ($employee->getLoan($loan->id, $payroll['date_from_to'], $payroll['date']) != 0)
                                        @php
                                            $sub_total_loans[$employee->id][$loan->id] = $employee->getLoan(
                                                $loan->id,
                                                $payroll['date_from_to'],
                                                $payroll['date'],
                                            );
                                        @endphp
                                        <td class="text-xs pl-2 border-right-2 border-bottom-2">
                                            {{ number_format($employee->getLoan($loan->id, $payroll['date_from_to'], $payroll['date']), 2) }}
                                        </td>
                                    @else
                                        <td class="text-xs pl-2 border-right-2 border-bottom-2"> </td>
                                    @endif
                                @endforeach
                                <td class="text-xs pl-2 border-right-2 border-bottom-2">
                                    {{ number_format($sub_total_montly_salary[$employee->id] * 0.12, 2) }}</td>
                                <td class="text-xs pl-2 border-right-2 border-bottom-2">
                                    {{ number_format($sub_total_montly_salary[$employee->id] * 0.025, 2) }}</td>
                                <td class="text-xs pl-2 border-right-2 border-bottom-2">200.00</td>
                                <td class="text-xs pl-2 border-right-2 border-bottom-2">100.00</td>
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
                                        $total_deductions_for_nar + $sub_total_holding_tax[$employee->id];
                                    // $total_deductions_for_nar =
                                    //     $total_deductions_for_nar + $employee->data->monthly_salary * 0.12;
                                    // $total_deductions_for_nar =
                                    //     $total_deductions_for_nar + $employee->data->monthly_salary * 0.025;
                                    // $total_deductions_for_nar = $total_deductions_for_nar + 300;
                                    $total_allowances_for_nar =
                                        $sub_total_allowances[$employee->id] + $sub_total_amount_earned[$employee->id];
                                    $total_amount_earned_for_nar[$employee->id] =
                                        $total_allowances_for_nar - $total_deductions_for_nar;
                                    if ($total_amount_earned_for_nar[$employee->id] < 0) {
                                        $total_amount_earned_for_nar[$employee->id] = 0;
                                    }
                                @endphp
                                <td class="text-xs pl-2 border-right-2 border-bottom-2" style="font-weight: bold;">
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
                                $total_amount_earned = $total_amount_earned + $sub_total_amount_earned[$employee->id];
                                $total_holding_tax = $total_holding_tax + $sub_total_holding_tax[$employee->id];
                                $total_gsis = $total_gsis + $employee->data->monthly_salary * 0.12;
                                $total_medicare = $total_medicare + $employee->data->monthly_salary * 0.025;
                                $total_net_amount_recieved =
                                    $total_net_amount_recieved + $total_amount_earned_for_nar[$employee->id];
                            @endphp
                        @endforeach

                        <tr class="border-bottom-2">
                            <td class="border-right-2">

                            </td>
                            <td colspan="4" class="border-right-2">

                                <h1 class="text-xs text-center">TOTAL >>>>>>>>>></h1>
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
                                <td class="border-right-2">
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
                                <h1 class="text-xs text-center" style="font-weight: bold;">
                                    {{ number_format($total_net_amount_recieved, 2) }}
                                </h1>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <div class="foot py-5 px-3">
                <div class="flex flex-col justify-left mx-3 mt-2 pt-4 text-xs">
                    <p>Prepared and Checked by:</p>
                    <br> <br>
                    <h1><b><u>{{ $signatures->first()->name }}</u></b></h1>
                    <h1>{{ $signatures->first()->position }}</h1>
                </div>
                <br>

                <table class="text-xs" style="width: 70%; border-collapse: collapse; border: none;">
                    <tr>
                        <td style="text-align: left; mx-3; border: none;">
                            <p>CERTIFIED: Services have been duly rendered as stated</p>
                        </td>
                        <td style="text-align: left; border: none;">
                            <p>APPROVED FOR PAYMENT:</p>
                        </td>
                    </tr>
                    <tr>
                        <td style="text-align: center; border: none">
                            <div>
                                <br><br>
                                <h1><b><u>{{ $signatures->get(2)->name }}</u></b></h1>
                                <h1>{{ $signatures->get(2)->position }}</h1>
                                <p>Name & Signature of Supervisor</p>
                            </div>
                        </td>
                        <td style="text-align: center; border: none;">
                            <div>
                                <br><br>
                                <h1><b><u>{{ $signatures->get(1)->name }}</u></b></h1>
                                <h1>{{ $signatures->get(1)->position }}</h1>
                                <p>Name & Signature of Officer</p>
                            </div>
                        </td>
                    </tr>
                </table>
                <div class="flex flex-col justify-left mx-3 mt-2 pt-4">
                    <table class="text-xs" style="width: 45%; border-collapse: collapse; border: none;">
                        <tr>
                            <td style="text-align: left; mx-3; border: none;">
                                <p>CERTIFIED: Funds available in the amount of P__________</p>
                            </td>
                        </tr>
                        <tr>
                            <td style="text-align: center; border: none">
                                <div>
                                    <br><br>
                                    <h1><b><u>{{ $signatures->get(2)->name }}</u></b></h1>
                                    <h1>{{ $signatures->get(2)->position }}</h1>
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>

            </div>

        </div>
    </div>
</div>
