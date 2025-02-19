<div>
    <div class="container mx-auto">
        <div class="flex flex-col items-center justify-center my-5">
            {{-- <div class="flex flex-col" style="width: 200px">

            </div> --}}
            <div class="flex mt-5 space-x-10">

                <!-- Signature Dropdowns -->
                <div class="flex flex-col">
                    <h3 class="mb-3 text-md">Signatures</h3>
                    <div class="flex flex-col space-y-3">
                        @php
                            $count = 1;
                        @endphp
                        @if ($payment_method == 'atm')
                            @php
                                $count = 4;
                            @endphp
                        @endif
                        @if ($payment_method == 'cash')
                            @php
                                $count = 4;
                            @endphp
                            @if ($employment_type == 'jo')
                                @php
                                    $count = 5;
                                @endphp
                            @endif
                        @endif
                        @for ($i = 1; $i <= $count; $i++)
                            <div class="flex flex-col">
                                <label for="signature{{ $i }}" class="mb-1 text-sm text-gray">Signature
                                    {{ $i }}</label>
                                <select id="signature{{ $i }}"
                                    wire:model.live="selected_signatures.{{ $i }}"
                                    class="text-sm border-gray-300 rounded-lg">
                                    <option value="" selected>Please select here</option>
                                    @foreach ($signatures as $signature)
                                        <option value="{{ $signature->name }}">{{ $signature->name }} -
                                            {{ $signature->position }}</option>
                                    @endforeach
                                </select>
                            </div>
                        @endfor
                    </div>
                </div>

                <div class="flex flex-col">
                    <h3 class="mb-3 text-md">Types of Payroll</h3>
                    <div class="flex space-x-3">
                        <!-- Payment Method Dropdown -->
                        <div class="flex flex-col">
                            <label for="payment_method" class="mb-1 text-sm text-gray">Payment</label>
                            <select name="payment_method" id="payment_method" wire:model.live='payment_method'
                                class="text-sm border-gray-300 rounded-lg">
                                <option value="" selected>Please select here</option>
                                <option value="atm">ATM</option>
                                <option value="cash">Cash</option>
                            </select>

                        </div>

                        <!-- Employment Type Dropdown -->
                        <div class="flex flex-col">
                            <label for="employment_type" class="mb-1 text-sm text-gray">Employment</label>
                            <select name="employment_type" id="employment_type" wire:model.live='employment_type'
                                class="text-sm border-gray-300 rounded-lg">
                                <option value="" selected>Please select here</option>
                                <option value="perm">Permanent</option>
                                <option value="cas">Casual</option>
                                <option value="cos">Contract of Service</option>
                                <option value="jo">Job Order</option>
                                <option value="elect">Elective</option>
                                <option value="coterm">Coterminous</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Generate Button -->
            <div class="flex flex-col mt-5" style="width: 200px">
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
    </div>

    <div id="element-to-print" class="overflow-x-auto">
        @if ($employment_type)
            @if ($isEmpty)
                <h3 class="p-4 mb-3 text-xl text-center text-white bg-red-600">No Employees found</h3>
            @else
                @if ($payment_method == 'atm')
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
                                    <tr class="border-top-2 ">
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
                                        @php
                                            $total_deductions_column_count = $loans->count() + $deductions->count() + 1;
                                            $middle = $total_deductions_column_count / 2;
                                            if ($employment_type == 'jo') {
                                                $total_deductions_column_count = $deductions->count();
                                            }
                                        @endphp
                                        <th class=" border-bottom-2 border-right-2"
                                            colspan="{{ $total_deductions_column_count }}">

                                            <h1 class="text-xs text-center">DEDUCTIONS</h1>
                                        </th>
                                        {{-- @for ($i = 1; $i <= $total_deductions_column_count; $i++)
                                        @if ($i == $total_deductions_column_count)
                                            <th class="border-right-2 border-bottom-2">

                                            </th>
                                        @else
                                            <th class=" border-bottom-2">

                                                    <h1 class="text-xs text-center">DEDUCTIONS</h1>
                                            </th>
                                        @endif
                                    @endfor --}}
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
                                    <tr class="">
                                        <th class="text-xs border-right-2">No.</th>
                                        <th class="py-5 px-30 border-right-2" colspan="3">
                                            <h1 class="text-xs text-center">Name</h1>
                                        </th>
                                        <th class="border-right-2">
                                            <h1 class="text-xs text-center">Position</h1>
                                        </th>
                                        <th class="border-right-2">
                                            <h1 class="text-xs text-center">
                                                @if ($employment_type == 'perm' || $employment_type == 'cos' || $employment_type == 'elect')
                                                    {{ 'Monthly Salary' }}
                                                @endif
                                                @if ($employment_type == 'jo' || $employment_type == 'cas')
                                                    {{ 'Daily Rate' }}
                                                @endif
                                            </h1>
                                        </th>
                                        <th class="border-right-2">
                                            <h1 class="text-xs text-center">
                                                @if ($employment_type == 'jo')
                                                    {{ 'Number of Days' }}
                                                @else
                                                    {{ 'Allowance' }}
                                                @endif
                                            </h1>
                                        </th>
                                        <th class="border-right-2">
                                            <h1 class="text-xs text-center">Amount Earned</h1>
                                        </th>
                                        <th class="border-right-2">
                                            <h1 class="text-xs text-center">Adjustment</h1>
                                        </th>
                                        <th class="border-right-2"
                                            colspan="{{ $employment_type == 'jo' ? $deductions->count() : $deductions->count() + 1 }}">
                                            <h1 class="text-xs text-center">Contribution P/S</h1>
                                        </th>
                                        @if ($employment_type != 'jo')
                                            <th class="border-right-2" colspan="{{ $loans->count() }}">
                                                <h1 class="text-xs text-center">Loan</h1>
                                            </th>
                                        @endif
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
                                        @if ($employment_type != 'jo')
                                            <th class="border-right-2 border-top-2">
                                                <h1 class="text-xs text-center">W/H Tax</h1>
                                            </th>
                                        @endif
                                        @foreach ($deductions as $deduction)
                                            <th class="border-right-2 border-top-2">
                                                <h1 class="text-xs text-center">{{ $deduction->deduction_code }}</h1>
                                            </th>
                                        @endforeach
                                        @if ($employment_type != 'jo')
                                            @foreach ($loans as $loan)
                                                <th class="border-right-2 border-top-2">
                                                    <h1 class="text-xs text-center">{{ $loan->name }}</h1>
                                                </th>
                                            @endforeach
                                        @endif
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
                                        $sub_total_dedcutions = [];
                                        $sub_total_amount_earned = [];
                                        $total_attendance = 0;
                                    @endphp
                                    @foreach ($employees as $employee)
                                        @php
                                            $sub_total_net_amount_recieved[$employee->id] = 0;
                                            $attendance = attendanceCount(
                                                $employee,
                                                $payroll['month'],
                                                $payroll['year'],
                                                $from,
                                                $to,
                                            );
                                            $sub_total_amount_earned[$employee->id] = $attendance['total_salary'];
                                            $sub_total_contributions = 0;
                                            if ($employment_type != 'jo') {
                                                $sub_total_holding_tax[$employee->id] = 0;
                                                $total_attendance = $total_attendance + $attendance['present'];
                                            }
                                            $sub_total_loans = [];
                                            $sub_total_dedcutions = [];
                                            $sub_total_montly_salary[$employee->id] = $employee->data->monthly_salary;
                                            $total_montly_salary =
                                                $total_montly_salary + $sub_total_montly_salary[$employee->id];
                                            if ($employment_type != 'jo') {
                                                $sub_total_allowances[$employee->id] = $employee->computeAllowance(
                                                    $payroll['date_from_to'],
                                                );
                                                $total_allowances =
                                                    $total_allowances + $sub_total_allowances[$employee->id];
                                            }

                                            foreach ($deductions as $deduction) {
                                                $total_dedcutions[$deduction->id] = 0;
                                                $sub_total_dedcutions[$employee->id][$deduction->id] = 0;
                                            }
                                            if ($employment_type != 'jo') {
                                                foreach ($loans as $loan) {
                                                    $total_loans[$loan->id] = 0;
                                                    $sub_total_loans[$employee->id][$loan->id] = 0;
                                                }
                                            }
                                        @endphp
                                        {{-- @dd($attendance, $total_dedcutions, $sub_total_dedcutions) --}}
                                        <tr>
                                            <td class="text-center border-right-2 border-bottom-2">
                                                {{ $loop->iteration }}
                                            </td>
                                            <td colspan="3" class="pl-2 text-xs border-right-2 border-bottom-2">
                                                {{ $employee->full_name }}</td>
                                            <td class="pl-2 text-xs border-right-2 border-bottom-2">
                                                {{ $employee->data->designation->designation_name }}</td>
                                            <td class="pl-2 text-xs border-right-2 border-bottom-2">
                                                {{ number_format($sub_total_montly_salary[$employee->id], 2) }}</td>
                                            <td class="pl-2 text-xs border-right-2 border-bottom-2">
                                                @if ($employment_type == 'jo')
                                                    {{ $attendance['present'] }}
                                                @else
                                                    {{ number_format($sub_total_allowances[$employee->id], 2) }}
                                                @endif
                                            </td>
                                            <td class="pl-2 text-xs border-right-2 border-bottom-2">
                                                {{ number_format($sub_total_amount_earned[$employee->id], 2) }}
                                            </td>
                                            <td class="pl-2 text-xs border-right-2 border-bottom-2"> </td>
                                            @if ($employment_type != 'jo')
                                                <td class="pl-2 text-xs border-right-2 border-bottom-2">
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
                                            @endif
                                            @foreach ($deductions as $deduction)
                                                @if ($employee->getDeduction($deduction->id, $payroll['date_from_to']) != 0)
                                                    @php
                                                        if ($employment_type != 'jo') {
                                                            $sub_total_dedcutions[$employee->id][
                                                                $deduction->id
                                                            ] = $employee->getDeduction(
                                                                $deduction->id,
                                                                $payroll['date_from_to'],
                                                            );
                                                        }
                                                    @endphp
                                                    <td class="pl-2 text-xs border-right-2 border-bottom-2">
                                                        {{ number_format($employee->getDeduction($deduction->id, $payroll['date_from_to']), 2) }}
                                                    </td>
                                                @else
                                                    <td class="pl-2 text-xs border-right-2 border-bottom-2"> </td>
                                                @endif
                                            @endforeach
                                            @if ($employment_type != 'jo')
                                                @foreach ($loans as $loan)
                                                    @if ($employee->getLoan($loan->id, $payroll['date_from_to'], $payroll['date']) != 0)
                                                        @php
                                                            $sub_total_loans[$employee->id][
                                                                $loan->id
                                                            ] = $employee->getLoan(
                                                                $loan->id,
                                                                $payroll['date_from_to'],
                                                                $payroll['date'],
                                                            );
                                                        @endphp
                                                        <td class="pl-2 text-xs border-right-2 border-bottom-2">
                                                            {{ number_format($employee->getLoan($loan->id, $payroll['date_from_to'], $payroll['date']), 2) }}
                                                        </td>
                                                    @else
                                                        <td class="pl-2 text-xs border-right-2 border-bottom-2"> </td>
                                                    @endif
                                                @endforeach
                                            @endif
                                            <td class="pl-2 text-xs border-right-2 border-bottom-2">
                                                {{ number_format($sub_total_montly_salary[$employee->id] * 0.12, 2) }}
                                            </td>
                                            <td class="pl-2 text-xs border-right-2 border-bottom-2">
                                                {{ number_format($sub_total_montly_salary[$employee->id] * 0.025, 2) }}
                                            </td>
                                            <td class="pl-2 text-xs border-right-2 border-bottom-2">200.00</td>
                                            <td class="pl-2 text-xs border-right-2 border-bottom-2">100.00</td>
                                            @php
                                                $total_deductions_for_nar = 0;
                                                $total_allowances_for_nar = 0;
                                                $total_amount_earned_for_nar[$employee->id] = 0;
                                                foreach ($deductions as $deduction) {
                                                    $total_deductions_for_nar =
                                                        $total_deductions_for_nar +
                                                        $sub_total_dedcutions[$employee->id][$deduction->id];
                                                }
                                                if ($employment_type != 'jo') {
                                                    foreach ($loans as $loan) {
                                                        $total_deductions_for_nar =
                                                            $total_deductions_for_nar +
                                                            $sub_total_loans[$employee->id][$loan->id];
                                                    }
                                                    $total_deductions_for_nar =
                                                        $total_deductions_for_nar +
                                                        $sub_total_holding_tax[$employee->id];
                                                }

                                                // $total_deductions_for_nar =
                                                //     $total_deductions_for_nar + $employee->data->monthly_salary * 0.12;
                                                // $total_deductions_for_nar =
                                                //     $total_deductions_for_nar + $employee->data->monthly_salary * 0.025;
                                                // $total_deductions_for_nar = $total_deductions_for_nar + 300;
                                                if ($employment_type != 'jo') {
                                                    $total_allowances_for_nar =
                                                        $sub_total_allowances[$employee->id] +
                                                        $sub_total_amount_earned[$employee->id];
                                                }
                                                if ($employment_type != 'jo') {
                                                    $total_amount_earned_for_nar[$employee->id] =
                                                        $total_allowances_for_nar - $total_deductions_for_nar;
                                                } else {
                                                    $total_amount_earned_for_nar[
                                                        $employee->id
                                                    ] = $total_deductions_for_nar;
                                                }

                                                if ($total_amount_earned_for_nar[$employee->id] < 0) {
                                                    $total_amount_earned_for_nar[$employee->id] = 0;
                                                }
                                            @endphp
                                            <td class="pl-2 text-xs border-right-2 border-bottom-2"
                                                style="font-weight: bold;">
                                                {{ number_format($total_amount_earned_for_nar[$employee->id], 2) }}
                                            </td>
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
                                    {{-- @dd($total_dedcutions, $sub_total_amount_earned, $employees) --}}
                                    @foreach ($employees as $employee)
                                        @php
                                            foreach ($deductions as $deduction) {
                                                $total_dedcutions[$deduction->id] =
                                                    $total_dedcutions[$deduction->id] +
                                                    $sub_total_dedcutions[$employee->id][$deduction->id];
                                            }
                                            if ($employment_type != 'jo') {
                                                foreach ($loans as $loan) {
                                                    $total_loans[$loan->id] =
                                                        $total_loans[$loan->id] +
                                                        $sub_total_loans[$employee->id][$loan->id];
                                                }
                                                $total_holding_tax =
                                                    $total_holding_tax + $sub_total_holding_tax[$employee->id];
                                            }
                                            $total_amount_earned =
                                                $total_amount_earned + $sub_total_amount_earned[$employee->id];
                                            $total_gsis = $total_gsis + $employee->data->monthly_salary * 0.12;
                                            $total_medicare = $total_medicare + $employee->data->monthly_salary * 0.025;
                                            $total_net_amount_recieved =
                                                $total_net_amount_recieved +
                                                $total_amount_earned_for_nar[$employee->id];
                                        @endphp
                                    @endforeach

                                    <tr class="border-bottom-2">
                                        <td class="border-right-2">

                                        </td>
                                        <td colspan="4" class="border-right-2">

                                            <h1 class="text-xs text-center">TOTAL >>>>>>>>>></h1>
                                        </td>
                                        <td class="border-right-2">
                                            <h1 class="text-xs text-center">
                                                {{ number_format($total_montly_salary, 2) }}
                                            </h1>
                                        </td>
                                        <td class="border-right-2">
                                            <h1 class="text-xs text-center">
                                                @if ($employment_type == 'jo')
                                                    {{ $total_attendance }}
                                                @else
                                                    {{ number_format($total_allowances, 2) }}
                                                @endif
                                            </h1>
                                        </td>
                                        <td class="border-right-2">
                                            <h1 class="text-xs text-center">
                                                {{ number_format($total_amount_earned, 2) }}
                                            </h1>
                                        </td>
                                        <td class="border-right-2">
                                            {{-- <h1 class="text-xs text-center">{{ number_format($total_holding_tax, 2) }}</h1> --}}
                                        </td>
                                        @if ($employment_type != 'jo')
                                            <td class="border-right-2">
                                                <h1 class="text-xs text-center">
                                                    {{ number_format($total_holding_tax, 2) }}
                                                </h1>
                                            </td>
                                        @endif
                                        {{-- @dd($deductions, $total_dedcutions ,$sub_total_dedcutions) --}}

                                        @foreach ($deductions as $deduction)
                                            <td class="border-right-2">
                                                <h1 class="text-xs text-center">
                                                    {{ number_format($total_dedcutions[$deduction->id], 2) }}</h1>
                                            </td>
                                        @endforeach
                                        @if ($employment_type != 'jo')

                                            @foreach ($loans as $loan)
                                                <td class="border-right-2 ">
                                                    <h1 class="text-xs text-center">
                                                        {{ number_format($total_loans[$loan->id], 2) }}
                                                    </h1>
                                                </td>
                                            @endforeach

                                        @endif
                                        <td class="border-right-2">
                                            <h1 class="text-xs text-center">{{ number_format($total_gsis, 2) }}</h1>
                                        </td>
                                        <td class="border-right-2">
                                            <h1 class="text-xs text-center">{{ number_format($total_medicare, 2) }}
                                            </h1>
                                        </td>
                                        <td class="border-right-2">
                                            <h1 class="text-xs text-center">
                                                {{ number_format(200 * $employees->count(), 2) }}
                                            </h1>
                                        </td>
                                        <td class="border-right-2">
                                            <h1 class="text-xs text-center">
                                                {{ number_format(100 * $employees->count(), 2) }}
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
                        <!-- Footer Section where selected signatures are shown -->
                        <div class="px-3 py-5 foot">
                            <div class="flex flex-col pt-4 mx-3 mt-2 text-xs justify-left">
                                <p>Prepared and Checked by:</p>
                                <br> <br>
                                @if (isset($selected_signatures[1]))
                                    <h1><b><u>{{ $selected_signatures[1] }}</u></b></h1>
                                    <h1>{{ $signatures->firstWhere('name', $selected_signatures[1])->position ?? '' }}
                                    </h1>
                                @endif
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
                                            @if (isset($selected_signatures[2]))
                                                <h1><b><u>{{ $selected_signatures[2] }}</u></b></h1>
                                                <h1>{{ $signatures->firstWhere('name', $selected_signatures[2])->position ?? '' }}
                                                </h1>
                                                <p>Name & Signature of Supervisor</p>
                                            @endif
                                        </div>
                                    </td>
                                    <td style="text-align: center; border: none;">
                                        <div>
                                            <br><br>
                                            @if (isset($selected_signatures[3]))
                                                <h1><b><u>{{ $selected_signatures[3] }}</u></b></h1>
                                                <h1>{{ $signatures->firstWhere('name', $selected_signatures[3])->position ?? '' }}
                                                </h1>
                                                <p>Name & Signature of Officer</p>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            </table>

                            <div class="flex flex-col pt-4 mx-3 mt-2 justify-left">
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
                                                @if (isset($selected_signatures[4]))
                                                    <h1><b><u>{{ $selected_signatures[4] }}</u></b></h1>
                                                    <h1>{{ $signatures->firstWhere('name', $selected_signatures[4])->position ?? '' }}
                                                    </h1>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                @endif
                @if ($payment_method == 'cash')
                    <div class="w-full border-2 rounded">
                        <div class="flex flex-col header">
                            <div class="flex items-center justify-between ">
                                <div></div>
                                <div>
                                    <h1 class="mb-0 text-xs font-bold text-center">G E N E R A L - P A Y R O L L</h1>
                                    <h1 class="mb-0 text-xs font-semibold text-center">Municipal of CALAUAN</h1>
                                    <h1 class="mb-0 text-xs font-semibold text-center">Province of LAGUNA</h1>
                                    <h1 class="mb-0 text-xs font-semibold text-center">{{ $department->dep_name }}
                                    </h1>
                                    <h1 class="mb-0 text-xs font-semibold text-center">{{ $dateTitle }}</h1>
                                </div>
                                <div></div>
                            </div>
                            <h1 class="px-3 text-xs">We acknowledge receipt of the sum shown opposite our name as full
                                compensation for services rendered for the period stated:</h1>
                        </div>
                        <div class="body">
                            <table class="table w-full table-bordered" style="width: 100%; table-layout: fixed;">
                                @if ($employment_type == 'perm' || $employment_type == 'cas' || $employment_type == 'cos' || $employment_type == 'elect' || $employment_type == 'coterm')
                                    <thead>
                                        <tr class="border-top-2 ">
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
                                            <th class="border-top-2 border-right-2"
                                                colspan="{{ $deductions->count() }}">
                                                <h1 class="text-xs text-center">
                                                    Deductions</h1>
                                            </th>
                                            <th class="border-right-2" style="width: 40px;">

                                            </th>
                                            <th class="border-right-2">

                                            </th>
                                            <th class="">

                                            </th>
                                            <th class="border-right-2">

                                            </th>
                                        </tr>
                                        <tr class="">
                                            <th class="text-xs border-right-2">No.</th>
                                            <th class="py-5 px-30 border-right-2" colspan="3">
                                                <h1 class="text-xs text-center">Name</h1>
                                            </th>
                                            <th class="border-right-2">
                                                <h1 class="text-xs text-center">Position</h1>
                                            </th>
                                            <th class="border-right-2">
                                                <h1 class="text-xs text-center">
                                                    Monthly Salary
                                                </h1>
                                            </th>
                                            <th class="border-right-2">
                                                <h1 class="text-xs text-center">
                                                    Financial Assistance
                                                </h1>
                                            </th>
                                            <th class="border-right-2">
                                                <h1 class="text-xs text-center">Amount Earned</h1>
                                            </th>
                                            @foreach ($deductions as $deduction)
                                                <th class="border-right-2 border-top-2">
                                                    <h1 class="text-xs text-center">{{ $deduction->deduction_code }}
                                                    </h1>
                                                </th>
                                            @endforeach
                                            <th class="border-right-2" style="width: 40px;">
                                                <h1 class="text-xs text-center">No.</h1>
                                            </th>
                                            <th class="border-right-2">
                                                <h1 class="text-xs text-center">Net Amount Recienved</h1>
                                            </th>
                                            <th class="border-right-2" colspan="2">
                                                <h1 class="text-xs text-center">Signature of Payes</h1>
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
                                            @foreach ($deductions as $deduction)
                                                <th class="border-right-2 border-bottom-2">

                                                </th>
                                            @endforeach

                                            </th>

                                            <th class="border-right-2">

                                            </th>
                                            <th class="border-right-2">

                                            </th>
                                            <th class="border-bottom-2">

                                            </th>
                                            <th class="border-right-2">

                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $total_monthly_salary = [];
                                            $total_financial_assistance = [];
                                            $subtotal_deductions = [];
                                            $total_deductions = [];
                                            $total_amount_earned = [];
                                            $total_net_amount_earned = [];
                                        @endphp
                                        @foreach ($employees as $employee)
                                            @php
                                                $attendance = attendanceCount(
                                                    $employee,
                                                    $payroll['month'],
                                                    $payroll['year'],
                                                    $from,
                                                    $to,
                                                );
                                                $total_monthly_salary[$employee->id] = $employee->data->monthly_salary;
                                                $total_amount_earned[$employee->id] = $attendance['total_salary'];
                                                $total_deductions[$employee->id] = 0;
                                                $total_financial_assistance[
                                                    $employee->id
                                                ] = $employee->computeAllowance(
                                                    $payroll['date_from_to'],
                                                ); 
                                            @endphp
                                            {{-- @dd($total_monthly_salary) --}}
                                            <tr>
                                                <td class="text-center border-right-2 border-bottom-2">
                                                    {{ $loop->iteration }}
                                                </td>
                                                <td colspan="3"
                                                    class="pl-2 text-xs border-right-2 border-bottom-2">
                                                    {{ $employee->full_name }}
                                                </td>
                                                <td class="pl-2 text-xs border-right-2 border-bottom-2">
                                                    {{ $employee->data->designation->designation_name }}
                                                </td>
                                                <td class="pl-2 text-xs border-right-2 border-bottom-2 text-center">
                                                    @if ($loop->first || $loop->last)
                                                        PHP
                                                    @endif
                                                    {{ number_format($total_monthly_salary[$employee->id], 2) }}
                                                </td>
                                                <td class="pl-2 text-xs border-right-2 border-bottom-2 text-center">
                                                    @if ($loop->first || $loop->last)
                                                        PHP
                                                    @endif
                                                    {{ number_format($total_financial_assistance[$employee->id], 2) }}
                                                </td>
                                                <td class="pl-2 text-xs border-right-2 border-bottom-2 text-center">
                                                    @if ($loop->first || $loop->last)
                                                        PHP
                                                    @endif
                                                    {{ number_format($total_amount_earned[$employee->id], 2) }}
                                                </td>
                                                @foreach ($deductions as $deduction)
                                                    @if ($employee->getDeduction($deduction->id, $payroll['date_from_to']) != 0)
                                                        @php
                                                            $subtotal_deductions[$employee->id][
                                                                $deduction->id
                                                            ] = $employee->getDeduction(
                                                                $deduction->id,
                                                                $payroll['date_from_to'],
                                                            );
                                                            $total_deductions[$employee->id] =
                                                                $total_deductions[$employee->id] +
                                                                $employee->getDeduction(
                                                                    $deduction->id,
                                                                    $payroll['date_from_to'],
                                                                );
                                                        @endphp
                                                        <td class="text-xs border-right-2 border-bottom-2 text-center">
                                                            @if ($loop->first || $loop->last)
                                                                PHP
                                                            @endif
                                                            {{ number_format($employee->getDeduction($deduction->id, $payroll['date_from_to']), 2) }}
                                                        </td>
                                                    @else
                                                        <td class="text-xs border-right-2 border-bottom-2"> </td>
                                                    @endif
                                                @endforeach
                                                <td class="border-right-2 text-xs border-bottom-2 text-center">
                                                    {{ $loop->iteration }}
                                                </td>
                                                @php
                                                    $subtotal = 
                                                        $total_financial_assistance[$employee->id] + $total_amount_earned[$employee->id];
                                                    $total_net_amount_earned[$employee->id] = ($total_financial_assistance[$employee->id] - $total_deductions[$employee->id]) + $subtotal
                                                @endphp
                                                <td class="border-right-2 text-xs border-bottom-2 text-center">
                                                    @if ($loop->first || $loop->last)
                                                        PHP
                                                    @endif
                                                    {{ number_format($total_net_amount_earned[$employee->id], 2) }}

                                                </td>
                                                <td class="border-right-2 text-xs border-bottom-2" colspan="2">

                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="border-bottom-2">

                                                </td>
                                                <td class="border-right-2 border-bottom-2" colspan="4">
                                                    TOTAL
                                                </td>
                                                <td class="border-right-2 border-bottom-2 text-xs text-center">
                                                    PHP
                                                    {{ number_format(array_sum($total_monthly_salary), 2) }}
                                                </td>
                                                <td class="border-right-2 border-bottom-2 text-xs text-center">
                                                    PHP
                                                    {{ number_format(array_sum($total_financial_assistance), 2) }}
                                                </td>
                                                <td class="border-right-2 border-bottom-2 text-xs text-center">
                                                    PHP
                                                    {{ number_format(array_sum($total_amount_earned), 2) }}
                                                </td>
                                                @foreach ($deductions as $deduction)
                                                    @if ($loop->last)
                                                        <td class="border-right-2 border-bottom-2 text-xs text-center">
                                                            PHP
                                                            {{ number_format(array_sum($total_deductions), 2) }}
                                                        </td>
                                                    @else
                                                        <td class="border-bottom-2">

                                                        </td>
                                                    @endif
                                                @endforeach

                                                <td class="border-right-2 border-bottom-2 text-xs text-center"
                                                    colspan="2">
                                                    PHP
                                                    {{ number_format(array_sum($total_net_amount_earned), 2) }}
                                                </td>
                                                <td class="border-right-2 border-bottom-2 text-xs text-center"
                                                    colspan="2">

                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr class="mb-5">
                                            <td class="border-right-2 border-bottom-2" colspan="8">
                                                <div class="flex flex-col space-y-5">
                                                    <h1 class="text-xs mb-5">CERTIFIED: Services have been duly
                                                        rendereddd as stated</h1>
                                                    <div class="flex flex-col text-center mb-5">
                                                        @if (isset($selected_signatures[1]))
                                                            <h1 class="text-xs">
                                                                <b><u>{{ $selected_signatures[1] }}</u></b>
                                                            </h1>
                                                            <h1 class="text-xs">
                                                                {{ $signatures->firstWhere('name', $selected_signatures[1])->position ?? '' }}
                                                            </h1>
                                                            <h1 class="text-xs">Name & Signature of Supervisor</h1>
                                                        @endif
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="border-right-2 border-bottom-2"
                                                colspan="{{ $deductions->count() + 4 }}">
                                                <div class="flex flex-col space-y-5">
                                                    <h1 class="text-xs mb-5">APPROVED FOR PAYMENT</h1>
                                                    <div class="flex flex-col text-center mb-5">
                                                        @if (isset($selected_signatures[2]))
                                                            <h1 class="text-xs">
                                                                <b><u>{{ $selected_signatures[2] }}</u></b>
                                                            </h1>
                                                            <h1 class="text-xs">
                                                                {{ $signatures->firstWhere('name', $selected_signatures[2])->position ?? '' }}
                                                            </h1>
                                                            <h1 class="text-xs">Name & Signature of Officer</h1>
                                                        @endif
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr class="mb-5">
                                            <td class="border-right-2  " colspan="8">
                                                <div class="flex flex-col space-y-5">
                                                    <h1 class="text-xs mb-5">CERTIFIED: Funds available in the amount
                                                        of P_________________</h1>
                                                    <div class="flex flex-col text-center mb-5">
                                                        @if (isset($selected_signatures[3]))
                                                            <h1 class="text-xs">
                                                                <b><u>{{ $selected_signatures[3] }}</u></b>
                                                            </h1>
                                                            <h1 class="text-xs">
                                                                {{ $signatures->firstWhere('name', $selected_signatures[3])->position ?? '' }}
                                                            </h1>
                                                        @endif
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="border-right-2  " colspan="{{ $deductions->count() + 4 }}">
                                                <div class="flex flex-col space-y-5">
                                                    <h1 class="text-xs mb-5">CERTIFIED: Each employee whose name
                                                        appears above has been paid the amount indicated opposite
                                                        his/ger name.</h1>
                                                    <div class="flex justify-center items-center space-x-3">
                                                        <div class="flex flex-col text-center mb-5 mr-3">
                                                            @if (isset($selected_signatures[4]))
                                                                <h1 class="text-xs">
                                                                    <b><u>{{ $selected_signatures[4] }}</u></b>
                                                                </h1>
                                                                <h1 class="text-xs">
                                                                    {{ $signatures->firstWhere('name', $selected_signatures[4])->position ?? '' }}
                                                                </h1>
                                                            @endif
                                                        </div>
                                                        <div class="flex flex-col text-center mb-5">
                                                            <h1 class="text-xs"><b>Date<u> &nbsp; &nbsp; &nbsp;&nbsp;
                                                                        &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; </u></b></h1>
                                                        </div>

                                                    </div>
                                                </div>
                                            </td>
                                        </tr>

                                    </tfoot>
                                @endif
                                @if ($employment_type == 'jo')
                                    <thead>
                                        <tr class="border-top-2 ">
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

                                            <th class=" border-bottom-2" colspan="3">
                                                <h1 class="text-xs text-center">COMMUNITY TAX CERTIFICATE</h1>
                                            </th>
                                        </tr>
                                        <tr class="">
                                            <th class="text-xs border-bottom-2 border-right-2">No.</th>
                                            <th class="py-5 px-30 border-bottom-2 border-right-2" colspan="3">
                                                <h1 class="text-xs text-center">Name</h1>
                                            </th>
                                            <th class="border-bottom-2 border-right-2">
                                                <h1 class="text-xs text-center">Position</h1>
                                            </th>
                                            <th class="border-bottom-2 border-right-2">
                                                <h1 class="text-xs text-center">
                                                    # of days worked
                                                </h1>
                                            </th>
                                            <th class="border-bottom-2 border-right-2">
                                                <h1 class="text-xs text-center">
                                                    Rate/Pay
                                                </h1>
                                            </th>
                                            <th class="border-bottom-2 border-right-2">
                                                <h1 class="text-xs text-center">Amount Paid</h1>
                                            </th>
                                            <th class="border-bottom-2 border-right-2">
                                                <h1 class="text-xs text-center">Signature or Tumbmark</h1>
                                            </th>
                                            <th class="border-bottom-2 border-right-2">
                                                <h1 class="text-xs text-center">Number</h1>
                                            </th>
                                            <th class="border-bottom-2 border-right-2">
                                                <h1 class="text-xs text-center">Date</h1>
                                            </th>
                                            <th class="border-bottom-2 border-right-2">
                                                <h1 class="text-xs text-center">Place of issue</h1>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $total_number_of_days = [];
                                            $total_rate = [];
                                            $total_amount_paid = [];
                                        @endphp
                                        @foreach ($employees as $employee)
                                            @php
                                                $attendance = attendanceCount(
                                                    $employee,
                                                    $payroll['month'],
                                                    $payroll['year'],
                                                    $from,
                                                    $to,
                                                );
                                                $total_number_of_days[$employee->id] = $attendance['present'];
                                                $total_rate[$employee->id] = $employee->data->monthly_salary;
                                                $total_amount_paid[$employee->id] =
                                                    $attendance['present'] * $employee->data->monthly_salary;
                                            @endphp

                                            <tr>
                                                <td class="text-center border-right-2 border-bottom-2">
                                                    {{ $loop->iteration }}
                                                </td>
                                                <td colspan="3"
                                                    class="pl-2 text-xs border-right-2 border-bottom-2">
                                                    {{ $employee->full_name }}
                                                </td>
                                                <td class="pl-2 text-xs border-right-2 border-bottom-2">
                                                    {{ $employee->data->designation->designation_name }}
                                                </td>
                                                <td class="pl-2 text-xs border-right-2 border-bottom-2">
                                                    {{ $total_number_of_days[$employee->id] }}
                                                </td>
                                                <td class="pl-2 text-xs border-right-2 border-bottom-2">
                                                    ₱ {{ number_format($total_rate[$employee->id], 2) }}
                                                </td>
                                                <td class="pl-2 text-xs border-right-2 border-bottom-2">
                                                    ₱ {{ number_format($total_amount_paid[$employee->id], 2) }}
                                                </td>
                                                <td class="pl-2 text-xs border-right-2 border-bottom-2">

                                                </td>
                                                <td class="pl-2 text-xs border-right-2 border-bottom-2">

                                                </td>
                                                <td class="pl-2 text-xs border-right-2 border-bottom-2">

                                                </td>
                                                <td class="pl-2 text-xs border-right-2 border-bottom-2">
                                                    {{ 'Calauan, Laguna' }}
                                                </td>
                                            </tr>
                                        @endforeach
                                        <tr>
                                            <td class="text-center border-right-2 border-bottom-2">

                                            </td>
                                            <td colspan="4"
                                                class="px-2 text-xs text-end border-right-2 border-bottom-2">
                                                {{ 'TOTAL' }}
                                            </td>
                                            <td class="text-center border-right-2 border-bottom-2">
                                                {{ number_format(array_sum($total_number_of_days), 2) }}
                                            </td>
                                            <td class="text-center border-right-2 border-bottom-2">

                                            </td>
                                            <td class="text-center border-right-2 border-bottom-2">
                                                ₱ {{ number_format(array_sum($total_amount_paid), 2) }}
                                            </td>
                                            <td class="text-center border-right-2 border-bottom-2">

                                            </td>
                                            <td class="text-center border-right-2 border-bottom-2">

                                            </td>
                                            <td class="text-center border-right-2 border-bottom-2">

                                            </td>
                                            <td class="text-center border-right-2 border-bottom-2">

                                            </td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr style="height: 20px;" class="">
                                            <td colspan="4" class="border-right-2 ">
                                                <h1 class="p-3">Prepared by: <b>
                                                        @if (isset($selected_signatures[1]))
                                                            {{ $selected_signatures[1] }}
                                                        @endif
                                                    </b></h1>
                                            </td>
                                            <td colspan="5" class="border-right-2 ">
                                                {{-- <h1 class="text-center">Approved for payment:</h1> --}}
                                            </td>
                                            <td colspan="3" class="border-right-2 ">
                                                {{-- <h1 class="text-center">Approved for payment:</h1> --}}
                                            </td>
                                        </tr>
                                        <tr style="height: 20px;" class="">
                                            <td colspan="4" class="border-right-2">
                                                <h1 class="">Noted by: <b>
                                                        @if (isset($selected_signatures[2]))
                                                            {{ $selected_signatures[2] }}
                                                        @endif
                                                    </b></h1>
                                            </td>
                                            <td colspan="5" class="border-right-2">
                                                <h1 class="">Approved for payment:</h1>
                                            </td>
                                            <td colspan="3" class="border-right-2">
                                                <h1 class="">Approved for payment:</h1>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="4" class="border-right-2">
                                                <h1 class="">Each person whose name appears on this roll had
                                                    rendered services for the time stated</h1>
                                            </td>
                                            <td colspan="5" class="border-right-2">
                                                <h1 class=""></h1>
                                            </td>
                                            <td colspan="3" class="border-right-2">
                                                <h1 class="">Each person whose name appears on this roll has been
                                                    paid the amount stated opposite his name after identifying him</h1>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td colspan="4" class="text-center border-right-2 border-bottom-2">
                                                @if (isset($selected_signatures[3]))
                                                    <h1><b><u>{{ $selected_signatures[3] }}</u></b></h1>
                                                    <h1>{{ $signatures->firstWhere('name', $selected_signatures[3])->position ?? '' }}
                                                    </h1>
                                                @endif
                                            </td>
                                            <td colspan="5" class="text-center border-right-2 border-bottom-2">
                                                @if (isset($selected_signatures[4]))
                                                    <h1><b><u>{{ $selected_signatures[4] }}</u></b></h1>
                                                    <h1>{{ $signatures->firstWhere('name', $selected_signatures[4])->position ?? '' }}
                                                    </h1>
                                                @endif
                                            </td>
                                            <td colspan="3" class="text-center border-right-2 border-bottom-2">
                                                @if (isset($selected_signatures[5]))
                                                    <h1><b><u>{{ $selected_signatures[5] }}</u></b></h1>
                                                    <h1>{{ $signatures->firstWhere('name', $selected_signatures[5])->position ?? '' }}
                                                    </h1>
                                                @endif
                                            </td>
                                        <tr>
                                            <td colspan="4" class="text-center border-right-2">
                                                <h1>Name and signature of Foreman/Supervisor</h1>
                                            </td>
                                            <td colspan="5" class="text-center border-right-2">
                                                <h1>Name and signature of Approaving Supervisor</h1>
                                            </td>
                                            <td colspan="3" class="text-center border-right-2">
                                                <h1>Name and signature of Disbusrsing Officer</h1>
                                            </td>
                                        </tr>
                                    </tfoot>
                                @endif

                            </table>
                        </div>
                    </div>
                @endif
            @endif
        @endif
    </div>
</div>
