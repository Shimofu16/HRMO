<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Add Allowance
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mt-5 md:mt-0 md:col-span-2">
                <form action="{{ route('allowances.store') }}" method="POST">
                    @csrf
                    <div class="shadow overflow-hidden sm:rounded-md">
                        <div class="px-4 py-5 bg-white sm:p-6">
                            <div class="grid grid-cols-6 gap-6">
                                <div class="col-span-6 sm:col-span-6">
                                    <label for="allowance_name" class="block font-medium text-gray-700">Allowance Name</label>
                                    <input type="text" name="allowance_name" id="allowance_name" class="block w-full mt-1 rounded" required>
                                </div>
                                <div class="col-span-6 sm:col-span-6">
                                    <label for="allowance_amount" class="block font-medium text-gray-700">Amount</label>
                                    <input type="text" name="allowance_amount" id="allowance_amount" class="block w-full mt-1 rounded" required>
                                </div>
                            </div>
                        </div>
                        <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-600 active:bg-blue-700 focus:outline-none focus:border-blue-700 focus:shadow-outline-blue disabled:opacity-25 transition ease-in-out duration-150">
                                Create
                            </button>
                            <a href="{{ route('allowances.index') }}" class="text-gray-500 hover:text-gray-700 font-bold py-2 px-4 rounded">Back</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
