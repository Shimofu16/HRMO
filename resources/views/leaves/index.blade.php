<x-app-layout>
    <x-slot name="header">
        <h1 class="text-xl font-semibold leading-tight text-gray-800">
            Leave Requests - {{ Str::ucfirst($status) }}
        </h1>
    </x-slot>

    <div class="p-5 mx-auto mt-8 bg-white rounded-md shadow max-w-7xl">

        <div class="flex items-center justify-between mb-3">
            <div>
                <a href="{{ route('leave-requests.create') }}"
                    class="'inline-flex items-center px-4 py-2 bg-purple-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-purple-700 focus:bg-gray-700 active:bg-purple-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    Create Leave Request
                </a>
            </div>
            <div class="flex items-center space-x-2">
                <div class="relative">
                    {{-- reset button --}}
                    <a href="{{ route('leave-requests.index',['status'=> 'pending']) }}"
                        class="inline-flex items-center px-4 py-2 text-xs font-semibold tracking-widest text-white uppercase transition duration-150 ease-in-out bg-gray-800 border border-transparent rounded-md hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                        Reset
                    </a>

                </div>
                <div class="relative">
                    <x-dropdown align="left" width="w-full">
                        <x-slot name="trigger">
                            <button
                                class="w-full px-4 py-2 text-left bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring focus:border-blue-300">
                                Select a Status
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <x-dropdown-link :href="route('leave-requests.index', [
                                'status' => 'accepted',
                            ])">
                              Accepted
                            </x-dropdown-link>
                            <x-dropdown-link :href="route('leave-requests.index', [
                                'status' => 'pending',
                            ])">
                              Pending
                            </x-dropdown-link>
                            <x-dropdown-link :href="route('leave-requests.index', [
                                'status' => 'rejected',
                            ])">
                              Rejected
                            </x-dropdown-link>
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
                    <th class="px-4 py-2 text-left border-b">Date</th>
                    <th class="px-4 py-2 text-left border-b">Type</th>
                    <th class="px-4 py-2 text-center border-b">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($leave_requests as $leave_request)
                    <tr>
                        <td class="px-4 py-2 border-b">{{ $loop->iteration }}</td>
                        <td class="px-4 py-2 border-b">{{ $leave_request->employee->full_name }}</td>
                        <td class="px-4 py-2 border-b">
                            {{ date('M, d Y', strtotime($leave_request->start)) }} to {{ date('M, d Y', strtotime($leave_request->end)) }}
                        </td>
                        <td class="px-4 py-2 border-b">
                            {{ Str::ucfirst($leave_request->type) }}
                        </td>
                        <td class="px-4 py-2 border-b">
                            <a href="{{ route('leave-requests.edit', $leave_request) }}"
                                class="text-blue-500 hover:text-blue-700 ">Edit</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout>
