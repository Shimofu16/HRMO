<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Department: {{ $sgrade->sg_name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
                    <form action="{{ route('sgrades.update', $sgrade) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="grid grid-cols-6 gap-6">
                            <div class="col-span-6 sm:col-span-2">
                                <label for="sg_name" class="block mb-2 font-bold text-gray-700">Salary Grade</label>
                                <input type="text" name="sg_name" id="sg_name" value="{{ $sgrade->sg_name }}"
                                    class="block w-full p-2 border rounded" required>
                            </div>
                            <div class="col-span-6 sm:col-span-2">
                                <label for="sg_amount" class="block mb-2 font-bold text-gray-700">Amount</label>
                                <input type="text" name="sg_amount" id="sg_amount" value="{{ $sgrade->sg_amount }}"
                                    class="block w-full p-2 border rounded" required>
                            </div>
                        </div>
                        <div class="flex items-center justify-end mt-6">
                            <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mr-4">
                                Update
                            </button>
                            <a href="{{ route('sgrades.index') }}"
                                class="text-gray-500 hover:text-gray-700 font-bold py-2 px-4 rounded">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
