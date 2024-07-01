<x-app-layout>
    <x-slot name="header">
        <h1 class="text-xl font-semibold leading-tight text-gray-800">
            Attendance List
        </h1>
    </x-slot>
    @include('attendances._header')

    <div class="p-5 mx-auto mt-8 bg-white rounded-md shadow max-w-7xl">

        <div class="flex items-center justify-between mb-3">
            <div>

            </div>
            <div class="flex items-center space-x-2">
                <div class="relative">
                    {{-- reset button --}}
                    <button href="{{ route('update.attendances.bio') }}"
                    onclick="window.dispatchEvent(new CustomEvent('open-modal', { detail: 'uploadAttendance' }))"
                        class="inline-flex items-center px-4 py-2 text-xs font-semibold tracking-widest text-white uppercase transition duration-150 ease-in-out bg-gray-800 border border-transparent rounded-md hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                        Upload Attendance
                    </button>
                    <x-modal name="uploadAttendance" maxWidth="lg" headerTitle="Upload Attendance">

                        <form action="{{ route('attendances.upload') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <!-- Modal body -->
                            <div class="p-4 md:p-5 space-y-4">
                                <div class="grid grid-cols-12 gap-6 mb-3">
                                    <div class="col-span-6">
                                        <label for="attendance" class="block font-medium text-gray-700">
                                            Attendance(Excel)
                                        </label>
                                        <input type="file" name="attendance" id="attendance"
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
                                <button type="button" x-on:click="$dispatch('close')"
                                    class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">
                                    Close
                                </button>
                            </div>
                        </form>
                    </x-modal>
                </div>
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
                    <th class="px-4 py-2 text-left border-b">Status</th>
                    <th class="px-4 py-2 border-b ext-left">Time Out</th>
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
                            {{ date('h:i A', strtotime($attendance->time_in)) }}
                        </td>
                        <td class="px-4 py-2 border-b">
                            {{-- check if late --}}
                            @if ($attendance->time_in_status == 'Late')
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
                @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout>
