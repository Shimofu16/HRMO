<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Activity Logs') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <table class="min-w-full border data-table">
                        <thead>
                            <tr>
                                <th class="border-b px-4 py-2 text-left">#</th>
                                <th class="border-b px-4 py-2 text-left">Type</th>
                                <th class="border-b px-4 py-2 text-left">Description</th>
                                <th class="border-b px-4 py-2 text-left">IP Address</th>
                                <th class="border-b px-4 py-2 text-left">Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach (auth()->user()->activities as $activity)
                                <tr>
                                    <td class="border-b px-4 py-2">{{ $loop->iteration }}</td>
                                    <td class="border-b px-4 py-2">{{ $activity->type }}</td>
                                    <td class="border-b px-4 py-2">{{ $activity->message }}</td>
                                    <td class="border-b px-4 py-2">{{ $activity->ip_address }}</td>
                                    <td class="border-b px-4 py-2">{{ date('F d, Y h:m A', strtotime($activity->created_at)) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
            </div>
        </div>
    </div>
</x-app-layout>
