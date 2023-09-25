<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Salary Grade Steps - {{ $salary_grade->sg_name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mt-5 md:mt-0 md:col-span-2">
                <form action="{{ route('salary.grade.store', ['salary_grade_id' => $salary_grade->id]) }}" method="POST">
                    @csrf
                    <div class="shadow overflow-hidden sm:rounded-md">
                        <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                            <button
                                class="ml-3 inline-flex items-center px-4 py-2 bg-purple-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-purple-700 focus:bg-gray-700 active:bg-purple-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
                                type="button" onclick="addRow()">
                                {{ __('Add row') }}
                            </button>
                            <a href="{{ route('employees.index') }}"
                                class="text-gray-500 hover:text-gray-700 font-bold py-2 px-4 rounded">Back</a>
                        </div>
                        <div class="px-4 py-5 bg-white sm:p-6" id="wrapper">
                            <div class="grid grid-cols-6 gap-6 mb-3 row" id="row1">
                                <div class="col-span-6 sm:col-span-2">
                                    <label for="step" class="block font-medium text-gray-700">Step</label>
                                    <input type="text" class="form-input mt-1 block w-full " value="Step 1" disabled>
                                    <input type="text" name="step[1]" id="step"
                                        class="form-input mt-1 block w-full hidden" value="Step 1">
                                </div>
                                <div class="col-span-6 sm:col-span-2">
                                    <label for="amount" class="block font-medium text-gray-700">Amount</label>
                                    <input type="number" name="amount[1]" id="amount"
                                        class="form-input mt-1 block w-full" required>
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

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 bg-white py-3 shadow overflow-hidden sm:rounded-md">
            <table class="min-w-full  border data-table">
                <thead>
                    <tr>
                        <th class="border-b px-4 py-2 text-left">#</th>
                        <th class="border-b px-4 py-2 text-left">Step</th>
                        <th class="border-b px-4 py-2 text-left">Amount</th>
                        <th class="border-b px-4 py-2">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($salary_grade->steps as $step)
                        <tr>
                            <td class="border-b px-4 py-2">{{ $loop->iteration }}</td>
                            <td class="border-b px-4 py-2">{{ $step->step }}</td>
                            <td class="border-b px-4 py-2 edit">
                                <div id="edit{{ $step->id }}">
                                    {{ number_format($step->amount, 2) }}
                                </div>
                            </td>
                            <td class="border-b px-4 py-2">
                                <button type="button" class="text-blue-500 hover:text-blue-700"
                                    onclick="editAmount({{ $step->id }})">Edit</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

        </div>
    </div>

    <script>
        function addRow() {
            var rowCount = $('.row').length + 1;

            var row = `   <div class="grid grid-cols-6 gap-6 mb-3 row" id="row${rowCount}">
                                <div class="col-span-6 sm:col-span-2">
                                    <label for="step" class="block font-medium text-gray-700">Step</label>
                                    <input type="text" 
                                        class="form-input mt-1 block w-full " value="Step ${rowCount}" disabled>
                                    <input type="text" name="step[${rowCount}]" id="step"
                                        class="form-input mt-1 block w-full hidden" value="Step ${rowCount}">
                                </div>
                                <div class="col-span-6 sm:col-span-2">
                                    <label for="amount" class="block font-medium text-gray-700">Amount</label>
                                    <input type="number" name="amount[${rowCount}]" id="amount"
                                        class="form-input mt-1 block w-full" required>
                                </div>
                                <div class="col-span">
                                    <button class="ml-3 inline-flex items-center px-4 py-2 bg-purple-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-purple-700 focus:bg-gray-700 active:bg-purple-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150" type="button" onclick="removeRow(${rowCount})">
                                        Remove
                                    </button>
                                </div>
                            </div>`
            $('#wrapper').append(row);


        }

        function removeRow($id) {
            if ($('.row').length == 1) {
                alert('You cannot remove all rows');
                return false;
            }
            $('#row' + $id).remove();
        }

        function editAmount(id) {
            var amount = $('#edit' + id).text();
            console.log(amount);

            var form = `<form action="/salary-grade/steps/update/${id}" method="POST"> 
            @csrf 
            @method('PUT') 
            <input type="number" name="amount" value="${amount}" class="form-input mt-1 block w-full"> 
            <button type="submit" class="text-blue-500 hover:text-blue-700">Save</button> 
        </form>`;

            $('#edit' + id).html(form);
        }
    </script>

</x-app-layout>
