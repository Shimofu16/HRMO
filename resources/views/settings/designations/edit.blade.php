<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Designation: {{ $designation->designation_name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
                    <form action="{{ route('designations.update', $designation) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="grid grid-cols-6 gap-6">
                            <div class="col-span-6 sm:col-span-3">
                                <label for="designation_code" class="block mb-2 font-bold text-gray-700">Designation Name</label>
                                <input type="text" name="designation_code" id="designation_code" value="{{ $designation->designation_code }}"
                                    class="block w-full p-2 border rounded" required>
                            </div>
                            <div class="col-span-6 sm:col-span-3">
                                <label for="designation_name" class="block mb-2 font-bold text-gray-700">Designation Name</label>
                                <input type="text" name="designation_name" id="designation_name" value="{{ $designation->designation_name }}"
                                    class="block w-full p-2 border rounded" required>
                            </div>
                        </div>
                        <div class="flex items-center justify-end mt-6">
                            <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mr-4">
                                Update
                            </button>
                            <a href="{{ route('designations.index') }}"
                                class="text-gray-500 hover:text-gray-700 font-bold py-2 px-4 rounded">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
