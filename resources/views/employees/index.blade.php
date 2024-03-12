
<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Employee List
            </h2>

    </x-slot>

    <div class="p-5 mx-auto mt-8 bg-white rounded-md shadow max-w-7xl">

        <div class="flex items-center justify-between mb-3">
            <div class="buttons">
                <a href="{{ route('employees.create') }}"
                    class="'inline-flex items-center px-4 py-2 bg-purple-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-purple-700 focus:bg-gray-700 active:bg-purple-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">Add
                    Employee</a>
            </div>
            <div class="flex items-center space-x-2">
                <div class="relative">
                    {{-- reset button --}}
                    <a href="{{ route('employees.index') }}"
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
                                <x-dropdown-link :href="route('employees.index', [
                                    'filter_by' => 'department',
                                    'filter_id' => $department->id,
                                ])">
                                    {{ $department->dep_name }}
                                </x-dropdown-link>
                            @endforeach
                        </x-slot>
                    </x-dropdown>
                </div>

                <div class="relative">
                    <x-dropdown align="left" width="w-full">
                        <x-slot name="trigger">
                            <button
                                class="w-full px-4 py-2 text-left bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring focus:border-blue-300">
                                Select a Category
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            @foreach ($categories as $category)
                                <x-dropdown-link :href="route('employees.index', [
                                    'filter_by' => 'category',
                                    'filter_id' => $category->id,
                                ])">
                                    {{ $category->category_name }}
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
                    <th class="px-4 py-4 text-left border-b">#</th>
                    <th class="px-4 py-4 text-left border-b">Employee<br>ID</th>
                    <th class="px-4 py-4 text-left border-b">Ordinance<br>Item No.</th>
                    <th class="px-4 py-4 text-left border-b">Name</th>
                    <th class="px-4 py-4 text-left border-b">Department</th>
                    <th class="px-4 py-4 text-left border-b">Designation</th>
                    <th class="px-4 py-4 text-left border-b">Category</th>
                    <th class="px-4 py-4 border-b">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($employees as $employee)
                    <tr>
                        <td class="px-4 py-3 border-b">
                            {{ $loop->iteration }}</td>
                        <td class="px-4 py-3 border-b">{{ $employee->employee_number }}</td>
                        <td class="px-4 py-3 border-b">{{ $employee->ordinance_number }}</td>
                        <td class="px-4 py-3 border-b">{{ $employee->full_name }}</td>
                        <td class="px-4 py-3 border-b">{{ $employee->data->department->dep_code }}</td>
                        <td class="px-4 py-3 border-b">
                            {{ Str::limit($employee->data->designation->designation_code, 20, '...') }}</td>
                        <td class="px-4 py-3 border-b">{{ $employee->data->category->category_code }}</td>
                        <td class="px-4 py-3 border-b">
                            <a href="{{ route('employees.show', $employee) }}"
                                class="text-blue-500 hover:text-blue-700">View Info.</a>
                                {{-- <a href="{{ route('seminars.payslip', ['employee_id' => $employee->id]) }}"
                                    class="text-blue-500 hover:text-blue-700">Generate Payslip (Seminars)</a> --}}
                            <form class="inline-block" action="{{ route('employees.destroy', $employee) }}"
                                method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout>
