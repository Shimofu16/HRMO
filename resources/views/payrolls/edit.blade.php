<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Payroll
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mt-5 md:mt-0 md:col-span-2">
                <form action="{{ route('payrolls.update', $payroll) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="shadow overflow-hidden sm:rounded-md">
                        <div class="px-4 py-5 bg-white sm:p-6">
                            <div class="grid grid-cols-6 gap-6">
                                <div class="col-span-6 sm:col-span-6">
                                    <label for="ref_number" class="block font-medium text-gray-700">Reference Number</label>
                                    <input type="text" name="ref_number" id="ref_number" class="form-input mt-1 block w-full" value="{{ $payroll->ref_number }}" required>
                                </div>

                                <div class="col-span-6 sm:col-span-2">
                                    <label for="date_from" class="block font-medium text-gray-700">Date From</label>
                                    <input type="date" name="date_from" id="date_from" class="form-input mt-1 block w-full" value="{{ $payroll->date_from }}" required>
                                </div>

                                <div class="col-span-6 sm:col-span-2">
                                    <label for="date_to" class="block font-medium text-gray-700">Date To</label>
                                    <input type="date" name="date_to" id="date_to" class="form-input mt-1 block w-full" value="{{ $payroll->date_to }}" required>
                                </div>

                                <div class="col-span-6 sm:col-span-2">
                                    <label for="status" class="block font-medium text-gray-700">Status</label>
                                    <input type="text" name="status" id="status" class="form-input mt-1 block w-full" value="{{ $payroll->status }}" required>
                                </div>
                            </div>
                        </div>
                        <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-600 active:bg-blue-700 focus:outline-none focus:border-blue-700 focus:shadow-outline-blue disabled:opacity-25 transition ease-in-out duration-150">
                                Update
                            </button>
                            <a href="{{ route('payrolls.index') }}" class="text-gray-500 hover:text-gray-700 font-bold py-2 px-4 rounded">Back</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
