<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Update Leave Request
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mt-5 md:mt-0 md:col-span-2">
                <form action="{{ route('leave-requests.update', $leave_request) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="shadow overflow-hidden sm:rounded-md">
                        <div class="px-4 py-5 bg-white sm:p-6">
                            
                            <div class="grid grid-cols-12 gap-6 mb-3">
                                <div class="col-span-6 sm:col-span-6">
                                    <h4 class="text-md">Leave Request</h4>
                                    <h6>Name: {{ $leave_request->employee->full_name }}</h6>
                                    <h6>Date: {{ date('M d, Y', strtotime($leave_request->start)) }} to {{ date('M d, Y', strtotime($leave_request->end)) }}</h6>
                                    <h6>Type: {{ Str::ucfirst($leave_request->type) }}</h6>
                                </div>
                            </div>
                            <div class="grid grid-cols-12 gap-6 mb-3">
                                <div class="col-span-6 sm:col-span-6">
                                    <label for="status" class="block font-medium text-gray-700">status</label>
                                    <select name="status" id="status"
                                        class="block w-full mt-1 rounded form-select">
                                        <option value="" selected>--Please select here--</option>
                                        @foreach ($statuses as $status)
                                            <option value="{{ $status }}" wire:key='{{ $status }}'>
                                                {{ Str::ucfirst($status) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-600 active:bg-blue-700 focus:outline-none focus:border-blue-700 focus:shadow-outline-blue disabled:opacity-25 transition ease-in-out duration-150">
                                Update
                            </button>
                            <a href="{{ route('leave-requests.index',['status' => 'pending']) }}"  class="inline-flex items-center px-4 py-2 text-xs font-semibold tracking-widest text-white uppercase transition duration-150 ease-in-out bg-gray-800 border border-transparent rounded-md hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">Back</a>
                        </div>
                    </div>
                </form>
                
            </div>
        </div>
    </div>
</x-app-layout>
