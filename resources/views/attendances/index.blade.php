<x-app-layout>
    <x-slot name="header">
        <h1 class="text-xl font-semibold leading-tight text-gray-800">
            Attendance List
        </h1>
    </x-slot>

    <div class="p-5 mx-auto mt-8 bg-white rounded-md shadow max-w-7xl">

        <div class="flex items-center justify-between mb-3">
            <div>

            </div>
            <div class="flex items-center space-x-2">
                <div class="relative">
                    {{-- reset button --}}
                    <a href="{{ route('attendances.index') }}"
                        class="inline-flex items-center px-4 py-2 text-xs font-semibold tracking-widest text-white uppercase transition duration-150 ease-in-out bg-gray-800 border border-transparent rounded-md hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                        Reset
                    </a>
                </div>
                <div class="relative">
                    <x-dropdown align="left" width="w-full">
                        <x-slot name="trigger">
                            <button
                                class="w-full px-4 py-2 text-left bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring focus:border-blue-300">
                                Select a Department
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            @foreach ($departments as $department)
                                <x-dropdown-link :href="route('attendances.index', [
                                    'filter_by' => 'department',
                                    'filter_id' => $department->id,
                                ])">
                                    {{ $department->dep_name }}
                                </x-dropdown-link>
                            @endforeach
                        </x-slot>
                    </x-dropdown>
                </div>
            </div>
        </div>
        <table class="min-w-full border data-table">
            <thead>
                <tr>
                    <th class="px-4 py-2 text-left border-b">#</th>
                    <th class="px-4 py-2 text-left border-b">Employee</th>
                    <th class="px-4 py-2 text-left border-b">Time In</th>
                    <th class="px-4 py-2 text-left border-b">Late</th>
                    <th class="px-4 py-2 text-left border-b">Time In Picture</th>
                    <th class="px-4 py-2 text-left border-b">Status</th>
                    <th class="px-4 py-2 border-b ext-left">Time Out</th>
                    <th class="px-4 py-2 text-left border-b">Time Out Picture</th>
                    <th class="px-4 py-2 text-left border-b">Status</th>
                    {{-- <th class="px-4 py-2 text-left border-b">Action</th> --}}
                </tr>
            </thead>
            <tbody>
                @foreach ($attendances as $attendance)
                    <tr>
                        <td class="px-4 py-2 border-b">{{ $loop->iteration }}</td>
                        <td class="px-4 py-2 border-b">{{ $attendance->employee->full_name }}</td>
                        <td class="px-4 py-2 border-b">
                            {{--
                                intervals
                                7:00am - 7:10am = 7:00am,

                                7:11am - 7:40 = 7:30am,

                                7:41am - 8:10am = 8:00am,
                                --}}
                            @php
                                $timeIn = \Carbon\Carbon::parse($attendance->time_in);
                            @endphp

                            {{-- Check if $timeIn is 7:00am - 7:10am --}}
                            @if ($timeIn->between(\Carbon\Carbon::parse('7:00'), \Carbon\Carbon::parse('7:10')))
                                7:00 AM
                            @elseif ($timeIn->between(\Carbon\Carbon::parse('7:11'), \Carbon\Carbon::parse('7:40')))
                                7:30 AM
                            @elseif ($timeIn->between(\Carbon\Carbon::parse('7:41'), \Carbon\Carbon::parse('8:10')))
                                8:00 AM
                            @else
                                {{ $timeIn->format('h:i A') }}
                            @endif
                        </td>
                        <td class="px-4 py-2 border-b">
                            {{-- check if late --}}
                            @if ($attendance->time_in_status == 'Late')
                                @php
                                    $timeIn = \Carbon\Carbon::parse($attendance->time_in);
                                    $now = \Carbon\Carbon::parse('08:00:00');
                                    $late = $now->diffInMinutes($timeIn);
                                @endphp
                                {{-- @if ($late >= 60)
                                    {{ floor($late / 60) }} hr {{ $late % 60 }} mins
                                @else
                                @endif --}}
                                {{ $late }} mins
                            @endif
                        </td>
                        <td class="px-4 py-2 border-b">
                            <img src="storage/{{ $attendance->time_in_image }}" alt="" loading="lazy"
                                style="height:70px; width:70px">
                        </td>
                        <td class="px-4 py-2 border-b">{{ $attendance->time_in_status }}</td>

                        <td class="px-4 py-2 border-b">
                            @if ($attendance->time_out)
                                @php
                                    $timeOut = \Carbon\Carbon::parse($attendance->time_out);
                                @endphp

                                {{-- Check if $timeOut is 7:00am - 7:10am --}}
                                @if ($timeOut->between(\Carbon\Carbon::parse('15:00'), \Carbon\Carbon::parse('15:10')))
                                    3:00 PM
                                @elseif ($timeOut->between(\Carbon\Carbon::parse('15:11'), \Carbon\Carbon::parse('15:40')))
                                    3:30 PM
                                @elseif ($timeOut->between(\Carbon\Carbon::parse('15:41'), \Carbon\Carbon::parse('16:10')))
                                    4:00 PM
                                @elseif ($timeOut->between(\Carbon\Carbon::parse('16:11'), \Carbon\Carbon::parse('16:40')))
                                    3:30 PM
                                @else
                                    {{ $timeOut->format('h:i A') }}
                                @endif
                            @endif
                        </td>
                        <td class="px-4 py-2 border-b">
                            @if ($attendance->time_out)
                                <img src="storage/{{ $attendance->time_out_image }}" alt="" loading="lazy"
                                    style="height:70px; width:70px">
                            @endif
                        </td>
                        <td class="px-4 py-2 border-b">{{ $attendance->time_out_status }}</td>
                @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout>
