<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                {{ __('Attendance History') }}
            </h2>
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
            href="{{ route('attendances-history.index') }}">
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
                                <th class="px-4 py-2 text-left border-b">Date</th>
                                <th class="px-4 py-2 text-left border-b">Attedance Count</th>
                                <th class="px-4 py-2 text-left border-b">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($attendances as $attendance)
                                <tr>
                                    <td class="px-4 py-2 border-b">{{ $loop->iteration }}</td>
                                    <td class="px-4 py-2 border-b">{{ date('F d, Y', strtotime($attendance->created_at)) }}</td>
                                    <td class="px-4 py-2 border-b">{{ $attendance->totalEmployee() }}</td>
                                    <td class="px-4 py-2 border-b">
                                        <a href="{{ route('attendances-history.show', $attendance->created_at) }}"
                                            class="text-blue-500 hover:text-blue-700">View</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
