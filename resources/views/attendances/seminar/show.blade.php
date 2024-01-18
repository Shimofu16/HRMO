<x-app-layout>
    <x-slot name="header">
        <h1 class="text-xl font-semibold leading-tight text-gray-800">
            Attendance List
        </h1>
    </x-slot>


    <div class="grid grid-cols-1 gap-3 mt-4 md:grid-cols-2 xl:grid-cols-6">

        <!-- Position List Card -->
        <a href="{{ route('attendances-history.index') }}">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h2 class="mb-2 text-lg font-semibold text-center">Attendance History</h2>
                    <!-- Card content here -->
                </div>
            </div>
        </a>
        <a href="{{ route('attendances-history.index') }}">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h2 class="mb-2 text-lg font-semibold text-center">Seminars</h2>
                    <!-- Card content here -->
                </div>
            </div>
        </a>
    </div>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mt-5 md:mt-0 md:col-span-2">
                <form action="{{ route('seminars.attendance', ['seminar_id' => $seminar->id]) }}" method="POST">
                    @csrf
                    <div class="shadow overflow-hidden sm:rounded-md">
                        <div class="px-4 py-5 bg-white sm:p-6">
                            <div class="grid grid-cols-6 gap-6">
                                <div class="col-span-3 sm:col-span-3">
                                    <label for="name" class="block font-medium text-gray-700">Employee</label>
                                    <select name="employees[]" id="employees" class="block w-full mt-1 rounded" required
                                        multiple>
                                        @foreach ($employees as $key => $employee)
                                            <option value="{{ $key }}">{{ $employee }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                            <x-primary-button class="ml-3">
                                {{ __('Create Attendance') }}
                            </x-primary-button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="py-12 ">
        <div class="mx-auto bg-white max-w-7xl sm:p-6 lg:p-8">
            <table class="min-w-full border data-table">
                <thead>
                    <tr>
                        <th class="px-4 py-2 text-left border-b">#</th>
                        <th class="px-4 py-2 text-left border-b">Name</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($attendances as $attendance)
                        <tr>
                            <td class="px-4 py-2 border-b">{{ $loop->iteration }}</td>
                            <td class="px-4 py-2 border-b">{{ $attendance->employee->name }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="2" class="px-4 py-2 border-b text-center">No Attendance</td>
                        </tr>
                    @endforelse
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
                $('#employees').select2();
            });
        </script>
    @endpush
</x-app-layout>
