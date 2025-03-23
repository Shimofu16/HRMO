<div>
    <div class="flex items-center justify-center my-5">
        <div class="flex flex-col " style="width: 200px">
            <div class="grid grid-cols-6 gap-6">
                <div class="col-span-6">
                    <label for="year" class="block font-medium text-gray-700">Year</label>
                    <select name="year" id="year" class="block w-full mt-1 rounded form-select" wire:model.live='year'>
                        <option value="">Please Select Here</option>
                        @foreach ($years as $year)
                            <option value="{{ $year }}">{{ $year }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-span-6">
                    <label for="month" class="block font-medium text-gray-700">Month</label>
                    <select name="month" id="month" class="block w-full mt-1 rounded form-select" wire:model.live='month'>
                        <option value="">Please Select Here</option>
                        @foreach ($months as $month)
                            <option value="{{ $month }}">{{ $month }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    </div>
    <div id="element-to-print" class="">
        @php
            $count = 1;
        @endphp
        @foreach ($payrolls as $payroll)
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
                $filter = explode('-', $payroll['date_from_to']);
                $period = "{$payroll['month']} {$payroll['date_from_to']}, {$payroll['year']}";
                $date = $amountEarned = attendanceCount($employee, $payroll['month'], $year, $filter[0], $filter[1])[
                    'total_salary'
                ];
                $monthlySalary = $employee->data->monthly_salary;
                $hazards = \App\Models\Hazard::where('category_id', $employee->data->category_id)
                                                    ->where('department_id', $employee->data->department_id)
                                                    ->whereJsonContains('ranges',  $filter[0].'-'. $filter[1])
                                                    ->whereHas('salaryGrades', function ($query) use ($employee) {
                                                        $query->where('salary_grade_id', $employee->data->salary_grade_id);
                                                    })
                                                    ->get();
                    // $rata_types = \App\Models\Rata::where('id', $employee->data->rata_id)->get();
                        // dd($hazards, $rata_types,  $filter[0].'-'. $filter[1]);
            @endphp
            <div class="flex flex-col p-2 border border-dark">
                <div class="head">
                    <h1 class="text-xs font-bold text-center">MUNICIPALITY OF CALAUAN {{  $year  }}</h1>
                    <h1 class="text-[10px] text-center font-bold">{{ $employee->data->department->dep_name }}</h1>
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
                                            @if($employee->data->rata_id && ($allowance->allowance_code === "Representation" || $allowance->allowance_code === "Transportation"))
                                                @php
                                                    $totalAllowance =
                                                    $totalAllowance + $employee->data->rata->amount;
                                                @endphp
                                                <span>
                                                    {{ number_format($employee->data->rata->amount, 2) }}
                                                </span>
                                            @else
                                                <span class="text-center">
                                                    -
                                                </span>
                                            @endif
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
                                                        {{ number_format($monthlySalary * ($hazard->amount / 100), 2) }}
                                                    @else
                                                        {{ number_format($hazard->amount, 2) }}
                                                    @endif
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
                                        @if ($employee->getLoan($loan->id, $payroll['date_from_to'],$payroll['date']) != 0)
                                            @php
                                                $totalDeduction =
                                                    $totalDeduction +
                                                    $employee->getLoan($loan->id, $payroll['date_from_to'],$payroll['date']);
                                            @endphp
                                            <span>
                                                {{ number_format($employee->getLoan($loan->id, $payroll['date_from_to'],$payroll['date']), 2) }}
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
