<div>
    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8 flex flex-col justify-between items-center">
            <div class="flex">
                <div class="mr-2">
                    <label for="dtr" class="block font-medium text-gray-700">DTR Type</label>
                    <select name="dtr" id="dtr" wire:model.live='dtr_type'
                        class="block w-full mt-1 rounded form-select">
                        <option value="">--Please select here--</option>
                        <option value="15" {{ $isMonthly ? '' : 'selected' }}>
                            15 Days
                        </option>
                        <option value="monthly" {{ $isMonthly ? 'selected' : '' }}>
                            Monthly
                        </option>
                    </select>
                </div>
                <div class="mr-2">
                    <label for="selected_month" class="block font-medium text-gray-700">Month</label>
                    <select name="selected_month" id="selected_month" wire:model.live='selected_month'
                        class="block w-full mt-1 rounded form-select">
                        <option value="" selected>--Please select here--</option>
                        @foreach ($months as $month_value)
                            <option value="{{ $month_value->earliest_time_in }}">
                                {{ date('F', strtotime($month_value->earliest_time_in)) }}</option>
                        @endforeach
                    </select>
                </div>
                @if (!$isMonthly)
                    <div>
                        <label for="selected_days" class="block font-medium text-gray-700">Days</label>
                        <select name="selected_days" id="selected_days" wire:model.live='selected_days'
                            class="block w-full mt-1 rounded form-select">
                            <option value="" selected>--Please select here--</option>
                            @foreach ($days as $day_value)
                                <option value="{{ $day_value }}">{{ $day_value }}</option>
                            @endforeach
                        </select>
                    </div>
                @endif
            </div>
            <div>
                <div class="grid grid-cols-{{ count(getColor(null, true)) }} gap-1 mt-4 px-3">
                    @foreach (getColor(null, true) as $name => $color)
                        <a href="#">
                            <div style="background-color: {{ $color }}"
                                class="text-white px-2 py-5 rounded-md flex justify-center items-center h-full">
                                <h4 class="font-semibold text-sm">
                                    {{ Str::ucfirst(Str::replaceFirst('_', ' ', $name)) }}
                                </h4>
                            </div>
                        </a>
                    @endforeach



                </div>
            </div>

        </div>
    </div>
    @if ($isMonthly)
        <div class="flex justify-center items-center bg-white border-b shadow-sm sm:rounded-lg w-fit px-5 py-3">
            <div id="element-to-print">
                <div class="grid grid-cols-2 gap-2">
                    <div class="flex flex-col">
                        <div class="mb-6">
                            <h2 class="text-sm font-bold text-center">DAILY TIME RECORD</h2>
                            <p class="text-xs mt-3">Name:
                                <span class="font-bold">
                                    {{ $employee->full_name }}
                                </span>
                            </p>
                            <p class="border-t border-black ms-8 me-20 text-[11px]"></p>
                            <p class="text-xs mt-3">For the month of
                                <span class="font-bold">
                                    {{ Str::upper(date('F', strtotime($selected_month))) }}
                                </span>
                            </p>
                            <p class="border-t border-black ms-24 me-20 text-[11px]"></p>
                            <p class="text-xs text-center">Official hours for arrival and departure</p>
                        </div>
                        <table class="border border-black w-full">
                            <thead>
                                <tr>
                                    <th class="border border-black px-3 py-2"></th>
                                    <th class="border border-black px-3 py-2 text-xs" colspan="2">Time </th>
                                    <th class="border border-black px-3 py-2 text-xs" colspan="2">Under-time</th>
                                </tr>
                                <tr>
                                    <th class="border border-black px-3 py-2 text-xs">Day</th>
                                    <th class="border border-black px-3 py-2 text-xs"> In</th>
                                    <th class="border border-black px-3 py-2 text-xs"> Out</th>
                                    <th class="border border-black px-3 py-2 text-xs">Hours</th>
                                    <th class="border border-black px-3 py-2 text-xs">Minutes</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($attendances as $attendance)
                                    <tr style="background-color:{{ $attendance['color'] }}" class="{{ $attendance['color'] ? 'text-white' : '' }}">
                                        <td class="border border-black text-center py-2 text-[10px]">{{  $attendance['day'] }}</td>
                                        <td class="border border-black text-center py-2 text-[10px]">{{ $attendance['time_in'] ? date('h:i A', strtotime($attendance['time_in'])) : '---------' }}</td>
                                        <td class="border border-black text-center py-2 text-[10px]">{{ $attendance['time_out'] ? date('h:i A', strtotime($attendance['time_out'])) : '---------' }}</td>
                                        <td class="border border-black text-center py-2 text-[10px]">
                                            {{ $attendance['under_time_hours'] != 0 ?  "{$attendance['under_time_hours']} Hrs" : '---------' }}
                                        </td>
                                        <td class="border border-black text-center py-2 text-[10px]">
                                            {{ $attendance['under_time_minutes'] != 0 ? "{$attendance['under_time_minutes']} Mins" : '---------' }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="3" class="border border-black px-3 text-xs">
                                        <div class="flex justify-between items-center">
                                            <span>
                                                TOTAL
                                            </span>
                                            <span>{{ $total_man_hour }} Hrs</span>
                                        </div>
                                    </td>

                                    <td  class="border border-black px-3 text-xs text-center">
                                        {{ $totalUnderTimeHours }} Hrs
                                    </td>
                                    <td  class="border border-black px-3 text-xs text-center">
                                        {{ $totalUnderTimeMinutes }} Mins
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <div class="flex flex-col">
                        <div class="mb-4 flex justify-center items-center">
                            <div class="flex justify-center items-center">
                                <img src="{{ asset('assets/images/cl-logo.png') }}" alt="cl logo" style="height: 70px; width:70px;">
                                <div class="flex flex-col text-center">
                                    <h1 class="text-xs">Republic of the Philippines</h1>
                                    <h1 class="text-xs">Province of Laguna</h1>
                                    <h1 class="text-xs">Municipality of Calauan</h1>
                                </div>
                                <img src="{{ asset('assets/images/cl-pnp-logo.png') }}" alt="cl pnp logo" style="height: 70px; width:70px;">
                            </div>

                        </div>
                        <div class="mb-3">
                            <h2 class="text-sm font-bold text-center">ACCOMPLISHMENT REPORT</h2>
                        </div>
                        <table class="border border-black w-full">
                            <thead>
                                <tr>
                                    <th class="border border-black px-3 py-2">Date</th>
                                    <th class="border border-black px-3 py-2 text-xs" colspan="4">Accomplishment </th>
                                </tr>

                            </thead>
                            <tbody>
                                @for ($i = 1; $i <= 16; $i++)
                                    <tr >
                                        <td class="border border-black text-center py-8" ></td>
                                        <td class="border border-black text-center py-8" colspan="4"></td>

                                    </tr>
                                @endfor

                            </tbody>

                        </table>
                    </div>
                </div>

                <div class="mt-6 ">
                    <p class="my-6 indent-5 text-wrap break-all text-xs ">
                        I CERTIFY on my honor that the above is a true and correct report of the
                        hours of work performed, record of which was made daily at the time of arrival at and
                        departure from office.
                    </p>
                   <div class="flex justify-between items-center mt-3">
                        <p class="text-xs font-bold border-t border-black">Employee Name</p>
                        <p class="text-xs font-bold border-t border-black">Name and signature of immediate suppervisior</p>
                   </div>

                </div>
            </div>
        </div>
    @else
        <div id="element-to-print" class="">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="grid grid-cols-6 grid-rows-1 gap-3">

                    <!-- Department List Card -->
                    <a href="#">
                        <div class="overflow-hidden bg-white border-b shadow-sm sm:rounded-lg h-full">
                            <div class="p-6   border-gray-200">
                                <h2 class="mb-2 text-lg font-semibold text-center">No. of Times Presents</h2>
                                <!-- Card content here -->
                                <h5 class="text-3xl font-bold text-center">{{ $present }}</h5>
                            </div>
                        </div>
                    </a>
                    <a href="#">
                        <div class="overflow-hidden bg-white border-b shadow-sm sm:rounded-lg h-full">
                            <div class="p-6   border-gray-200">
                                <h2 class="mb-2 text-lg font-semibold text-center">No. of Times Absents</h2>
                                <!-- Card content here -->
                                <h5 class="text-3xl font-bold text-center">{{ $absent }}</h5>
                            </div>
                        </div>
                    </a>
                    <a href="#">
                        <div class="overflow-hidden bg-white border-b shadow-sm sm:rounded-lg h-full">
                            <div class="p-6   border-gray-200">
                                <h2 class="mb-2 text-lg font-semibold text-center">No. of Late</h2>
                                <!-- Card content here -->
                                <h5 class="text-3xl font-bold text-center">{{ $late }}</h5>
                            </div>
                        </div>
                    </a>
                    <a href="#">
                        <div class="overflow-hidden bg-white border-b shadow-sm sm:rounded-lg h-full">
                            <div class="p-6   border-gray-200">
                                <h2 class="mb-2 text-lg font-semibold text-center">No. Halfday</h2>
                                <!-- Card content here -->
                                <h5 class="text-3xl font-bold text-center">{{ $halfday }}</h5>
                            </div>
                        </div>
                    </a>
                    <a href="#">
                        <div class="overflow-hidden bg-white border-b shadow-sm sm:rounded-lg h-full">
                            <div class="p-6   border-gray-200">
                                <h2 class="mb-2 text-lg font-semibold text-center">No. of Under-time</h2>
                                <!-- Card content here -->
                                <h5 class="text-3xl font-bold text-center">{{ $under_time }}</h5>
                            </div>
                        </div>
                    </a>


                </div>
            </div>
            <div class="py-12">
                <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                    <div class="flex items-center justify-between mx-5 mb-3 space-x-2">
                        <div class="relative ">

                        </div>
                        <div class="relative ">
                            {{-- <a href="{{ route('employees.index') }}"
                                class="inline-flex items-center px-4 py-2 text-xs font-semibold tracking-widest text-white uppercase transition duration-150 ease-in-out bg-gray-800 border border-transparent rounded-md hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                                Back to Employee List
                            </a> --}}
                        </div>
                    </div>
                    <div class="overflow-hidden bg-white border-b shadow-sm sm:rounded-lg">
                        <div class="p-6   border-gray-200">
                            <table class="min-w-full bg-white border">
                                <thead>
                                    <tr>
                                        <th class="px-4 py-2 border-b text-start">Day</th>
                                        <th class="px-4 py-2 border-b text-start">Time In</th>
                                        @if ($debugMode)
                                            <th class="px-4 py-2 border-b text-start">Time In status</th>
                                        @endif
                                        <th class="px-4 py-2 border-b text-start">Time Out</th>
                                        @if ($debugMode)
                                            <th class="px-4 py-2 border-b text-start">Time Out status</th>
                                        @endif
                                        <th class="px-4 py-2 border-b text-start">Deduction</th>
                                        @if ($debugMode)
                                            <th class="px-4 py-2 border-b text-start">Salary</th>
                                        @endif
                                        <th class="px-4 py-2 border-b text-start">Man hours</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($attendances as $attendance)
                                        <tr style="background-color:{{ $attendance['color'] }}"
                                            class="{{ $attendance['color'] ? 'text-white' : '' }}">
                                            <td class="px-4 py-2 border-b">{{ $attendance['day'] }}</td>
                                            <td class="px-4 py-2 border-b">
                                                {{ $attendance['time_in'] ? date('h:i A', strtotime($attendance['time_in'])) : '---------' }}
                                            </td>
                                            @if ($debugMode)
                                                <td class="px-4 py-2 border-b">
                                                    {{ $attendance['time_in_status'] ?? '---------' }}
                                                </td>
                                            @endif

                                            <td class="px-4 py-2 border-b">
                                                {{ $attendance['time_out'] ? date('h:i A', strtotime($attendance['time_out'])) : '---------' }}
                                            </td>
                                            @if ($debugMode)
                                                <td class="px-4 py-2 border-b">
                                                    {{ $attendance['time_out_status'] ?? '---------' }}
                                                </td>
                                            @endif
                                            <td class="px-4 py-2 border-b">
                                                {{ $attendance['deduction'] ?? '---------' }}
                                            </td>
                                            @if ($debugMode)
                                                <td class="px-4 py-2 border-b">
                                                    {{ $attendance['total_salary'] ?? '---------' }}
                                                </td>
                                            @endif
                                            <td class="px-4 py-2 border-b">
                                                {{ $attendance['manhours'] ?? '---------' }}
                                            </td>
                                        </tr>
                                    @endforeach
                                    <tr>
                                        <td class="px-4 py-2 border-b text-end" colspan="7">
                                            <span class="font-bold">
                                                Total Man Hours:
                                            </span>
                                            {{ $total_man_hour }}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
</div>
