<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            Employee List
        </h2>
    </x-slot>

    <div class="grid grid-cols-1 gap-3 mt-4 md:grid-cols-2 xl:grid-cols-6">

        <!-- Department List Card -->
        <a href="{{ route('departments-index.employees') }}">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h2 class="mb-2 text-lg font-semibold text-center">Department List</h2>
                    <!-- Card content here -->
                </div>
            </div>
        </a>

        <!-- Position List Card -->
        <a href="{{ route('designations-index.employees') }}">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h2 class="mb-2 text-lg font-semibold text-center">Designation List</h2>
                    <!-- Card content here -->
                </div>
            </div>
        </a>

        <!-- Category List Card -->
        <a href="{{ route('categories-index.employees') }}">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h2 class="mb-2 text-lg font-semibold text-center">Category List</h2>
                    <!-- Card content here -->
                </div>
            </div>
        </a>

        <!-- Salary Grade List Card -->
        <a href="{{ route('sgrades-index.employees') }}">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h2 class="mb-2 text-lg font-semibold text-center">Salary Grade List</h2>
                    <!-- Card content here -->
                </div>
            </div>
        </a>

        <!-- Allowance List Card -->
        <a href="{{ route('allowances-index.employees') }}">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h2 class="mb-2 text-lg font-semibold text-center">Allowance List</h2>
                    <!-- Card content here -->
                </div>
            </div>
        </a>

        <!-- Deduction List Card -->
        <a href="{{ route('deductions-index.employees') }}">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h2 class="mb-2 text-lg font-semibold text-center">Deduction List</h2>
                    <!-- Card content here -->
                </div>
            </div>
        </a>

        {{-- <!-- Schedule List Card -->
        <a href="{{ route('schedules-index.employees') }}">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h2 class="mb-2 text-lg font-semibold text-center">Schedule List</h2>
                    <!-- Card content here -->
                </div>
            </div>
        </a> --}}
    </div>


    <div class="py-6">
        <div class="mx-auto max-w-9xl sm:px-6 lg:px-8">
            <div class="flex justify-end">
                <input type="text" class="px-4 py-2 border-2 border-gray-300 rounded-md" placeholder="Search...">
                <button
                    class="'inline-flex items-center px-4 py-2 bg-purple-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-purple-700 focus:bg-gray-700 active:bg-purple-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">Search</button>
            </div>

            <div class="mb-4">
                <a href="{{ route('employees.create') }}"
                    class="'inline-flex items-center px-4 py-2 bg-purple-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-purple-700 focus:bg-gray-700 active:bg-purple-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">Add
                    Employee</a>
            </div>

            <table class="min-w-full bg-white border">
                <thead>
                    <tr>
                        <th class="px-4 py-4 text-left border-b">#</th>
                        <th class="px-4 py-4 text-left border-b">Employee<br>ID</th>
                        <th class="px-4 py-4 text-left border-b">Name</th>
                        <th class="px-4 py-4 text-left border-b">Ordinance<br>Item No.</th>
                        <th class="px-4 py-4 text-left border-b">Department</th>
                        <th class="px-4 py-4 text-left border-b">Designation</th>
                        <th class="px-4 py-4 text-left border-b">Category</th>
                        {{-- <th class="px-4 py-4 text-left border-b">Schedule</th> --}}
                        <th class="px-4 py-4 text-left border-b">Salary<br>Grade</th>
                        <th class="px-4 py-4 text-left border-b">Allowance</th>
                        <th class="px-4 py-4 text-left border-b">Deduction</th>
                        <th class="px-4 py-4 border-b">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($employees as $employee)
                        <tr>
                            <td class="px-4 py-3 border-b">
                                {{ ($employees->currentPage() - 1) * $employees->perPage() + $loop->iteration }}</td>
                            <td class="px-4 py-3 border-b">{{ $employee->emp_no }}</td>
                            <td class="px-4 py-3 border-b">{{ $employee->name }}</td>
                            <td class="px-4 py-3 border-b">{{ $employee->oinumber }}</td>
                            <td class="px-4 py-3 border-b">{{ $employee->department->dep_code }}</td>
                            <td class="px-4 py-3 border-b">
                                {{ Str::limit($employee->designation->designation_code, 20, '...') }}</td>
                            <td class="px-4 py-3 border-b">{{ $employee->category->category_code }}</td>
                            {{-- <td class="px-4 py-3 border-b">{{ $employee->schedule->sched_name }}</td> --}}
                            <td class="px-4 py-3 border-b">{{ $employee->sgrade->sg_code }}</td>
                            <td class="px-4 py-3 border-b">
                                <div class="flex flex-col">
                                    @foreach ($employee->allowances as $allowance)
                                        <span>{{ $allowance->allowance->allowance_code }} - {{ $allowance->allowance->allowance_amount }}</span>
                                    @endforeach
                                </div>
                            </td>
                            <td class="px-4 py-3 border-b">
                                <div class="flex flex-col">
                                    @foreach ($employee->deductions as $deduction)
                                        <span>{{ $deduction->deduction->deduction_code }} - {{ $deduction->deduction->deduction_amount }}</span>
                                    @endforeach
                                </div>

                            </td>
                            <td class="px-4 py-3 border-b">

                                <a href="{{ route('employees.edit', $employee) }}"
                                    class="text-blue-500 hover:text-blue-700">Edit</a>
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
            <!-- Pagination links -->
            <div class="mt-0">
                {{ $employees->links() }}
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#searchButton').click(function() {
                var searchQuery = $('#searchInput').val().trim();
                filterTable(searchQuery);
            });

            function filterTable(query) {
                // Perform filtering logic here
                // You can update the table rows based on the search query
                // For example, you can hide/show rows that match the query
            }
        });
    </script>
</x-app-layout>
