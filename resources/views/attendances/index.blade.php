<x-app-layout>
    <x-slot name="header">
        <h1 class="text-xl font-semibold leading-tight text-gray-800">
            Attendance List
        </h1>
    </x-slot>


    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-2xl font-bold">Attendance</h2>
                        <div class="text-right">
                            <p class="text-xl font-medium">
                                <span id="digital-clock"></span>
                                <span id="current-date">{{ \Carbon\Carbon::now()->format('F d, Y') }}</span>
                            </p>
                        </div>
                    </div>
                    <form action="{{ route('attendances.store',) }}" method="POST">
                        @csrf
                        <div class="shadow overflow-hidden sm:rounded-md">
                            <div class="px-4 py-5 bg-white sm:p-6">
                                <div class="grid grid-cols-6 gap-6">
                                    <div class="col-span-6 sm:col-span-6">
                                        <label for="employee_id" class="block font-medium text-gray-700">Employee ID Number</label>
                                        <input type="text" name="employee_id" id="employee_id"
                                            class="form-input mt-1 block w-full text-xl" required>
                                    </div>
                                </div>
                            </div>
                            <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                                <button class="'inline-flex items-center px-4 py-2 bg-green-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-400 focus:bg-gray-700 active:bg-green-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    {{ __('Time In') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <table class="min-w-full border bg-white">
                <thead>
                    <tr>
                        <th class="border-b px-4 py-2 text-left">#</th>
                        <th class="border-b px-4 py-2 text-left">Employee</th>
                        <th class="border-b px-4 py-2 text-left">Time In</th>
                        <th class="border-b px-4 py-2">Time Out</th>
                        <th class="border-b px-4 py-2 text-left">Status</th>
                        <th class="border-b px-4 py-2 text-left">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($attendances as $attendance)
                        <tr>
                            <td class="border-b px-4 py-2">{{ $loop->iteration }}</td>
                            <td class="border-b px-4 py-2">{{ $attendance->employee->name }}</td>
                            <td class="border-b px-4 py-2">{{ date('h:i:s A',strtotime($attendance->time_in)) }}</td>
                            <td class="border-b px-4 py-2">{{ ($attendance->time_out) ? date('h:i:s A', strtotime($attendance->time_out)) : "" ; }}</td>
                            <td class="border-b px-4 py-2">{{ $attendance->status }}</td>
                            <td class="border-b px-4 py-2">
                                <form class="inline-block" action="{{ route('attendances.update', $attendance->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="text-red-500 hover:text-red-700 " {{ ($attendance->time_out) ? "disabled" : "" ; }}>Time Out</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <script>
        // Update the digital clock every second
        setInterval(() => {
            const now = new Date();
            const clockElement = document.getElementById('digital-clock');
            clockElement.textContent = now.toLocaleTimeString([], {
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit'
            });
        }, 1000);
    </script>

</x-app-layout>
