<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Payslip List
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-9xl mx-auto sm:px-6 lg:px-8 text-sm">

            <table class="min-w-full border bg-white">
                <thead>
                    <tr>
                        <th class="border-b px-4 py-2 text-left">#</th>
                        <th class="border-b px-4 py-2 text-left">Employee ID</th>
                        <th class="border-b px-4 py-2 text-left">Ordinance Item No.</th>
                        <th class="border-b px-4 py-2 text-left">Firstname</th>
                        <th class="border-b px-4 py-2 text-left">Middlename</th>
                        <th class="border-b px-4 py-2 text-left">Lastname</th>
                        <th class="border-b px-4 py-2 text-left">Department</th>
                        <th class="border-b px-4 py-2 text-left">Salary Grade</th>
                        <th class="border-b px-4 py-2 text-left">Allowance</th>
                        <th class="border-b px-4 py-2 text-left">Deduction</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($employees as $employee)
                            <tr>
                                <td class="border-b px-4 py-2">{{ $loop->iteration }}</td>
                                <td class="border-b px-4 py-2">{{ $employee->emp_no }}</td>
                                <td class="border-b px-4 py-2">{{ $employee->oinumber }}</td>
                                <td class="border-b px-4 py-2">{{ $employee->firstname }}</td>
                                <td class="border-b px-4 py-2">{{ $employee->middlename }}</td>
                                <td class="border-b px-4 py-2">{{ $employee->lastname }}</td>
                                <td class="border-b px-4 py-2">{{ $employee->department }}</td>
                                <td class="border-b px-4 py-2">{{ $employee->sgrade }}</td>
                                <td class="border-b px-4 py-2">{{ $employee->allowance }}</td>
                                <td class="border-b px-4 py-2">{{ $employee->deduction }}</td>
                            </tr>
                        @endforeach
                </tbody>
            </table>
            <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                <button type="submit"
                    class="inline-flex items-center px-4 py-2 bg-blue-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-600 active:bg-blue-700 focus:outline-none focus:border-blue-700 focus:shadow-outline-blue disabled:opacity-25 transition ease-in-out duration-150">
                    Print
                </button>
                <a href="{{ route('payrolls.index') }}"
                    class="text-gray-500 hover:text-gray-700 font-bold py-2 px-4 rounded">Back</a>
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
