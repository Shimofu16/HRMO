<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            Payroll List
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-9xl sm:px-6 lg:px-8">
            <div class="mt-5 md:mt-0 md:col-span-2">
                <form action="{{ route('payrolls.store') }}" method="POST">
                    @csrf
                    <div class="overflow-hidden shadow sm:rounded-md">
                        <div class="px-4 py-5 bg-white sm:p-6">
                            <div class="grid grid-cols-8 gap-6">

                                <div class="col-span-6 sm:col-span-2">
                                    <label for="pr_department" class="block font-medium text-gray-700">Department</label>
                                    <select name="pr_department" id="pr_department" class="block w-full mt-1 form-select" required>
                                        <option value="" disabled selected>--Please select here--</option>
                                        @foreach ($departments as $department)
                                            <option value="{{ $department->dep_name }}">{{ $department->dep_name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-span-6 sm:col-span-2">
                                    <label for="month" class="block font-medium text-gray-700">Month</label>
                                    <select name="month" id="month" class="block w-full mt-1 form-select"
                                        required>
                                        <option value="" disabled selected>--Please select here--</option>
                                        <option value="January">January</option>
                                        <option value="February">February</option>
                                        <option value="March">March</option>
                                        <option value="April">April</option>
                                        <option value="May">May</option>
                                        <option value="June">June</option>
                                        <option value="July">July</option>
                                        <option value="August">August</option>
                                        <option value="September">September</option>
                                        <option value="October">October</option>
                                        <option value="November">November</option>
                                        <option value="December">December</option>
                                    </select>
                                </div>

                                <div class="col-span-6 sm:col-span-2">
                                    <label for="year" class="block font-medium text-gray-700">Year</label>
                                    <select name="year" id="year" class="block w-full mt-1 form-select"
                                        required>
                                        <option value="" disabled selected>--Please select here--</option>

                                    </select>
                                </div>
                                <script>
                                    // Get the current year
                                    var currentYear = new Date().getFullYear();

                                    // Generate options for current year and next 10 years
                                    for (var i = currentYear; i <= currentYear + 10; i++) {
                                        var option = document.createElement("option");
                                        option.value = i;
                                        option.text = i;
                                        document.getElementById("year").appendChild(option);
                                    }
                                </script>

                                <div class="col-span-6 sm:col-span-2">
                                    <label for="date_from_to" class="block font-medium text-gray-700">Date From - To</label>
                                    <select name="date_from_to" id="date_from_to" class="block w-full mt-1 form-select"
                                        required>
                                        <option value="" disabled selected>--Please select here--</option>
                                        <option value="1 - 15">1 - 15</option>
                                        <option value="16 - 28">16 - 28</option>
                                        <option value="16 - 29">16 - 29</option>
                                        <option value="16 - 30">16 - 30</option>
                                        <option value="16 - 31">16 - 31</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="px-4 py-3 text-right bg-gray-50 sm:px-6">
                            <x-primary-button class="ml-3">
                                {{ __('Add') }}
                            </x-primary-button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="py-12">
        <div class="mx-auto max-w-9xl sm:px-6 lg:px-8">
            <table class="min-w-full bg-white border data-table">
                <thead>
                    <tr>
                        <th class="px-4 py-2 text-left border-b">#</th>
                        <th class="px-4 py-2 text-left border-b">Department</th>
                        <th class="px-4 py-2 text-left border-b">Month</th>
                        <th class="px-4 py-2 text-left border-b">Year</th>
                        <th class="px-4 py-2 text-left border-b">Date From To</th>
                        <th class="px-4 py-2 border-b">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($payrolls as $payroll)
                        <tr>
                            <td class="px-4 py-2 border-b">{{ $loop->iteration }}</td>
                            <td class="px-4 py-2 border-b">{{ $payroll->pr_department }}</td>
                            <td class="px-4 py-2 border-b">{{ $payroll->month }}</td>
                            <td class="px-4 py-2 border-b">{{ $payroll->year }}</td>
                            <td class="px-4 py-2 border-b">{{ $payroll->date_from_to }}</td>
                            <td class="px-4 py-2 text-center border-b">
                                <a href="{{ route('payrolls.show', $payroll) }}"
                                    class="text-green-500 hover:text-green-700">Show</a> |
                                <form class="inline-block" action="{{ route('payrolls.destroy', $payroll) }}"
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
    </div>
</x-app-layout>
