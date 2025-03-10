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