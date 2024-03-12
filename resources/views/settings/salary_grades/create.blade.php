<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Add Salary Grade
        </h2>
    </x-slot>
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
                                    class="block w-full mt-1 rounded" required>
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
        <input type="number" name="amount" value="${amount}" class="block w-full mt-1 rounded">
        <button type="submit" class="text-blue-500 hover:text-blue-700">Save</button>
    </form>`;

            $('#edit' + id).html(form);
        }
    </script>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 shadow overflow-hidden px-4 py-5 bg-white">
            <div class="flex justify-between mt-3">
                <div></div>
                <div>
                    <a href="{{ route('salary-grades.index') }}"
                        class="inline-flex items-center px-4 py-2 text-xs font-semibold tracking-widest text-white uppercase transition duration-150 ease-in-out bg-gray-800 border border-transparent rounded-md hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                        Back to Salary Grades
                    </a>
                </div>
            </div>
            <div class="mt-5 md:mt-0 md:col-span-2">
                <form action="{{ route('salary-grades.store') }}" method="POST">
                    @csrf

                    <div id="wrapper">
                        <div class="grid grid-cols-6 gap-6 mb-3 row" id="row1">
                            <div class="col-span-6 sm:col-span-2">
                                <label for="step" class="block font-medium text-gray-700">Step</label>
                                <input type="text" class="form-input mt-1 block w-full " value="Step 1" disabled>
                                <input type="text" name="step[1]" id="step"
                                    class="form-input mt-1 w-full hidden" value="Step 1">
                            </div>
                            <div class="col-span-6 sm:col-span-2">
                                <label for="amount" class="block font-medium text-gray-700">Amount</label>
                                <input type="number" name="amount[1]" id="amount" class="block w-full mt-1 rounded"
                                    required>
                            </div>
                        </div>
                    </div>
                    <div class=" py-3 text-right sm:px-6">
                        <x-primary-button class="mr-1">
                            {{ __('Create') }}
                        </x-primary-button>
                        <button
                            class="ml-3 inline-flex items-center px-4 py-2 bg-purple-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-purple-700 focus:bg-gray-700 active:bg-purple-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"
                            type="button" onclick="addRow()">
                            {{ __('Add row') }}
                        </button>
                    </div>
            </div>
            </form>
        </div>
    </div>
</x-app-layout>
