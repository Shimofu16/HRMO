<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Attendance History
            </h2>

    </x-slot>
    @include('attendances._header')
    <div class="p-5 mx-auto mt-8 bg-white rounded-md shadow max-w-7xl">

        <div class="flex items-center justify-between mb-3">
            <div>

            </div>
            <div class="flex items-center space-x-2">
                <div class="relative">
                    {{-- <a href="{{ route('attendances-history.index') }}"
                        class="inline-flex items-center px-4 py-2 text-xs font-semibold tracking-widest text-white uppercase transition duration-150 ease-in-out bg-gray-800 border border-transparent rounded-md hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                        Back to Attendance History
                    </a> --}}
                </div>
            </div>
        </div>
        <table class="min-w-full border data-table">
            <thead>
                <tr>
                    <th class="px-4 py-2 text-left border-b">#</th>
                    <th class="px-4 py-2 text-left border-b">Date</th>
                    <th class="px-4 py-2 text-left border-b">Attedance Count</th>
                    <th class="px-4 py-2 text-left border-b">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($attendances as $attendance)
                    <tr>
                        <td class="px-4 py-2 border-b">{{ $loop->iteration }}</td>
                        <td class="px-4 py-2 border-b">{{ date('F d, Y', strtotime($attendance->date)) }}</td>
                        <td class="px-4 py-2 border-b">{{ $attendance->totalEmployee() }}</td>
                        <td class="px-4 py-2 border-b">
                            <a href="{{ route('attendances-history.show', ['date' => $attendance->date]) }}"
                                class="text-blue-500 hover:text-blue-700">View</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout>
