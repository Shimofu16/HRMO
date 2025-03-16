<div class="w-full border-2 rounded">
    <div class="flex flex-col header">
        <div class="flex items-center justify-between">
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
        <h1 class="px-3 text-xs">We acknowledge receipt of the sum shown opposite our name as full compensation for services rendered for the period stated:</h1>
    </div>
    <div class="body">
        <table class="table w-full table-bordered" style="width: 100%; table-layout: fixed;">
            <thead>
                <tr class="border-top-2">
                    <th class="border-right-2" style="width: 40px;"></th>
                    <th></th>
                    <th></th>
                    <th class="border-right-2"></th>
                    <th class="border-right-2"></th>
                    <th class="border-right-2"></th>
                    <th class="border-right-2"></th>
                    <th class="border-right-2"></th>
                    <th class="border-right-2"></th>
                    @php
                        $total_deductions_column_count = $loans->count() + $deductions->count() + 1;
                        if ($employment_type == 'jo') {
                            $total_deductions_column_count = $deductions->count();
                        }
                    @endphp
                    <th class="border-bottom-2 border-right-2" colspan="{{ $total_deductions_column_count }}">
                        <h1 class="text-xs text-center">DEDUCTIONS</h1>
                    </th>
                    <th class="border-bottom-2"></th>
                    <th class="border-bottom-2"></th>
                    <th class="border-bottom-2"></th>
                    <th class="border-bottom-2 border-right-2"></th>
                    <th class="border-right-2"></th>
                </tr>
                <tr>
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
                                Monthly Salary
                            @elseif ($employment_type == 'jo' || $employment_type == 'cas')
                                Daily Rate
                            @endif
                        </h1>
                    </th>
                    <th class="border-right-2">
                        <h1 class="text-xs text-center">
                            @if ($employment_type == 'jo')
                                Number of Days
                            @else
                                Allowance
                            @endif
                        </h1>
                    </th>
                    <th class="border-right-2">
                        <h1 class="text-xs text-center">Amount Earned</h1>
                    </th>
                    <th class="border-right-2">
                        <h1 class="text-xs text-center">Adjustment</h1>
                    </th>
                    @if ($employment_type != 'jo')
                        <th class="border-right-2">
                            <h1 class="text-xs text-center">W/H Tax</h1>
                        </th>
                    @endif
                    @foreach ($deductions as $deduction)
                        <th class="border-right-2">
                            <h1 class="text-xs text-center">{{ $deduction->deduction_code }}</h1>
                        </th>
                    @endforeach
                    @if ($employment_type != 'jo')
                        @foreach ($loans as $loan)
                            <th class="border-right-2">
                                <h1 class="text-xs text-center">{{ $loan->name }}</h1>
                            </th>
                        @endforeach
                    @endif
                    <th class="border-right-2">
                        <h1 class="text-xs text-center">GSIS</h1>
                    </th>
                    <th class="border-right-2">
                        <h1 class="text-xs text-center">Medicare</h1>
                    </th>
                    <th class="border-right-2">
                        <h1 class="text-xs text-center">Pag-ibig</h1>
                    </th>
                    <th class="border-right-2">
                        <h1 class="text-xs text-center">S. Ins.</h1>
                    </th>
                    <th class="border-right-2">
                        <h1 class="text-xs text-center">NET AMOUNT RECEIVED</h1>
                    </th>
                </tr>
            </thead>
            <tbody>
                @php
                    $total_contributions = 0;
                    $total_amount_earned = 0;
                    $total_tax = 0;
                    $total_loans = [];
                    $total_deductions = [];
                    $total_allowances = 0;
                    $total_monthly_salary = 0;
                    $sub_total_deductions = [];
                    $sub_total_amount_earned = [];
                    $total_amount_earned_for_nar = [];
                    $total_attendance = 0;
                @endphp
                @foreach ($employees as $employee)
                    @php
                        $sub_total_net_amount_received[$employee->id] = 0;
                        $attendance = attendanceCount($employee, $payroll['month'], $payroll['year'], $from, $to);
                        $sub_total_amount_earned[$employee->id] = $attendance['total_salary'];
                        $sub_total_contributions = 0;
                        if ($employment_type != 'jo') {
                            $sub_total_holding_tax[$employee->id] = 0;
                            $total_attendance += $attendance['present'];
                        }
                        $sub_total_monthly_salary[$employee->id] = $employee->data->monthly_salary;
                        $total_monthly_salary += $sub_total_monthly_salary[$employee->id];
                        if ($employment_type != 'jo') {
                            $sub_total_allowances[$employee->id] = $employee->computeAllowance($payroll['date_from_to']);
                            $total_allowances += $sub_total_allowances[$employee->id];
                        }
                        foreach ($deductions as $deduction) {
                            $total_deductions[$deduction->id] = 0;
                            $sub_total_deductions[$employee->id][$deduction->id] = 0;
                        }
                        if ($employment_type != 'jo') {
                            foreach ($loans as $loan) {
                                $total_loans[$loan->id] = 0;
                                $sub_total_loans[$employee->id][$loan->id] = 0;
                            }
                        }
                    @endphp
                    <tr>
                        <td class="text-center border-right-2 border-bottom-2">{{ $loop->iteration }}</td>
                        <td colspan="3" class="pl-2 text-xs border-right-2 border-bottom-2">{{ $employee->full_name }}</td>
                        <td class="pl-2 text-xs border-right-2 border-bottom-2">{{ $employee->data->designation->designation_name }}</td>
                        <td class="pl-2 text-xs border-right-2 border-bottom-2">{{ number_format($sub_total_monthly_salary[$employee->id], 2) }}</td>
                        <td class="pl-2 text-xs border-right-2 border-bottom-2">
                            @if ($employment_type == 'jo')
                                {{ $attendance['present'] }}
                            @else
                                {{ number_format($sub_total_allowances[$employee->id], 2) }}
                            @endif
                        </td>
                        <td class="pl-2 text-xs border-right-2 border-bottom-2">{{ number_format($sub_total_amount_earned[$employee->id], 2) }}</td>
                        <td class="pl-2 text-xs border-right-2 border-bottom-2"></td>
                        @if ($employment_type != 'jo')
                            <td class="pl-2 text-xs border-right-2 border-bottom-2">
                                @if ($employee->data->has_holding_tax)
                                    @php
                                        $sub_total_holding_tax[$employee->id] = computeHoldingTax($sub_total_monthly_salary[$employee->id], $employee->computeDeduction());
                                    @endphp
                                    {{ number_format($sub_total_holding_tax[$employee->id], 2) }}
                                @endif
                            </td>
                        @endif
                        @foreach ($deductions as $deduction)
                            @if ($employee->getDeduction($deduction->id, $payroll['date_from_to']) != 0)
                                @php
                                    $sub_total_deductions[$employee->id][$deduction->id] = $employee->getDeduction($deduction->id, $payroll['date_from_to']);
                                @endphp
                                <td class="pl-2 text-xs border-right-2 border-bottom-2">{{ number_format($employee->getDeduction($deduction->id, $payroll['date_from_to']), 2) }}</td>
                            @else
                                <td class="pl-2 text-xs border-right-2 border-bottom-2"></td>
                            @endif
                        @endforeach
                        @if ($employment_type != 'jo')
                            @foreach ($loans as $loan)
                                @if ($employee->getLoan($loan->id, $payroll['date_from_to'], $payroll['date']) != 0)
                                    @php
                                        $sub_total_loans[$employee->id][$loan->id] = $employee->getLoan($loan->id, $payroll['date_from_to'], $payroll['date']);
                                    @endphp
                                    <td class="pl-2 text-xs border-right-2 border-bottom-2">{{ number_format($employee->getLoan($loan->id, $payroll['date_from_to'], $payroll['date']), 2) }}</td>
                                @else
                                    <td class="pl-2 text-xs border-right-2 border-bottom-2"></td>
                                @endif
                            @endforeach
                        @endif
                        <td class="pl-2 text-xs border-right-2 border-bottom-2">{{ number_format($sub_total_monthly_salary[$employee->id] * 0.12, 2) }}</td>
                        <td class="pl-2 text-xs border-right-2 border-bottom-2">{{ number_format($sub_total_monthly_salary[$employee->id] * 0.025, 2) }}</td>
                        <td class="pl-2 text-xs border-right-2 border-bottom-2">200.00</td>
                        <td class="pl-2 text-xs border-right-2 border-bottom-2">100.00</td>
                        @php
                            $total_deductions_for_nar = 0;
                            $total_allowances_for_nar = 0;
                            $total_amount_earned_for_nar[$employee->id] = 0;



                            // $total_deductions_for_nar = ($sub_total_monthly_salary[$employee->id] * 0.12) + ($sub_total_monthly_salary[$employee->id] * 0.025) + 200 + 100;
                            foreach ($deductions as $deduction) {
                                $total_deductions_for_nar += $sub_total_deductions[$employee->id][$deduction->id];
                            }
                            if ($employment_type != 'jo') {
                                foreach ($loans as $loan) {
                                    $total_deductions_for_nar += $sub_total_loans[$employee->id][$loan->id];
                                }
                                $total_deductions_for_nar += $sub_total_holding_tax[$employee->id];
                            }
                            if ($employment_type != 'jo') {
                                $total_allowances_for_nar = $sub_total_allowances[$employee->id] + $sub_total_amount_earned[$employee->id];
                            }else{
                                $total_allowances_for_nar =  $sub_total_amount_earned[$employee->id];
                            }
                            $total_amount_earned_for_nar[$employee->id] = $total_allowances_for_nar - $total_deductions_for_nar;
                            // dd($total_amount_earned_for_nar);
                            if ($total_amount_earned_for_nar[$employee->id] < 0) {
                                $total_amount_earned_for_nar[$employee->id] = 0;
                            }
                         
                        @endphp
                        <td class="pl-2 text-xs border-right-2 border-bottom-2" style="font-weight: bold;">{{ number_format($total_amount_earned_for_nar[$employee->id], 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                @php
                    $total_net_amount_received = 0;
                    $total_holding_tax = 0;
                    $total_gsis = 0;
                    $total_medicare = 0;
                @endphp
                @foreach ($employees as $employee)
                    @php
                            foreach ($deductions as $deduction) {
                                if($employee->getDeduction($deduction->id, $payroll['date_from_to']) != 0){
                                    $total_deductions[$deduction->id] += $sub_total_deductions[$employee->id][$deduction->id];
                                }
                            }
                        if ($employment_type != 'jo') {
                            foreach ($loans as $loan) {
                                if($employee->getLoan($loan->id, $payroll['date_from_to'], $payroll['date']) != 0){
                                    $total_loans[$loan->id] += $sub_total_loans[$employee->id][$loan->id];
                                }
                            }
                            $total_holding_tax += $sub_total_holding_tax[$employee->id];
                        }
                        $total_amount_earned += $sub_total_amount_earned[$employee->id];
                        $total_gsis += $employee->data->monthly_salary * 0.12;
                        $total_medicare += $employee->data->monthly_salary * 0.025;
                        $total_net_amount_received += $total_amount_earned_for_nar[$employee->id];
                //    dd($total_amount_earned_for_nar);        
                    @endphp
                @endforeach
                <tr class="border-bottom-2">
                    <td class="border-right-2"></td>
                    <td colspan="4" class="border-right-2">
                        <h1 class="text-xs text-center">TOTAL >>>>>>>>>></h1>
                    </td>
                    <td class="border-right-2">
                        <h1 class="text-xs text-center">{{ number_format($total_monthly_salary, 2) }}</h1>
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
                        <h1 class="text-xs text-center">{{ number_format($total_amount_earned, 2) }}</h1>
                    </td>
                    <td class="border-right-2"></td>
                    @if ($employment_type != 'jo')
                        <td class="border-right-2">
                            <h1 class="text-xs text-center">{{ number_format($total_holding_tax, 2) }}</h1>
                        </td>
                    @endif
                    @foreach ($deductions as $deduction)
                        <td class="border-right-2">
                            <h1 class="text-xs text-center">{{ number_format($total_deductions[$deduction->id], 2) }}</h1>
                        </td>
                    @endforeach
                    @if ($employment_type != 'jo')
                        @foreach ($loans as $loan)
                            <td class="border-right-2">
                                <h1 class="text-xs text-center">{{ number_format($total_loans[$loan->id], 2) }}</h1>
                            </td>
                        @endforeach
                    @endif
                    <td class="border-right-2">
                        <h1 class="text-xs text-center">{{ number_format($total_gsis, 2) }}</h1>
                    </td>
                    <td class="border-right-2">
                        <h1 class="text-xs text-center">{{ number_format($total_medicare, 2) }}</h1>
                    </td>
                    <td class="border-right-2">
                        <h1 class="text-xs text-center">{{ number_format(200 * $employees->count(), 2) }}</h1>
                    </td>
                    <td class="border-right-2">
                        <h1 class="text-xs text-center">{{ number_format(100 * $employees->count(), 2) }}</h1>
                    </td>
                    <td class="border-right-2">
                        <h1 class="text-xs text-center" style="font-weight: bold;">{{ number_format($total_net_amount_received, 2) }}</h1>
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
                <h1>{{ $signatures->firstWhere('name', $selected_signatures[1])->position ?? '' }}</h1>
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
                            <h1>{{ $signatures->firstWhere('name', $selected_signatures[2])->position ?? '' }}</h1>
                            <p>Name & Signature of Supervisor</p>
                        @endif
                    </div>
                </td>
                <td style="text-align: center; border: none;">
                    <div>
                        <br><br>
                        @if (isset($selected_signatures[3]))
                            <h1><b><u>{{ $selected_signatures[3] }}</u></b></h1>
                            <h1>{{ $signatures->firstWhere('name', $selected_signatures[3])->position ?? '' }}</h1>
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
                                <h1>{{ $signatures->firstWhere('name', $selected_signatures[4])->position ?? '' }}</h1>
                            @endif
                        </div>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</div>
