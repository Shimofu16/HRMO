<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            Schedule
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="mt-5 md:mt-0 md:col-span-2">
                <form action="{{ route('schedules.store') }}" method="POST">
                    @csrf
                    <div class="overflow-hidden shadow sm:rounded-md">
                        <div class="px-4 py-5 bg-white sm:p-6">
                            <div class="grid grid-cols-6 gap-6">
                                <div class="col-span-6 sm:col-span-2">
                                    <label for="sched_name" class="block font-medium text-gray-700">Schedule Name</label>
                                    <input type="text" name="sched_name" id="sched_name" class="block w-full mt-1 rounded form-input" required>
                                </div>
                                <div class="col-span-6 sm:col-span-2">
                                    <label for="start_time" class="block font-medium text-gray-700">Start Time</label>
                                    <input type="time" name="start_time" id="start_time" class="block w-full mt-1 rounded form-input" required>
                                </div>
                                <div class="col-span-6 sm:col-span-2">
                                    <label for="end_time" class="block font-medium text-gray-700">End Time</label>
                                    <input type="time" name="end_time" id="end_time" class="block w-full mt-1 rounded form-input" required>
                                </div>
                            </div>
                        </div>
                        <div class="px-4 py-3 text-right bg-gray-50 sm:px-6">
                            <x-primary-button class="ml-3">
                                {{ __('Create') }}
                            </x-primary-button>
                                <a href="{{ route('employees.index') }}"
                                    class="px-4 py-2 font-bold text-gray-500 rounded hover:text-gray-700">Back</a>
                           </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <table class="min-w-full bg-white border data-table">
                <thead>
                    <tr>
                        <th class="px-4 py-2 text-left border-b">#</th>
                        <th class="px-4 py-2 text-left border-b">Schedule Name</th>
                        <th class="px-4 py-2 text-left border-b">Start Time</th>
                        <th class="px-4 py-2 text-left border-b">End Time</th>
                        <th class="px-4 py-2 border-b">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($schedules as $schedule)
                        <tr>
                            <td class="px-4 py-2 border-b">{{ $loop->iteration }}</td>
                            <td class="px-4 py-2 border-b">{{ $schedule->sched_name }}</td>
                            <td class="px-4 py-2 border-b">{{ $schedule->start_time }}</td>
                            <td class="px-4 py-2 border-b">{{ $schedule->end_time }}</td>
                            <td class="px-4 py-2 border-b">
                                <a href="{{ route('schedules.edit', $schedule) }}"
                                    class="text-blue-500 hover:text-blue-700">Edit</a>
                                <form class="inline-block" action="{{ route('schedules.destroy', $schedule) }}"
                                    method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{-- <!-- Pagination links -->
            <div class="mt-0">
                {{ $schedules->links() }}
            </div> --}}
        </div>
    </div>
    </div>


</x-app-layout>
