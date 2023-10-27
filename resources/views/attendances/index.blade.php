<x-app-layout>
    <x-slot name="header">
        <h1 class="text-xl font-semibold leading-tight text-gray-800">
            Attendance List
        </h1>
    </x-slot>


    <div class="grid grid-cols-1 gap-3 mt-4 md:grid-cols-2 xl:grid-cols-6">

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


    <div class="py-12 ">
        <div class="mx-auto bg-white max-w-7xl sm:p-6 lg:p-8">
            <div class="flex items-center justify-between mb-3">
                <div class="buttons">

                </div>
                <div class="flex items-center space-x-2">
                    <div class="relative">
                        {{-- reset button --}}
                        <a href="{{ route('attendances.index') }}"
                            class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            Reset
                        </a>

                    </div>
                    <div class="relative">
                        <x-dropdown align="left" width="w-full">
                            <x-slot name="trigger">
                                <button
                                    class="w-full bg-white border border-gray-300 px-4 py-2 rounded-md shadow-sm focus:outline-none focus:ring focus:border-blue-300 text-left">
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

                    {{-- <div class="relative">
                        <x-dropdown align="left" width="w-full">
                            <x-slot name="trigger">
                                <button
                                    class="w-full bg-white border border-gray-300 px-4 py-2 rounded-md shadow-sm focus:outline-none focus:ring focus:border-blue-300 text-left">
                                    Select a Category
                                </button>
                            </x-slot>

                            <x-slot name="content">
                                @foreach ($categories as $category)
                                    <x-dropdown-link :href="route('employees.index', [
                                        'filter_by' => 'category',
                                        'filter_id' => $category->id,
                                    ])">
                                        {{ $category->category_name }}
                                    </x-dropdown-link>
                                @endforeach
                            </x-slot>
                        </x-dropdown>
                    </div> --}}
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
                        <th class="px-4 py-2 ext-left border-b">Time Out</th>
                        <th class="px-4 py-2 text-left border-b">Status</th>
                        {{-- <th class="px-4 py-2 text-left border-b">Action</th> --}}
                    </tr>
                </thead>
                <tbody>
                    @foreach ($attendances as $attendance)
                        <tr>
                            <td class="px-4 py-2 border-b">{{ $loop->iteration }}</td>
                            <td class="px-4 py-2 border-b">{{ $attendance->employee->name }}</td>
                            <td class="px-4 py-2 border-b">
                                {{-- 
                                    intervals
                                    7:00am - 7:10am = 7:00am,

                                    7:11am - 7:40 = 7:30am,

                                    7:41am - 8:10am = 8:00am,
                                    --}}
                                @php
                                    
                                    $now = \Carbon\Carbon::now('Asia/Manila')->parse('7:00');
                                    $timeIn = \Carbon\Carbon::parse($attendance->time_in);
                                @endphp
                                {{-- check if $now is 7:00am - 7:10am  --}}
                                @if ($now->between($timeIn->copy()->subMinutes(10), $timeIn->copy()->addMinutes(10)))
                                    7:00 AM
                                @endif
                                {{-- check if $now is 7:11am - 7:40am  --}}
                                @if ($now->between($timeIn->copy()->addMinutes(11), $timeIn->copy()->addMinutes(40)))
                                    7:30 AM
                                @endif
                                {{-- check if $now is 7:41am - 8:10am  --}}
                                @if ($now->between($timeIn->copy()->addMinutes(41), $timeIn->copy()->addMinutes(70)))
                                    8:00 AM
                                @endif
                            </td>
                            <td class="px-4 py-2 border-b">
                                {{-- check if late --}}
                                @if ($attendance->time_in_status == 'Late')
                                    @php
                                        $timeIn = \Carbon\Carbon::parse($attendance->time_in);
                                        $now = \Carbon\Carbon::now('Asia/Manila');
                                        $late = $now->diffInMinutes($timeIn);
                                    @endphp
                                    @if ($late >= 60)
                                        {{ floor($late / 60) }} hr {{ $late % 60 }} mins
                                    @else
                                        {{ $late }} mins
                                    @endif
                                @endif
                            </td>
                            <td class="px-4 py-2 border-b">{{ $attendance->time_in_status }}</td>

                            <td class="px-4 py-2 border-b">
                                {{ $attendance->time_out ? date('h:i:s A', strtotime($attendance->time_out)) : '' }}
                            </td>
                            <td class="px-4 py-2 border-b">{{ $attendance->time_out_status }}</td>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    {{-- <script src="{{ asset('assets/webcam/webcam.min.js') }}"></script> --}}


    {{-- <script language="JavaScript">
        Webcam.set({
            width: 300,
            height: 300,
            image_format: 'jpeg',
            jpeg_quality: 90
        });

        Webcam.attach('#my_camera');

        function take_snapshot(isTimeIn, id) {
            Webcam.snap(function(data_uri, isTimeIn) {
                // Update all image tags with the same image URI
                const imageTagElements = document.querySelectorAll('.image-tag');
                imageTagElements.forEach(function(imageTag) {
                    imageTag.value = data_uri;
                });
                document.getElementById('results').innerHTML = '<img src="' + data_uri + '"/>';
                //hide camera
                Webcam.reset();
                document.querySelector('#my_camera').style.display = 'none';

            });
            // submit the form
            if (isTimeIn) {
                document.querySelector('#timeIn').submit();
            } else {
                document.querySelector('#timeOut' + id).submit();
            }
        }
    </script> --}}
</x-app-layout>
