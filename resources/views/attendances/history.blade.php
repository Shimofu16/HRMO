<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Attendance History') }}
            </h2>
            <div class="relative inline-flex">
                <div class="max-w-sm mx-auto flex">
                    <div class="relative mr-2">
                        <x-dropdown align="left" width="w-full">
                            <x-slot name="trigger">
                                <button
                                    class="w-full bg-white border border-gray-300 px-4 py-2 rounded-md shadow-sm focus:outline-none focus:ring focus:border-blue-300 text-left">
                                    Select a Month
                                </button>
                            </x-slot>

                            <x-slot name="content">
                                @foreach ($months as $month)
                                    @php
                                        $monthName = \Carbon\Carbon::createFromDate(null, $month)->monthName;
                                    @endphp
                                    <x-dropdown-link :href="route('attendances-history.index', [
                                        'filter_by' => 'month',
                                        'filter' => $monthName,
                                    ])">
                                        {{ $monthName }}
                                    </x-dropdown-link>
                                @endforeach
                            </x-slot>
                        </x-dropdown>
                    </div>
                    <div class="relative">
                        <x-dropdown align="left" width="w-full">
                            <x-slot name="trigger">
                                <button
                                    class="w-full bg-white border border-gray-300 px-4 py-2 rounded-md shadow-sm focus:outline-none focus:ring focus:border-blue-300 text-left">
                                    Select a Year
                                </button>
                            </x-slot>

                            <x-slot name="content">
                                @foreach ($years as $year)
                                    <x-dropdown-link :href="route('attendances-history.index', [
                                        'filter_by' => 'year',
                                        'filter' => $year,
                                    ])">
                                        {{ $year }}
                                    </x-dropdown-link>
                                @endforeach
                            </x-slot>
                        </x-dropdown>
                    </div>

                </div>
            </div>


    </x-slot>
    <div class="grid grid-cols-1 gap-3 mt-4 md:grid-cols-2 xl:grid-cols-6">

        <!-- Department List Card -->
        <a href="{{ route('attendances.index') }}">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h2 class="mb-2 text-lg font-semibold text-center">Attendance List</h2>
                    <!-- Card content here -->
                </div>
            </div>
        </a>

        <!-- Position List Card -->
        <a
            href="{{ route('attendances-history.index', [
                'filter_by' => 'year',
                'year' => date('Y'),
            ]) }}">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h2 class="mb-2 text-lg font-semibold text-center">Attendance History</h2>
                    <!-- Card content here -->
                </div>
            </div>
        </a>
    </div>
    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <table class="min-w-full border bg-white data-table">
                        <thead>
                            <tr>
                                <th class="border-b px-4 py-2 text-left">#</th>
                                <th class="border-b px-4 py-2 text-left">Employee</th>
                                <th class="border-b px-4 py-2 text-left">Time In</th>
                                <th class="border-b px-4 py-2">Time Out</th>
                                <th class="border-b px-4 py-2">Minute Late</th>
                                <th class="border-b px-4 py-2">Hours Worked</th>
                                <th class="border-b px-4 py-2 text-left">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $defaultTimeIn = \Carbon\Carbon::createFromFormat('H:i:s', '08:00:00');
                                $defaultTimeOut = \Carbon\Carbon::createFromFormat('H:i:s', '17:00:00');
                                $lateThreshold = \Carbon\Carbon::createFromFormat('H:i:s', '08:10:00');
                            @endphp
                            @foreach ($attendances as $attendance)
                                <tr>
                                    <td class="border-b px-4 py-2">{{ $loop->iteration }}</td>
                                    <td class="border-b px-4 py-2">{{ $attendance->employee->name }}</td>
                                    <td class="border-b px-4 py-2">
                                        {{ date('h:i:s A', strtotime($attendance->time_in)) }}</td>
                                    <td class="border-b px-4 py-2">
                                        {{ $attendance->time_out ? date('h:i:s A', strtotime($attendance->time_out)) : '' }}
                                    </td>

                                    <td class="border-b px-4 py-2">
                                        @php
                                            $late = $lateThreshold->diffInMinutes($attendance->time_in);
                                        @endphp
                                        {{ $attendance->time_in > $lateThreshold ? $late . ' Minutes' : '' }}
                                    </td>
                                    <td class="border-b px-4 py-2">
                                        @php
                                            $attendanceTimeIn = \Carbon\Carbon::parse($attendance->time_in);
                                            $hoursWorked = $attendanceTimeIn->diffInHours($defaultTimeOut);
                                        @endphp
                                        {{ $hoursWorked > 0 ? $hoursWorked . ' Hours' : '' }}
                                    </td>
                                    <td class="border-b px-4 py-2">{{ $attendance->status }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
