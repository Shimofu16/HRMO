<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            Edit Rata Type: {{ $rata_type->type }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-xl sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200 sm:px-20">
                    <form action="{{ route('ratas.update', $rata_type) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="grid grid-cols-6 gap-6 mb-3">
                            <div class="col-span-6 sm:col-span-2">
                                <label for="type" class="block font-medium text-gray-700">Type</label>
                                <input type="text" name="type" id="type" class="block w-full mt-1 rounded" value="{{ $rata_type->type }}" required>
                            </div>
                            <div class="col-span-6 sm:col-span-2">
                                <label for="amount" class="block font-medium text-gray-700">Amount</label>
                                <input type="number" name="amount" id="amount" class="block w-full mt-1 rounded"
                                value="{{ $rata_type->amount }}"
                                    required>
                            </div>
                        </div>
                    

                        <div class="flex items-center justify-end mt-6">
                            <button class="px-4 py-2 mr-4 font-bold text-white bg-blue-500 rounded hover:bg-blue-700">
                                Update
                            </button>
                            <a href="{{ route('ratas.index') }}"
                                class="px-4 py-2 font-bold text-gray-500 rounded hover:text-gray-700">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
</x-app-layout>
