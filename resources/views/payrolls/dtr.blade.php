<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                {{ $employee->full_name }} - {{ $employee->data->category->category_name }}
            </h2>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                 Attendance from {{ date('F', strtotime($payroll['month'])) }} {{ $payroll['date_from_to'] }}, {{ $payroll['year'] }}
            </h2>
    </x-slot>

    <div class="grid grid-cols-6 gap-3 mt-4 ">

        <!-- Department List Card -->
        <a href="#">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h2 class="mb-2 text-lg font-semibold text-center">No. of Times Presents</h2>
                    <!-- Card content here -->
                    <h5 class="text-3xl font-bold text-center">{{ $present }}</h5>
                </div>
            </div>
        </a>
        <a href="#">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h2 class="mb-2 text-lg font-semibold text-center">No. of Times Absents</h2>
                    <!-- Card content here -->
                    <h5 class="text-3xl font-bold text-center">{{ $absent }}</h5>
                </div>
            </div>
        </a>
        <a href="#">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h2 class="mb-2 text-lg font-semibold text-center">No. of Late</h2>
                    <!-- Card content here -->
                    <h5 class="text-3xl font-bold text-center">{{ $late }}</h5>
                </div>
            </div>
        </a>
        <a href="#">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h2 class="mb-2 text-lg font-semibold text-center">No. of Under-time</h2>
                    <!-- Card content here -->
                    <h5 class="text-3xl font-bold text-center">{{ $under_time }}</h5>
                </div>
            </div>
        </a>


    </div>
    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="flex items-center justify-between mx-5 mb-3 space-x-2">
                <div class="relative ">

                </div>
                <div class="relative ">
                    <a href="{{ route('payrolls.index') }}"
                        class="inline-flex items-center px-4 py-2 text-xs font-semibold tracking-widest text-white uppercase transition duration-150 ease-in-out bg-gray-800 border border-transparent rounded-md hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                       Back to Payroll
                    </a>
                </div>
            </div>
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <table class="min-w-full bg-white border">
                        <thead>
                            <tr>
                                <th class="px-4 py-2 border-b text-start">Day</th>
                                <th class="px-4 py-2 border-b text-start">Time In</th>
                                <th class="px-4 py-2 border-b text-start">Time  In status</th>
                                <th class="px-4 py-2 border-b text-start">Interval</th>
                                <th class="px-4 py-2 border-b text-start">Time Out</th>
                                <th class="px-4 py-2 border-b text-start">Time Out status</th>
                                <th class="px-4 py-2 border-b text-start">Interval</th>
                                <th class="px-4 py-2 border-b text-start">Deduction</th>
                                <th class="px-4 py-2 border-b text-start">Salary</th>
                                <th class="px-4 py-2 border-b text-start">Man hours</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($attendances as $attendance)
                                <tr>
                                    <td class="px-4 py-2 border-b">{{ $attendance['day'] }}</td>
                                    <td class="px-4 py-2 border-b">{{ $attendance['time_in'] ? date('h:i A',strtotime($attendance['time_in'])) :'---------' }}</td>
                                    <td class="px-4 py-2 border-b">{{ $attendance['time_in_status'] ?? '---------' }}</td>
                                    <td class="px-4 py-2 border-b">{{ $attendance['time_in_interval'] ? date('h:i A',strtotime($attendance['time_in_interval']))  :'---------' }}</td>
                                    <td class="px-4 py-2 border-b">{{ $attendance['time_out'] ? date('h:i A',strtotime($attendance['time_out']))  :'---------' }}</td>
                                    <td class="px-4 py-2 border-b">{{ $attendance['time_out_status'] ?? '---------' }}</td>
                                    <td class="px-4 py-2 border-b">{{ $attendance['time_out_interval'] ? date('h:i A',strtotime($attendance['time_out_interval'])) :'---------' }}</td>
                                    <td class="px-4 py-2 border-b">{{ $attendance['deduction']  ?? '---------' }}</td>
                                    <td class="px-4 py-2 border-b">{{ $attendance['total_salary']  ?? '---------' }}</td>
                                    <td class="px-4 py-2 border-b">{{ $attendance['manhours']  ?? '---------' }}</td>
                                </tr>
                            @endforeach
                            <tr>
                                <td class="px-4 py-2 border-b text-end" colspan="7">
                                    <span class="font-bold">
                                        Total Man Hours:
                                    </span>
                                     {{ $total_man_hour }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
