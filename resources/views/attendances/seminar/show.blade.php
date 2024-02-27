
<x-app-layout>

    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            Seminar
        </h2>
    </x-slot>
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
    <div class="mx-auto max-w-7xl">
        <div class="p-5 mx-8 mt-8 bg-white rounded-md shadow">
            <form action="{{ route('seminars.attendance', ['seminar_id' => $seminar->id]) }}" method="POST">
                @csrf
                <div class="grid grid-cols-6 gap-6">
                    <div class="col-span-6">
                        <label for="name" class="block font-medium text-gray-700">Employee</label>
                        <select name="employees[]" id="employees" class="block w-full mt-1 rounded" required
                            multiple>
                            @foreach ($employees as $key => $employee)
                                <option value="{{ $key }}">{{ $employee }}</option>
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

        <div class="p-5 mt-5 bg-white rounded-md shadow">

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
                            <td class="px-4 py-2 border-b"></td>
                            <td class="px-4 py-2 border-b text-start">No Attendance</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
