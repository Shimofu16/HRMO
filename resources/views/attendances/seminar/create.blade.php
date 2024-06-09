<x-app-layout>
    <x-slot name="header">
        <h1 class="text-xl font-semibold leading-tight text-gray-800">
            Create Seminar
        </h1>
    </x-slot>
    @include('attendances._header')
    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form action="{{ route('seminars.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="w-full">
                            <div class="grid grid-cols-12 gap-6 mb-3">
                                <div class="col-span-6">
                                    <label for="name" class="block font-medium text-gray-700">
                                        Name of Business</label>
                                    <input type="text" name="name" id="name" class="block w-full mt-1 rounded" required>
                                </div>
                                <div class="col-span-6">
                                    <label for="location" class="block font-medium text-gray-700">
                                        Location</label>
                                    <input type="text" name="location" id="location" class="block w-full mt-1 rounded" required>
                                </div>
                            </div>
                            <div class="grid grid-cols-12 gap-6 mb-3">
                                <div class="col-span-6">
                                    <label for="type" class="block font-medium text-gray-700">Type</label>
                                    <select name="type" id="type" class="block w-full mt-1 rounded" require>
                                        <option value="">Select type</option>
                                        <option value="seminar">Seminar</option>
                                        <option value="travel_order">Travel Order</option>
                                    </select>
                                </div>
                                <div class="col-span-6">
                                    <label for="name" class="block font-medium text-gray-700">Departments</label>
                                    <select name="departments[]" id="departments" class="block w-full mt-1 rounded" required
                                        multiple>
                                        @foreach ($departments as $key => $department)
                                            <option value="{{ $department->id }}">{{ $department->dep_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="grid grid-cols-12 gap-6 mb-3">
        
                                <div class="col-span-6">
                                    <label for="start_date" class="block font-medium text-gray-700">
                                        Start Date
                                    </label>
                                    <input type="date" name="start_date" id="start_date" class="block w-full mt-1 rounded" required>
                                </div>
                                <div class="col-span-6">
                                    <label for="end_date" class="block font-medium text-gray-700">
                                        End Date
                                    </label>
                                    <input type="date" name="end_date" id="end_date" class="block w-full mt-1 rounded" required>
                                </div>
                            </div>
                            <div class="grid grid-cols-12 gap-6 mb-3">
                                <div class="col-span-6">
                                    <label for="reason" class="block font-medium text-gray-700">
                                       Reason
                                    </label>
                                    <textarea name="reason" id="reason" rows="10" class="block w-full mt-1 rounded" required></textarea>
                                </div>
                                <div class="col-span-6">
                                    <label for="letter" class="block font-medium text-gray-700">
                                        Letter
                                    </label>
                                    <input type="file" name="letter" id="letter" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" required>
                                </div>
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
                $('#departments').select2();
            });
        </script>
    @endpush
</x-app-layout>
