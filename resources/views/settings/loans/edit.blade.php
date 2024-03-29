<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Loans: {{ $loan->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
                    <form action="{{ route('loans.update', $loan) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="grid grid-cols-12 gap-6">
                            <div class="col-span-3 sm:col-span-3">
                                <label for="name" class="block font-medium text-gray-700">Name</label>
                                <input type="text" name="name" id="name"
                                    class="form-input mt-1 block w-full text-xl" required value="{{ $loan->name }}">
                            </div>
                            <div class="col-span-3 sm:col-span-3">
                                <label for="description" class="block font-medium text-gray-700">Description</label>
                                <input type="text" name="description" id="description"
                                    class="form-input mt-1 block w-full text-xl" required value="{{ $loan->description }}">
                            </div>
                        
                        </div>
                        <div class="flex items-center justify-end mt-6">
                            <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mr-4">
                                Update
                            </button>
                            <a href="{{ route('categories.index') }}"
                                class="text-gray-500 hover:text-gray-700 font-bold py-2 px-4 rounded">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
