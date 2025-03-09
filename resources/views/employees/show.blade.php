<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Employee Information
            </h2>

    </x-slot>
    <style>
        .page-break {
            page-break-before: always;
        }
    </style>
    <div class="flex mx-auto mt-8 space-x-3 max-w-7xl">

        <div class="w-1/4 p-5 bg-white rounded-md shadow ">
            <div class="mb-3 border-b border-gray-100">
                <h1 class="text-2xl font-bold text-center">Actions</h1>
            </div>
            <div class="flex flex-col space-y-2">
                <button type="button"
                    class="text-blue-700 hover:text-white border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2 dark:border-blue-500 dark:text-blue-500 dark:hover:text-white dark:hover:bg-blue-500 dark:focus:ring-blue-800"
                    onclick="generatePDF('{{ $employee->full_name }} - Information', 'employeeData')">
                    Download to PDF
                </button>
                <button type="button"
                    class="text-blue-700 hover:text-white border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2 dark:border-blue-500 dark:text-blue-500 dark:hover:text-white dark:hover:bg-blue-500 dark:focus:ring-blue-800"
                    onclick="window.dispatchEvent(new CustomEvent('open-modal', { detail: 'uploadPdsModal' }))">
                    @if ($employee->data->pds)
                        Personal Data Sheet
                    @else
                        Upload PDS
                    @endif
                </button>
                <button type="button"
                    class="text-blue-700 hover:text-white border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2 dark:border-blue-500 dark:text-blue-500 dark:hover:text-white dark:hover:bg-blue-500 dark:focus:ring-blue-800"
                    onclick="window.dispatchEvent(new CustomEvent('open-modal', { detail: 'leaveRequests' }))">
                    Leave Requests
                </button>
                <button type="button"
                    class="text-blue-700 hover:text-white border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2 dark:border-blue-500 dark:text-blue-500 dark:hover:text-white dark:hover:bg-blue-500 dark:focus:ring-blue-800"
                    onclick="window.dispatchEvent(new CustomEvent('open-modal', { detail: 'holdingTaxModal' }))">
                    Holding Tax
                </button>

                <button type="button"
                    class="text-blue-700 hover:text-white border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2 dark:border-blue-500 dark:text-blue-500 dark:hover:text-white dark:hover:bg-blue-500 dark:focus:ring-blue-800"
                    onclick="window.dispatchEvent(new CustomEvent('open-modal', { detail: 'promotionHistory' }))">
                    Promotion History
                </button>
                <a href="{{ route('employees.edit', $employee) }}"
                    class="text-blue-700 hover:text-white border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2 dark:border-blue-500 dark:text-blue-500 dark:hover:text-white dark:hover:bg-blue-500 dark:focus:ring-blue-800">
                    Edit
                </a>
                <form class="flex flex-col" action="{{ route('employees.destroy', $employee) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="text-red-700 hover:text-white border border-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2 dark:border-red-500 dark:text-red-500 dark:hover:text-white dark:hover:bg-red-600 dark:focus:ring-red-900">
                        Delete
                    </button>
                </form>
                <hr>
                {{-- <a href="{{ route('seminars.payslip', ['employee_id' => $employee->id]) }}"
                    class="inline-flex items-center px-4 py-2 font-bold text-gray-800 bg-gray-300 rounded hover:bg-gray-400">
                    <svg class="w-4 h-4 mr-2 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                        <path d="M13 8V2H7v6H2l8 8 8-8h-5zM0 18h20v2H0v-2z" />
                    </svg>
                    <span>Payslip (Seminars)</span>
                </a> --}}
                <a href="{{ route('employees.index') }}"
                    class="inline-flex items-center px-4 py-2 text-xs font-semibold tracking-widest text-gray-700 uppercase transition duration-150 ease-in-out bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25">
                    Back to Employee List
                </a>
            </div>
            <x-modal name="uploadPdsModal" maxWidth="lg" headerTitle="Upload PDS">

                <form action="{{ route('employees.upload.pds', $employee) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <!-- Modal body -->
                    <div class="p-4 md:p-5 space-y-4">
                        <div class="grid grid-cols-12 gap-6 mb-3">
                            <div class="col-span-6">
                                <label for="pds" class="block font-medium text-gray-700">
                                    Personal Data Sheet
                                </label>
                                <input type="file" name="pds" id="pds"
                                    class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"
                                    required>
                            </div>
                        </div>
                    </div>
                    <!-- Modal footer -->
                    <div
                        class="flex justify-end items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                        <button data-modal-hide="default-modal" type="submit"
                            class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                            Upload
                        </button>
                        @if ($employee->data->pds)
                            <a href="{{ route('employees.pds', $employee) }}"
                                class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">
                                Download PDS
                            </a>
                        @else
                            <button type="button" x-on:click="$dispatch('close')"
                                class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">
                                Close
                            </button>
                        @endif
                    </div>
                </form>
            </x-modal>
            <x-modal name="promotionHistory" headerTitle="Promotion History">
                <!-- Modal body -->
                <div class="p-4 md:p-5 space-y-4">
                    <table class="min-w-full border">
                        <thead>
                            <tr>
                                <th class="px-4 py-4 text-left border-b">#</th>
                                <th class="px-4 py-4 text-left border-b">Old Category</th>
                                <th class="px-4 py-4 text-left border-b">New Category</th>
                                <th class="px-4 py-4 text-left border-b">Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($employee->promotions as $promotion)
                                <tr>
                                    <td class="px-4 py-3 border-b">
                                        {{ $loop->iteration }}
                                    </td>
                                    <td class="px-4 py-3 border-b">
                                        {{ $promotion->old->category_name }}
                                    </td>
                                    <td class="px-4 py-3 border-b">
                                        {{ $promotion->new->category_name }}
                                    </td>
                                    <td class="px-4 py-3 border-b">
                                        {{ date('F d, Y', strtotime($promotion->created_at)) }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- Modal footer -->
                <div
                    class="flex justify-end items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">

                    <button type="button" x-on:click="$dispatch('close')"
                        class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">Close</button>
                </div>
            </x-modal>
            @if($employee->data->rata_id)
            <x-modal name="holdingTaxModal" headerTitle="Holding Tax">
                <!-- Modal body -->
                <div class="p-4 md:p-5 space-y-4">
                    @php
                            $total_holding_tax = 0; // Initialize total holding tax
                     
                        @endphp
                        <table class="min-w-full border mb-3">
                            <thead>
                                <tr>
                                    <th class="px-4 py-4 text-left border-b">#</th>
                                    <th class="px-4 py-4 text-left border-b">Month</th>
                                    <th class="px-4 py-4 text-left border-b">Amount per 15 days</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($employee->attendances()->selectRaw('YEAR(time_in) as year, MONTH(time_in) as month, MIN(time_in) as earliest_time_in')->where('isPresent', 1)->groupByRaw('YEAR(time_in), MONTH(time_in)')->orderByRaw('YEAR(time_in), MONTH(time_in)')->get() as $month => $attendance)
                                    @php
                                        // Calculate monthly holding tax
                                        $monthly_holding_tax =
                                            computeHoldingTax(
                                                $employee->data->monthly_salary,
                                                $employee->computeDeduction('1-15'),
                                            ) / 2;
                                        $total_holding_tax += $monthly_holding_tax; // Add to total holding tax
                                    @endphp
                                    <tr>
                                        <td class="px-4 py-3 border-b">{{ $loop->iteration }}</td>
                                        <td class="px-4 py-3 border-b">
                                            {{ date('F', strtotime($attendance->earliest_time_in)) }} -
                                            {{ $attendance->year }}</td>
                                        <td class="px-4 py-3 border-b">
                                            {{ number_format($monthly_holding_tax, 2) }}
                                            <!-- Split into two halves -->
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td class="px-4 py-3 border-b"></td>
                                    <td class="px-4 py-3 border-b"></td>
                                    <td class="px-4 py-3 border-b">Total: {{ number_format($total_holding_tax, 2) }}
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                </div>
                <!-- Modal footer -->
                <div
                    class="flex justify-end items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">

                    <button type="button" x-on:click="$dispatch('close')"
                        class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">Close</button>
                </div>
            </x-modal>
            @endif
            <x-modal name="leaveRequests" maxWidth="6xl" headerTitle="Leave Requests">
                <!-- Modal body -->
                <div class="p-4 md:p-5 space-y-4" id="leaveRequestsPdf">
                    <h1 class="text-xl font-bold hide" id="employee-name">Employee: {{ $employee->full_name }}</h1>
                    <h1 class="text-xl font-bold hide" id="employee-number">Employee #:
                        {{ $employee->employee_number }}
                    </h1>
                    <div class="flex justify-between items-center">
                    </div>
                    <table class="min-w-full border">
                        <thead>
                            <tr>
                                <th class="px-2 py-4 text-left border-b">#</th>
                                <th class="px-2 py-4 text-left border-b">Date</th>
                                <th class="px-2 py-4 text-left border-b">Days Leave</th>
                                <th class="px-2 py-4 text-left border-b">Remaining Points</th>
                                <th class="px-2 py-4 text-left border-b">Deducted Points</th>
                                <th class="px-2 py-4 text-left border-b">Type</th>
                                {{-- <th class="px-2 py-4 text-left border-b">File</th> --}}
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($employee->leaveRequests()->orderBy('created_at', 'desc')->get() as $leave_request)
                                <tr>
                                    <td class="px-2 py-2 border-b">{{ $loop->iteration }}</td>
                                    <td class="px-2 py-2 border-b">
                                        {{ date('M, d Y', strtotime($leave_request->start)) }} to
                                        {{ date('M, d Y', strtotime($leave_request->end)) }}
                                    </td>
                                    <td class="px-2 py-2 border-b">{{ $leave_request->days }}</td>
                                    <td class="px-2 py-2 border-b">
                                        @php
                                            $points = $leave_request->points;
                                            if ($leave_request->type == 'force_leave') {
                                                $points =
                                                    5 -
                                                    \App\Models\Attendance::where('type', $leave_request->type)
                                                        ->whereYear('created_at', now()->format('Y'))
                                                        ->count();
                                            }
                                            if ($leave_request->type == 'special_leave') {
                                                $points =
                                                    3 -
                                                    \App\Models\Attendance::where('type', $leave_request->type)
                                                        ->whereYear('created_at', now()->format('Y'))
                                                        ->count();
                                            }
                                            @php;
                                        @endphp
                                        {{ number_format($points, 2) }}</td>
                                    <td class="px-2 py-2 border-b">
                                        {{ number_format($leave_request->deducted_points, 2) }}
                                    </td>
                                    <td class="px-2 py-2 border-b">
                                        {{ Str::ucfirst(Str::replaceFirst('_', ' ', $leave_request->type)) }}
                                    </td>
                                    {{-- <td class="px-2 py-2 border-b">
                                        @if ($leave_request->file)
                                            <a href="{{ route('leave-requests.download', $leave_request) }}"
                                                class="text-blue-700 hover:text-white border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2 dark:border-blue-500 dark:text-blue-500 dark:hover:text-white dark:hover:bg-blue-500 dark:focus:ring-blue-800">
                                                Download
                                            </a>
                                        @else
                                            No file
                                        @endif
                                    </td> --}}
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- Modal footer -->
                <div
                    class="flex justify-between items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                    <a href="{{ route('leave-requests.create', $employee) }}"
                        class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        Create Request
                    </a>
                    <div>
                        <button type="button"
                            class="text-white ms-3 bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                            onclick="generatePDF('{{ $employee->full_name }} - leave requests', 'leaveRequestsPdf')">
                            Download
                        </button>
                        <button type="button" x-on:click="$dispatch('close')"
                            class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">
                            Close
                        </button>
                    </div>

                </div>
            </x-modal>
            {{-- <x-modal name="leaveList" headerTitle="Leave List">
                <!-- Modal body -->
                <div class="p-4 md:p-5 space-y-4" id="leaveRequestsPdf">
                    <h1 class="text-xl font-bold hide" id="employee-name">Employee: {{ $employee->full_name }}</h1>
                    <h1 class="text-xl font-bold hide" id="employee-number">Employee #:
                        {{ $employee->employee_number }}
                    </h1>
                    <div class="flex justify-between items-center">
                    </div>
                    <table class="min-w-full border">
                        <thead>
                            <tr>
                                <th class="px-2 py-4 text-left border-b">#</th>
                                <th class="px-4 py-2 text-left border-b">Date</th>
                                <th class="px-4 py-2 text-left border-b">Days Leave</th>
                                <th class="px-4 py-2 text-left border-b">Type</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($employee->leaveRequests as $leave_request)
                                <tr>
                                    <td class="px-2 py-2 border-b">{{ $loop->iteration }}</td>
                                    <td class="px-2 py-2 border-b">
                                        {{ date('M, d Y', strtotime($leave_request->start)) }} to
                                        {{ date('M, d Y', strtotime($leave_request->end)) }}
                                    </td>
                                    <td class="px-2 py-2 border-b">{{ $leave_request->days }}</td>
                                    <td class="px-2 py-2 border-b">
                                        @php
                                            $points = $leave_request->points;
                                            if ($leave_request->type == 'force_leave') {
                                                $points =
                                                    5 -
                                                    \App\Models\Attendance::where('type', $leave_request->type)
                                                        ->whereYear('created_at', now()->format('Y'))
                                                        ->count();
                                            }
                                            if ($leave_request->type == 'special_leave') {
                                                $points =
                                                    3 -
                                                    \App\Models\Attendance::where('type', $leave_request->type)
                                                        ->whereYear('created_at', now()->format('Y'))
                                                        ->count();
                                            }
                                        @endphp
                                        {{ number_format($points, 2) }}</td>
                                    <td class="px-2 py-2 border-b">
                                        {{ number_format($leave_request->deducted_points, 2) }}
                                    </td>
                                    <td class="px-2 py-2 border-b">
                                        {{ Str::ucfirst(Str::replaceFirst('_', ' ', $leave_request->type)) }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- Modal footer -->
                <div
                    class="flex justify-end items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                    <button type="button"
                        class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                        onclick="generatePDF('{{ $employee->full_name }} - leave requests', 'leaveRequestsPdf')">
                        Download
                    </button>
                    <button type="button" x-on:click="$dispatch('close')"
                        class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">Close</button>
                </div>
            </x-modal> --}}
        </div>
        <div class="w-full bg-white rounded-md shadow" id="employeeData">
            <div class="mb-3 p-2 flex justify-between items-center">
                <div><img src="{{ asset('assets/images/cl-logo.png') }}" alt="calauan logo" class="h-20"></div>
                <div class="text-center">
                    <h1 class="text-md font-bold">Republic of the Philippines</h1>
                    <h1 class="text-md font-bold">Province of Laguna</h1>
                    <h1 class="text-md font-bold">Municipality of Calauan</h1>
                </div>
                <div><img src="{{ asset('assets/images/cl-pnp-logo.png') }}" alt="calauan logo" class="h-20">
                </div>
            </div>
            <div class="p-5">
                <div class="mb-3 border-b border-gray-100">
                    <h1 class="text-2xl font-bold">Personal Information</h1>
                </div>
                <div class="flex justify-between">

                    <div>
                        <h3><strong>Employee No.: </strong>{{ $employee->employee_number }}</h3>
                        <h3><strong>Ordinance Item No.: </strong>{{ $employee->ordinance_number }}</h3>
                        <h3><strong>Name: </strong>{{ $employee->full_name }}</h3>

                        <h3><strong>Department: </strong>{{ $employee->data->department->dep_name }}</h3>
                        <h3><strong>Designation: </strong>{{ $employee->data->designation->designation_name }}</h3>
                        <h3><strong>Type of Employment: </strong>{{ $employee->data->category->category_name }}</h3>
                        <h3><strong>Type of Payroll: </strong>{{ $employee->data->payroll_type }}</h3>
                        @if ($employee->data->category->category_code == 'JO')
                            <h3><strong>Level: </strong> {{ $employee->data->level->name }}</h3>
                        @elseif ($employee->data->category->category_code != 'COS' && $employee->data->category->category_code != 'JO')
                            <h3><strong>Salary Grade: </strong> Salary Grade {{ $employee->data->salary_grade_id }}
                            </h3>
                            <h3><strong>Salary Grade Step: </strong> {{ $employee->data->salary_grade_step }} </h3>
                        @endif
                        <h3><strong>Monthly Salary: </strong>
                            {{ number_format($employee->data->monthly_salary, 2) }}</h3>
                        @if ($employee->data->category->category_code != 'JO')
                            <h3><strong>Sick Leave Points:
                                </strong>{{ number_format($employee->data->sick_leave_points, 2) }}</h3>
                        @endif
                    </div>
                    <div class="mr-3">
                        <img src="{{ asset('storage/photos/' . $employee->employee_photo) }}" class="rounded"
                            style="height: 170px; width: 170px;">
                    </div>
                </div>
                <div class="text-right">
                    <h3><strong></strong>{{ \Carbon\Carbon::now()->format('F Y') }}</h3>
                </div>
                <hr class="h-px mb-3 bg-gray-200 border-0 dark:bg-gray-700">
                @if ($employee->data->category->category_code != 'JO')
                    @php
                        $hazards = \App\Models\Hazard::where('category_id', $employee->data->category_id)
                                                    ->where('department_id', $employee->data->department_id)
                                                    ->whereHas('salaryGrades', function ($query) use ($employee) {
                                                        $query->where('salary_grade_id', $employee->data->salary_grade_id);
                                                    })
                                                    ->get();
                    @endphp
                    <div class="my-3 border-b border-gray-100">
                        <h1 class="text-2xl font-bold">Deductions & Allowances</h1>
                    </div>
                    @if (count($employee->deductions) > 0)
                        <h3><strong>Deductions</strong></h3>
                        @php
                            $total_deductions = $employee->computeDeduction();
                        @endphp
                        <table class="min-w-full border">
                            <thead>
                                <tr>
                                    <th class="px-4 py-4 text-left border-b">#</th>
                                    <th class="px-4 py-4 text-left border-b">Deduction</th>
                                    <th class="px-4 py-4 text-left border-b">Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($employee->deductions as $deduction)
                                    <tr>
                                        <td class="px-4 py-3 border-b">
                                            {{ $loop->iteration }}
                                        </td>
                                        <td class="px-4 py-3 border-b">{{ $deduction->deduction->deduction_name }}
                                        </td>
                                        <td class="px-4 py-3 border-b">
                                            {{ number_format($employee->getDeduction($deduction->deduction_id, null), 2) }}
                                        </td>
                                    </tr>
                                @endforeach
                                @if ($employee->data->has_holding_tax)
                                    @php
                                        $total_deductions =
                                            $total_deductions +
                                            computeHoldingTax(
                                                $employee->data->monthly_salary,
                                                $employee->computeDeduction(),
                                            );
                                    @endphp
                                    <tr>
                                        <td class="px-4 py-3 border-b">
                                            {{ count($employee->deductions) + 1 }}
                                        </td>
                                        <td class="px-4 py-3 border-b">With Holding Tax</td>
                                        <td class="px-4 py-3 border-b">
                                            {{ number_format(computeHoldingTax($employee->data->monthly_salary, $employee->computeDeduction()), 2) }}
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td class="px-4 py-3 border-b"></td>
                                    <td class="px-4 py-3 border-b"></td>
                                    <td class="px-4 py-3 border-b">Total: {{ number_format($total_deductions, 2) }}
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    @endif
                    @if (count($employee->allowances) > 0)
                        <h3 class="mt-3"><strong>Allowances</strong></h3>
                        @php
                            $total_allowances = 0;
                        @endphp
                        <table class="min-w-full border mb-3">
                            <thead>
                                <tr>
                                    <th class="px-4 py-4 text-left border-b">#</th>
                                    <th class="px-4 py-4 text-left border-b">Allowance</th>
                                    <th class="px-4 py-4 text-left border-b">Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($employee->allowances as $allowance)
                                    @php
                                        $total_allowances =
                                            $total_allowances + $employee->getAllowance($allowance->allowance->id);
                                    @endphp
                                    <tr>
                                        <td class="px-4 py-3 border-b">
                                            {{ $loop->iteration }}
                                        </td>
                                        <td class="px-4 py-3 border-b">{{ $allowance->allowance->allowance_code }}
                                        </td>
                                        <td class="px-4 py-3 border-b">
                                            {{ number_format($employee->getAllowance($allowance->allowance->id), 2) }}
                                        </td>
                                    </tr>
                                @endforeach
                                @if ($employee->data->rata_id)
                                    @php
                                        $total_allowances = $total_allowances + $employee->data->rata->amount * 2;
                                    @endphp
                                    <tr>
                                        <td class="px-4 py-3 border-b">
                                            {{ count($employee->allowances) + 1 }}
                                        </td>
                                        <td class="px-4 py-3 border-b">Representation
                                        </td>
                                        <td class="px-4 py-3 border-b">
                                            {{ number_format($employee->data->rata->amount, 2) }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="px-4 py-3 border-b">
                                            {{ count($employee->allowances) + 2 }}
                                        </td>
                                        <td class="px-4 py-3 border-b">Transportation
                                        </td>
                                        <td class="px-4 py-3 border-b">
                                            {{ number_format($employee->data->rata->amount, 2) }}
                                        </td>
                                    </tr>
                                @endif
                                @if($hazards)
                                    @foreach ($hazards as $hazard)
                                        @php
                                                if ($hazard->amount_type == 'percentage') {
                                                    $total_allowances = $total_allowances + ($employee->data->monthly_salary * ($hazard->amount / 100));
                                                } else {
                                                    $total_allowances = $total_allowances + $hazard->amount;
                                                }
                                        @endphp
                                        <tr>
                                            <td class="px-4 py-3 border-b">
                                                @if($employee->data->rata_id)
                                                    {{ count($employee->allowances) + 2 + $loop->iteration }}
                                                @else
                                                    {{ count($employee->allowances) + $loop->iteration }}
                                                @endif
                                            </td>
                                            <td class="px-4 py-3 border-b">{{ $hazard->name }}
                                            </td>
                                            <td class="px-4 py-3 border-b">
                                                @if ($hazard->amount_type == 'percentage')
                                                    {{ number_format($employee->data->monthly_salary * ($hazard->amount / 100), 2) }}
                                                @else
                                                    {{ number_format($hazard->amount, 2) }}
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td class="px-4 py-3 border-b"></td>
                                    <td class="px-4 py-3 border-b"></td>
                                    <td class="px-4 py-3 border-b">Total: {{ number_format($total_allowances, 2) }}
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    @endif

                    {{-- @if ($employee->data->has_holding_tax)
                        <div class="page-break"></div>
                        <h3 class="mt-3"><strong>Holding Tax</strong></h3>
                        
                    @endif --}}
                @endif
                @if ($employee->loans->count() > 0)
                    <div class="page-break"></div> <!-- Page break for printing -->
                    @php
                        // Group loans by loan_id
                        $loansGrouped = $employee->loans->groupBy('loan_id');
                    @endphp

                    @foreach ($loansGrouped as $loanId => $loans)
                        @php
                            $ranges = count($loans) > 1 ? 2 : 1; // Set ranges based on the number of loans with the same ID
                            $total_loan = 0; // Total loan amount for the full duration
                            $loan_name = '';
                            foreach($loans->sortBy('period') as $loan){
                                if(!$loan_name)
                                {
                                    $loan_name = $loan->loan->name;
                                }
                                $total_loan = $total_loan + ($loan->amount * $loan->duration);
                            }
                            $total_amount_paid = 0; // Initialize total amount paid to zero
                        @endphp

                        <table class="min-w-full border mb-3">
                            <thead>
                                <tr>
                                    <th class="px-4 py-4 text-left border-b flex justify-between">
                                        <strong>{{ $loan_name }} -
                                            {{ number_format($total_loan, 2) }}</strong>
                                    </th>
                                    <th class="px-4 py-4 text-left border-b"></th>
                                </tr>
                                <tr>
                                    <th class="px-4 py-4 text-left border-b">Amount</th>
                                    <th class="px-4 py-4 text-left border-b">Date</th>
                                </tr>
                            </thead>


                            <tbody>
                                    @foreach ($loans->sortBy('period') as $loan)
                                        @php
                                        // dd($loans->orderBy('start_date', 'asc'));
                                        @endphp
                                        @foreach (getMonthsFromAttendance($employee)->sortBy('earliest_time_in') as $month)
                                            @if (isBetweenDatesOfLoan($loan, $month->earliest_time_in) && $total_amount_paid < $total_loan)
                                                @php
                                                    // Calculate the payment for the current month based on ranges
                                                    
                                                    $total_amount_paid += $loan->amount; // Update total amount paid
                                                @endphp
                                                <tr>
                                                    <td class="px-4 py-3 border-b">
                                                        {{ number_format($loan->amount, 2) }}</td>
                                                    <td class="px-4 py-3 border-b">
                                                        {{ date('F', strtotime($month->earliest_time_in)) }}/{{ $loan->period }}/{{ date('Y', strtotime($month->earliest_time_in)) }}
                                                    </td>
                                                </tr>
                                            @endif
                                        @endforeach
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td class="px-4 py-3 border-b"></td>
                                        <td class="px-4 py-3 border-b">Balance:
                                            {{ number_format(max(0, $total_loan - $total_amount_paid), 2) }}</td>
                                    </tr>
                                </tfoot>
                            </table>
                    @endforeach
                @endif
            </div>
        </div>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.3/html2pdf.bundle.min.js"
            integrity="sha512-YcsIPGdhPK4P/uRW6/sruonlYj+Q7UHWeKfTAkBW+g83NKM+jMJFJ4iAPfSnVp7BKD4dKMHmVSvICUbE/V1sSw=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script>
            // var employee_name document.getElementById('employee-name');
            // var employee_number document.getElementById('employee-number');
            // employee_name.hide();
            // employee_number.hide();
            function generatePDF(filename, elementId) {
                // if (employee_name.is(":hidden") && employee_number.is(":hidden")) {
                //     employee_name.show();
                //     employee_number.show();
                // }
                console.log(filename);
                var element = document.getElementById(elementId);
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
                        orientation: 'portrait'
                    }
                };

                // New Promise-based usage:
                html2pdf().set(opt).from(element).save();
            }
        </script>
    </div>

</x-app-layout>
