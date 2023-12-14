<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            Payroll List
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="flex items-center justify-between mb-3">
            <div class="buttons">

            </div>
            <div class="flex items-center space-x-2">
                <div class="relative">
                    {{-- reset button --}}
                    <a href="{{ route('payrolls.index') }}"
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

        <div class="mx-auto bg-white max-w-9xl sm:px-6 lg:p-8">
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
                                @endphp
                                <a href="{{ route('payrolls.show', $encoded) }}"
                                    class="text-green-500 hover:text-green-700 mr-3">View</a>
                                <a href="{{ route('payslips.show', [
                                    'department_id' => $payroll['department_id'],
                                    'payroll' => $encoded,
                                ]) }}"
                                    class="text-blue-500 hover:text-blue-700">Generate Payslip</a>

                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
