<x-app-layout>
    <x-slot name="header">
        <h1 class="text-xl font-semibold leading-tight text-gray-800">
            Create Attendance
        </h1>
    </x-slot>
    @include('attendances._header')
    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form action="{{ route('store.attendances.manually') }}" method="POST">
                        @csrf
                        <div class="grid grid-cols-6 gap-6 mb-3">
                            <div class="col-span-6">
                                <label for="employee_id" class="block font-medium text-gray-700">Employee</label>
                                <select name="employee_id" id="employee_id" class="block w-full mt-1 rounded form-select" required>
                                    <option value="" selected>--Please select here--</option>
                                    @foreach ($employees as $employee)
                                        <option value="{{ $employee->id }}">{{ $employee->full_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="grid grid-cols-6 gap-6">
                            <div class="col-span-6 sm:col-span-3">
                                <label for="start_time" class="block font-medium text-gray-700">Start Time</label>
                                <input type="time" name="start_time" id="start_time"
                                    class="block w-full mt-1 rounded" required>
                            </div>
                            <div class="col-span-6 sm:col-span-3">
                                <label for="end_time" class="block font-medium text-gray-700">End Time</label>
                                <input type="time" name="end_time" id="end_time" class="block w-full mt-1 rounded"
                                    required>
                            </div>
                        </div>
                        <div class="py-3 text-right sm:px-6">
                            <x-primary-button class="mr-1">
                                {{ __('Create') }}
                            </x-primary-button>
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
                $('#employee_id').select2();
            });
        </script>
    @endpush
</x-app-layout>
