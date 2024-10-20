<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Attendance History - {{ date('F d, Y', strtotime($date)) }}
            </h2>

    </x-slot>

    <div class="p-5 mx-auto mt-8 bg-white rounded-md shadow max-w-7xl">

        <div class="flex items-center justify-between mb-3">
            <div>

            </div>
            <div class="flex items-center space-x-2">
                <div class="relative">
                    <a href="{{ route('attendances-history.index') }}"
                        class="inline-flex items-center px-4 py-2 text-xs font-semibold tracking-widest text-white uppercase transition duration-150 ease-in-out bg-gray-800 border border-transparent rounded-md hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                        Back to Attendance History
                    </a>
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
                    <th class="px-4 py-2 text-left border-b">Status</th>
                    <th class="px-4 py-2 border-b ext-left">Time Out</th>
                    <th class="px-4 py-2 text-left border-b">Status</th>
                    <th class="px-4 py-2 text-left border-b">Hours Worked</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($attendances as $attendance)
                    <tr>
                        <td class="px-4 py-2 border-b">{{ $loop->iteration }}</td>
                        <td class="px-4 py-2 border-b">{{ $attendance->employee->full_name }}</td>
                        <td class="px-4 py-2 border-b">
                            {{ date('h:i A', strtotime($attendance->time_in)) }}
                        </td>
                        <td class="px-4 py-2 border-b">
                            {{-- check if late --}}
                            @if ($attendance->time_in_status == 'Late' || $attendance->time_in_status == 'Half-Day')
                                {{ getLate($attendance->time_in, true) }}
                            @endif
                        </td>
                        <td class="px-4 py-2 border-b">{{ $attendance->time_in_status }}</td>

                        <td class="px-4 py-2 border-b">
                            @if ($attendance->time_out)
                                {{ date('h:i A', strtotime($attendance->time_out)) }}
                            @endif
                        </td>
                        <td class="px-4 py-2 border-b">{{ $attendance->time_out_status }}</td>
                        <td class="px-4 py-2 border-b">{{ $attendance->hours }}</td>
                @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout>
