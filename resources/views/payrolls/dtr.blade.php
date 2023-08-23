<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                {{ $employee->name }} - Attendance
            </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <table class="min-w-full bg-white border data-table">
                        <thead>
                            <tr>
                                <th class="px-4 py-2 text-left border-b">#</th>
                                <th class="px-4 py-2 text-left border-b">Date</th>
                                <th class="px-4 py-2 text-left border-b">Time In</th>
                                <th class="px-4 py-2 border-b">Time Out</th>
                                <th class="px-4 py-2 text-left border-b">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($attendances as $attendance)
                                <tr>
                                    <td class="px-4 py-2 border-b">{{ $loop->iteration }}</td>
                                    <td class="px-4 py-2 border-b">{{ date('F d,Y', strtotime($attendance->created_at)) }}</td>
                                    <td class="px-4 py-2 border-b">
                                        {{ date('h:i:s A', strtotime($attendance->time_in)) }}</td>
                                    <td class="px-4 py-2 border-b">
                                        {{ $attendance->time_out ? date('h:i:s A', strtotime($attendance->time_out)) : '' }}
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
