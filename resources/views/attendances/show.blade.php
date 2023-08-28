<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Attendance History - {{ date('F d, Y', strtotime($date))}}
            </h2>
            <a href="{{ route('attendances-history.index') }}"
            class="inline-flex items-center px-4 py-2 text-xs font-semibold tracking-widest text-white uppercase transition duration-150 ease-in-out bg-gray-800 border border-transparent rounded-md hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
            Back
        </a>
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
        <a href="{{ route('attendances-history.index') }}">
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
                    <table class="min-w-full bg-white border data-table">
                        <thead>
                            <tr>
                                <th class="px-4 py-2 text-left border-b">#</th>
                                <th class="px-4 py-2 text-left border-b">Employee</th>
                                <th class="px-4 py-2 text-left border-b">Time In</th>
                                <th class="px-4 py-2 border-b">Time Out</th>
                                <th class="px-4 py-2 border-b">Minute Late</th>
                                <th class="px-4 py-2 border-b">Hours Worked</th>
                                <th class="px-4 py-2 text-left border-b">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                // parse the date and add 5pm for default time out and 8:30am for late
                                $defaultTimeOut = \Carbon\Carbon::parse($date)->addHours(17);
                                $lateThreshold = \Carbon\Carbon::parse($date)->addHours(8)->addMinutes(30);
                            @endphp
                            @foreach ($attendances as $attendance)
                                <tr>
                                    <td class="px-4 py-2 border-b">{{ $loop->iteration }}</td>
                                    <td class="px-4 py-2 border-b">{{ $attendance->employee->name }}</td>
                                    <td class="px-4 py-2 border-b">
                                        {{ date('h:i:s A', strtotime($attendance->time_in)) }}</td>
                                    <td class="px-4 py-2 border-b">
                                        {{ $attendance->time_out ? date('h:i:s A', strtotime($attendance->time_out)) : '' }}
                                    </td>

                                    <td class="px-4 py-2 border-b">
                                        @php
                                            $late = $lateThreshold->diffInMinutes($attendance->time_in);
                                        @endphp
                                        {{ $attendance->time_in > $lateThreshold ? $late . ' Minutes' : '' }}
                                    </td>
                                    <td class="px-4 py-2 border-b">
                                        @php
                                            $attendanceTimeIn = \Carbon\Carbon::parse($attendance->time_in);
                                            $hoursWorked = $attendanceTimeIn->diffInHours($defaultTimeOut);
                                        @endphp
                                        {{ $hoursWorked > 0 ? $hoursWorked . ' Hours' : '' }}
                                    </td>
                                    <td class="px-4 py-2 border-b">{{ $attendance->status }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
