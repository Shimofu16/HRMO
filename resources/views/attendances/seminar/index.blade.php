<x-app-layout>

    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            Seminar List
        </h2>
    </x-slot>
    <div class="mx-auto max-w-7xl">
        <div class="p-5 mx-8 mt-8 bg-white rounded-md shadow">
            <form action="{{ route('seminars.store') }}" method="POST">
                @csrf
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
                <div class="py-3 text-right sm:px-6">
                    <x-primary-button class="mr-1">
                        {{ __('Create') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    
        <div class="p-5 mt-5 bg-white rounded-md shadow">
    
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
                                    class="mr-3 text-green-500 hover:text-green-700">View</a>
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
