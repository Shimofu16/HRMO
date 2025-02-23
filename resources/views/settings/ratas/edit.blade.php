<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            Edit Rata Type: {{ $rata_type->type }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-xl sm:rounded-lg">
                <div class="border-b border-gray-200 bg-white p-6 sm:px-20">
                    <form action="{{ route('ratas.update', $rata_type) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3 grid grid-cols-9 gap-6">
                            <div class="col-span-3">
                                <label for="type" class="block font-medium text-gray-700">Type</label>
                                <input type="text" name="type" id="type" class="mt-1 block w-full rounded"
                                    value="{{ $rata_type->type }}" required>
                            </div>
                            <div class="col-span-3">
                                <label for="amount" class="block font-medium text-gray-700">Amount</label>
                                <input type="number" name="amount" id="amount" class="mt-1 block w-full rounded"
                                    value="{{ $rata_type->amount }}" required>
                            </div>

                            <div class="col-span-3">
                                <label for="ranges" class="block font-medium text-gray-700">Range</label>
                                <select name="ranges[]" id="ranges" class="form-select mt-1 block w-full rounded"
                                    multiple="multiple" required>
                                    <option value="1-15">1-15</option>
                                    <option value="16-31">16-31</option>
                                </select>
                            </div>
                        </div>


                        <div class="mt-6 flex items-center justify-end">
                            <button class="mr-4 rounded bg-blue-500 px-4 py-2 font-bold text-white hover:bg-blue-700">
                                Update
                            </button>
                            <a href="{{ route('ratas.index') }}"
                                class="rounded px-4 py-2 font-bold text-gray-500 hover:text-gray-700">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @push('styles')
        <link rel="stylesheet" href="{{ asset('assets/select2-4.1.0-rc.0/css/select2.min.css') }}">
    @endpush
    @push('scripts')
        <script src="{{ asset('assets/select2-4.1.0-rc.0/js/select2.min.js') }}"></script>
        <script>
            $(document).ready(function() {
                $('#ranges').select2();
            });
        </script>
    @endpush
</x-app-layout>
