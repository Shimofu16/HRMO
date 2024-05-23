<x-app-layout>
    <x-slot name="header">
        <h1 class="text-xl font-semibold leading-tight text-gray-800">
            Official Business List
        </h1>
    </x-slot>

    @include('attendances._header')
    <div class=" mx-auto mt-8  max-w-7xl">
        <div class="bg-white  p-5 mx-8 shadow rounded-md">
            <form action="{{ route('seminars.store') }}" method="POST">
                @csrf
                <div class="grid grid-cols-6 gap-6">
                    <div class="col-span-3 sm:col-span-3">
                        <label for="name" class="block font-medium text-gray-700">
                            Name of Business</label>
                        <input type="text" name="name" id="name" class="block w-full mt-1 rounded" required>
                    </div>
                    <div class="col-span-3 sm:col-span-3">
                        <label for="date" class="block font-medium text-gray-700">
                            Date</label>
                        <input type="date" name="date" id="date" class="block w-full mt-1 rounded" required>
                    </div>
                    <div class="col-span-3 sm:col-span-3">
                        <label for="type" class="block font-medium text-gray-700">Type</label>
                        <select name="type" id="type" class="block w-full mt-1 rounded" require>
                            <option value="">Select type</option>
                            <option value="seminar">Seminar</option>
                            <option value="travel_order">Travel Order</option>
                        </select>
                    </div>
                    <div class="col-span-3 sm:col-span-3">
                        <label for="name" class="block font-medium text-gray-700">Departments</label>
                        <select name="departments[]" id="departments" class="block w-full mt-1 rounded" required
                            multiple>
                            @foreach ($departments as $key => $department)
                                <option value="{{ $department->id }}">{{ $department->dep_name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="py-3 text-right sm:px-6">
                    <x-primary-button class="mr-1">
                        {{ __('Create') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
        <div class="bg-white rounded-md shadow mt-8 p-5">
            <div class="flex items-center justify-between mb-3">

            </div>
            <table class="min-w-full border data-table">
                <thead>
                    <tr>
                        <th class="px-4 py-2 text-left border-b">#</th>
                        <th class="px-4 py-2 text-left border-b">Name</th>
                        <th class="px-4 py-2 text-left border-b">Date</th>
                        <th class="px-4 py-2 text-left border-b">Departments</th>
                        <th class="px-4 py-2 border-b ext-left">Attendaces</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($seminars as $seminar)
                        <tr>
                            <td class="px-4 py-2 border-b">{{ $loop->iteration }}</td>
                            <td class="px-4 py-2 border-b">{{ $seminar->name }}</td>
                            <td class="px-4 py-2 border-b">{{ date('F d, Y', strtotime($seminar->date)) }}</td>
                            <td class="px-4 py-2 border-b">
                                @if ($seminar->departments[0] == 'All')
                                    All Deparments
                                @else
                                    @php
                                        $departments = \App\Models\Department::find($seminar->departments);
                                    @endphp
                                    @foreach ($departments as $department)
                                        {{ $department->dep_code }}
                                        @if (!$loop->last)
                                            ,
                                        @endif
                                    @endforeach
                                @endif
                            </td>
                            <td class="px-4 py-2 border-b">
                                <a href="{{ route('seminars.show', ['seminar_id' => $seminar->id]) }}"
                                    class="mr-3 text-green-500 hover:text-green-700">View</a>

                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

        </div>
    </div>
    @push('styles')
        <link href="{{ asset('assets/select2-4.1.0-rc.0/css/select2.min.css') }}" rel="stylesheet" />
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
