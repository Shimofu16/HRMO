<div>
    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8 flex justify-between items-center">
            <div>
                <div class="grid grid-cols-{{ count(getColor(null, true)) }} gap-1 mt-4 px-3">
                    @foreach (getColor(null, true) as $name => $color)
                        <a href="#">
                            <div style="background-color: {{ $color }}" class="text-white px-2 py-5 rounded-md flex justify-center items-center h-full">
                                <h4 class="font-semibold text-sm">
                                    {{ Str::ucfirst(Str::replaceFirst('_', ' ', $name)) }}
                                </h4>
                            </div>
                        </a>

                    @endforeach



                </div>
            </div>
            <div class="flex">
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
            </div>
        </div>
    </div>
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
                    <a href="{{ route('employees.index') }}"
                        class="inline-flex items-center px-4 py-2 text-xs font-semibold tracking-widest text-white uppercase transition duration-150 ease-in-out bg-gray-800 border border-transparent rounded-md hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                        Back to Employee List
                    </a>
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
                                <th class="px-4 py-2 border-b text-start">Interval</th>
                                <th class="px-4 py-2 border-b text-start">Time Out</th>
                                @if ($debugMode)
                                    <th class="px-4 py-2 border-b text-start">Time Out status</th>
                                @endif
                                <th class="px-4 py-2 border-b text-start">Interval</th>
                                <th class="px-4 py-2 border-b text-start">Deduction</th>
                                @if ($debugMode)
                                    <th class="px-4 py-2 border-b text-start">Salary</th>
                                @endif
                                <th class="px-4 py-2 border-b text-start">Man hours</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($attendances as $attendance)
                                <tr style="background-color:{{ $attendance['color'] }}"  class="{{  ($attendance['color']) ? 'text-white' : '' ; }}">
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
                                        {{ $attendance['time_in_interval'] ? date('h:i A', strtotime($attendance['time_in_interval'])) : '---------' }}
                                    </td>
                                    <td class="px-4 py-2 border-b">
                                        {{ $attendance['time_out'] ? date('h:i A', strtotime($attendance['time_out'])) : '---------' }}
                                    </td>
                                    @if ($debugMode)
                                        <td class="px-4 py-2 border-b">
                                            {{ $attendance['time_out_status'] ?? '---------' }}
                                        </td>
                                    @endif
                                    <td class="px-4 py-2 border-b">
                                        {{ $attendance['time_out_interval'] ? date('h:i A', strtotime($attendance['time_out_interval'])) : '---------' }}
                                    </td>
                                    <td class="px-4 py-2 border-b">{{ $attendance['deduction'] ?? '---------' }}</td>
                                    @if ($debugMode)
                                        <td class="px-4 py-2 border-b">
                                            {{ $attendance['total_salary'] ?? '---------' }}
                                        </td>
                                    @endif
                                    <td class="px-4 py-2 border-b">{{ $attendance['manhours'] ?? '---------' }}</td>
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
