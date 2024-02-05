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
        <a href="{{ route('seminars.index') }}">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h2 class="mb-2 text-lg font-semibold text-center">Seminars</h2>
                    <!-- Card content here -->
                </div>
            </div>
        </a>
    </div>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mt-5 md:mt-0 md:col-span-2">
                <form action="{{ route('seminars.store') }}" method="POST">
                    @csrf
                    <div class="shadow overflow-hidden sm:rounded-md">
                        <div class="px-4 py-5 bg-white sm:p-6">
                            <div class="grid grid-cols-6 gap-6">
                                <div class="col-span-3 sm:col-span-3">
                                    <label for="name" class="block font-medium text-gray-700">
                                        Name</label>
                                    <input type="text" name="name" id="name"
                                        class="block w-full mt-1 rounded" required>
                                </div>
                                <div class="col-span-3 sm:col-span-3">
                                    <label for="date" class="block font-medium text-gray-700">
                                        Date</label>
                                        <input type="date" name="date" id="date"
                                        class="block w-full mt-1 rounded" required>
                                    </div>
                                    <div class="col-span-3 sm:col-span-3">
                                        <label for="amount" class="block font-medium text-gray-700">
                                            Amount</label>
                                        <input type="number" name="amount" id="amount"
                                            class="block w-full mt-1 rounded" required>
                                    </div>
                            </div>
                        </div>
                        <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                            <x-primary-button class="ml-3">
                                {{ __('Create') }}
                            </x-primary-button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="py-12 ">
        <div class="mx-auto bg-white max-w-7xl sm:p-6 lg:p-8">
            <table class="min-w-full border data-table">
                <thead>
                    <tr>
                        <th class="px-4 py-2 text-left border-b">#</th>
                        <th class="px-4 py-2 text-left border-b">Name</th>
                        <th class="px-4 py-2 text-left border-b">Date</th>
                        <th class="px-4 py-2 text-left border-b">Amount</th>
                        {{-- <th class="px-4 py-2 text-left border-b">Start & End Time</th> --}}
                        <th class="px-4 py-2 border-b ext-left">Attendaces</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($seminars as $seminar)
                        <tr>
                            <td class="px-4 py-2 border-b">{{ $loop->iteration }}</td>
                            <td class="px-4 py-2 border-b">{{ $seminar->name }}</td>
                            <td class="px-4 py-2 border-b">{{ date('F d, Y', strtotime($seminar->date)) }}</td>
                            <td class="px-4 py-2 border-b">{{ money($seminar->amount) }}</td>
                            {{-- <td class="px-4 py-2 border-b">{{ date('h:i A', strtotime($seminar->time_start)) }} -
                                {{ date('h:i A', strtotime($seminar->time_end)) }}</td> --}}
                            <td class="px-4 py-2 border-b">
                                <a href="{{ route('seminars.show', ['seminar_id' => $seminar->id]) }}"
                                    class="text-green-500 hover:text-green-700 mr-3">View</a>
                                {{-- <a href="{{ route('seminars.payslip', ['seminar_id' => $seminar->id]) }}"
                                    class="text-blue-500 hover:text-blue-700">Generate Payslip</a> --}}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
