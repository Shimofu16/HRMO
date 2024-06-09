<x-app-layout>
    <x-slot name="header">
        <h1 class="text-xl font-semibold leading-tight text-gray-800">
            Official Business List
        </h1>
    </x-slot>

    @include('attendances._header')
    <div class=" mx-auto mt-8  max-w-7xl">
        <div class="bg-white rounded-md shadow mt-8 p-5">
            <div class="flex items-center justify-between mb-3">
                <div></div>
                <div>
                    <a href="{{ route('seminars.create') }}"
                        class="'inline-flex items-center px-4 py-2 bg-purple-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-purple-700 focus:bg-gray-700 active:bg-purple-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        Add Official Business
                    </a>
                </div>
            </div>
            <table class="min-w-full border data-table">
                <thead>
                    <tr>
                        <th class="px-4 py-2 text-left border-b">#</th>
                        <th class="px-4 py-2 text-left border-b">Name</th>
                        <th class="px-4 py-2 text-left border-b">Date</th>
                        <th class="px-4 py-2 text-left border-b">Departments</th>
                        <th class="px-4 py-2 border-b ext-left">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($seminars as $seminar)
                        <tr>
                            <td class="px-4 py-2 border-b">{{ $loop->iteration }}</td>
                            <td class="px-4 py-2 border-b">{{ $seminar->name }}</td>
                            <td class="px-4 py-2 border-b">{{ date('F d, Y', strtotime($seminar->start_date)) }} -
                                {{ date('F d, Y', strtotime($seminar->end_date)) }}</td>
                            <td class="px-4 py-2 border-b">
                                @php
                                    $departments = \App\Models\Department::find($seminar->departments);
                                @endphp
                                @foreach ($departments as $department)
                                    {{ $department->dep_code }}
                                    @if (!$loop->last)
                                        ,
                                    @endif
                                @endforeach
                            </td>
                            <td class="px-4 py-2 border-b">
                                <div class="flex flex-col">
                                    <a href="{{ route('seminars.download', ['seminar_id' => $seminar->id]) }}"
                                        class="mr-3 text-blue-700 hover:text-white border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2 dark:border-blue-500 dark:text-blue-500 dark:hover:text-white dark:hover:bg-blue-500 dark:focus:ring-blue-800">
                                        Download Letter
                                    </a>
                                    <a href="{{ route('seminars.show', ['seminar_id' => $seminar->id]) }}"
                                        class="text-green-700 hover:text-white border border-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2 dark:border-green-500 dark:text-green-500 dark:hover:text-white dark:hover:bg-green-500 dark:focus:ring-green-800">
                                        View Attendance
                                    </a>

                                </div>

                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

        </div>
    </div>
    @push('styles')
        <link href="{{ asset('assets/select2-4.1.0-rc.0/css/select2.min.css') }}" rel="stylesheet" />
    @endpush
    @push('scripts')
        <script src="{{ asset('assets/select2-4.1.0-rc.0/js/select2.min.js') }}"></script>
        <script>
            $(document).ready(function() {
                $('#departments').select2();
            });
        </script>
    @endpush
</x-app-layout>
