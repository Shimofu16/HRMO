<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Payslip List
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-9xl mx-auto sm:px-6 lg:px-8 text-sm">

            <table class="min-w-full bg-white border data-table">
                <thead>
                    <tr>
                        <th class="px-4 py-4 text-left border-b">#</th>
                        <th class="px-4 py-4 text-left border-b">Department Name</th>
                        <th class="px-4 py-4 text-left border-b">Total Employees</th>
                        <th class="px-4 py-4 text-left border-b">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($departments as $department)
                        <tr>
                            <td class="px-4 py-3 border-b">
                                {{ $loop->iteration }}</td>
                            <td class="px-4 py-3 border-b">
                                <div class="flex flex-col">
                                    <h3>{{ $department->dep_name }}</h3>
                                    <small>{{ $department->dep_code }}</small>
                                </div>
                            </td>
                            <td class="px-4 py-3 border-b">
                                {{ $department->employees->count() }}
                            </td>
                            <td class="px-4 py-3 border-b">
                                <div class="relative">
                                    <x-dropdown align="left" width="w-full">
                                        <x-slot name="trigger">
                                            <button
                                                class="w-full bg-white border border-gray-300 px-4 py-2 rounded-md shadow-sm focus:outline-none focus:ring focus:border-blue-300 text-left">
                                                Download Payslip
                                            </button>
                                        </x-slot>

                                        <x-slot name="content">
                                            <x-dropdown-link :href="route('payslips.show', [
                                                'department_id' => $department->id,
                                                'filter' => '1-15',
                                            ])">
                                                1-15
                                            </x-dropdown-link>
                                            <x-dropdown-link :href="route('payslips.show', [
                                                'department_id' => $department->id,
                                                'filter' => '16-31',
                                            ])">
                                                16-31
                                            </x-dropdown-link>
                                        </x-slot>
                                    </x-dropdown>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

        </div>

    </div>
</x-app-layout>
