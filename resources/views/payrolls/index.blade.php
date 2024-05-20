
<x-app-layout>
    <x-slot name="header">
        <h1 class="text-xl font-semibold leading-tight text-gray-800">
            Payroll List
        </h1>
    </x-slot>

    <div class="p-5 mx-auto mt-8 bg-white rounded-md shadow max-w-7xl">

        <div class="flex items-center justify-between mb-3">
            <div>

            </div>
            <div class="flex items-center space-x-2">
                <div class="relative">
                    {{-- reset button --}}
                    <a href="{{ route('payrolls.index') }}"
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
                                <x-dropdown-link :href="route('payrolls.index', [
                                    'department_id' => $department->id,
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
                    <th class="px-4 py-2 text-left border-b">Department</th>
                    <th class="px-4 py-2 text-left border-b">Month</th>
                    <th class="px-4 py-2 text-left border-b">Year</th>
                    <th class="px-4 py-2 text-left border-b">Date From To</th>
                    <th class="px-4 py-2 text-center border-b">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($payrolls as $payroll)
                    <tr>
                        <td class="px-4 py-2 border-b">{{ $loop->iteration }}</td>
                        <td class="px-4 py-2 border-b">{{ $payroll['department'] }}</td>
                        <td class="px-4 py-2 border-b">{{ $payroll['month'] }}</td>
                        <td class="px-4 py-2 border-b">{{ $payroll['year'] }}</td>
                        <td class="px-4 py-2 border-b">{{ $payroll['date_from_to'] }}</td>
                        <td class="px-4 py-2 border-b">
                            @php
                                $encoded = urlencode(json_encode($payroll));
                                $today = date('j'); // Get today's date without leading zeros
                                $lastDayOfMonth = date('t'); // Get the last day of the current month
                            @endphp
                            <a href="{{ route('payrolls.general-payslip', $encoded) }}"
                                class="mr-3 text-green-500 hover:text-green-700">General Payroll</a>
                                <a href="{{ route('payslips.show', [
                                    'department_id' => $payroll['department_id'],
                                    'payroll' => $encoded,
                                ]) }}"
                                    class="text-blue-500 hover:text-blue-700 ">Generate Payslip</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout>
