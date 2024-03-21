<x-app-layout>
    <x-slot name="header">
        <h1 class="text-xl font-semibold leading-tight text-gray-800">
            Seminar Attendance List
        </h1>
    </x-slot>

    
    <div class=" mx-auto mt-8  max-w-7xl">
        <div class="bg-white  p-5 mx-8 shadow rounded-md">
            <form action="{{ route('seminars.attendance', ['seminar_id' => $seminar->id]) }}" method="POST">
                @csrf
                <div class="grid grid-cols-6 gap-6">
                    <div class="col-span-6">
                        <label for="name" class="block font-medium text-gray-700">Employee</label>
                        <select name="employees[]" id="employees" class="block w-full mt-1 rounded" required
                            multiple>
                            @foreach ($employees as $key => $employee)
                                <option value="{{ $employee->id }}">{{ $employee->full_name }}</option>
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
                        <th class="px-4 py-2 text-left border-b">Department</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($attendances as $attendance)
                        <tr>
                            <td class="px-4 py-2 border-b">{{ $loop->iteration }}</td>
                            <td class="px-4 py-2 border-b">{{ $attendance->employee->full_name }}</td>
                            <td class="px-4 py-2 border-b">{{ $attendance->employee->data->department->dep_name }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td class="px-4 py-2 border-b"></td>
                            <td class="px-4 py-2 border-b text-center">No Attendance</td>
                            <td class="px-4 py-2 border-b"></td>
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