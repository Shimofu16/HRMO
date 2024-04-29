<div>
    <form wire:submit.prevent="save" method="POST">
        @csrf
        <div class="shadow overflow-hidden sm:rounded-md">
            
            <div class="px-4 py-5 bg-white sm:p-6">
                <div class="mb-3">
                    @if (session()->has('error'))
                        <div class="text-white bg-red-600 rounded p-2">
                            Error : {{ session('error') }}
                        </div>
                @endif
                </div>
                <div class="grid grid-cols-12 gap-6 mb-3">
                    <div class="col-span-6 sm:col-span-6">
                        <label for="employee_id" class="block font-medium text-gray-700">Employee</label>
                        <select name="employee_id" id="employee_id" wire:model.live='employee_id'
                            class="block w-full mt-1 rounded form-select">
                            <option value="" selected>--Please select here--</option>
                            @foreach ($employees as $employee)
                                <option value="{{ $employee->id }}" wire:key='{{ $employee->id }}'>
                                    {{ $employee->full_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-span-6 sm:col-span-6">
                        <h4 class="text-md">Employee Data</h4>
                        <h6>Name: {{ $employee->full_name }}</h6>
                        <h6>Department: {{ $employee->data->department->dep_name }}</h6>
                        <h6>Leave Points: {{ number_format($points, 2) }}</h6>
                        <h6>Number of days can leave: {{ $days }}</h6>
                    </div>
                </div>
                <div class="grid grid-cols-12 gap-6 mb-3">
                    <div class="col-span-6 sm:col-span-6">
                        <label for="start" class="block font-medium text-gray-700">Start Date</label>
                        <input type="date" name="start" id="start" wire:model='start'
                            class="block w-full mt-1 rounded" required>
                    </div>
                    <div class="col-span-6 sm:col-span-6">
                        <label for="end" class="block font-medium text-gray-700">End Date</label>
                        <input type="date" name="end" id="end" wire:model.live='end'
                            class="block w-full mt-1 rounded" required>
                    </div>
                </div>
                <div class="grid grid-cols-12 gap-6 mb-3">
                    <div class="col-span-6 sm:col-span-6">
                        <label for="type" class="block font-medium text-gray-700">Type</label>
                        <select name="type" id="type" wire:model='type'
                            class="block w-full mt-1 rounded form-select">
                            <option value="" selected>--Please select here--</option>
                            @foreach ($types as $type)
                                <option value="{{ $type }}" wire:key='{{ $type }}'>
                                    {{ Str::ucfirst($type) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                <button type="submit"
                    class="inline-flex items-center px-4 py-2 bg-blue-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-600 active:bg-blue-700 focus:outline-none focus:border-blue-700 focus:shadow-outline-blue disabled:opacity-25 transition ease-in-out duration-150">
                    Create
                </button>
                <a href="{{ route('leave-requests.index', ['status' => 'pending']) }}"
                    class="text-gray-500 hover:text-gray-700 font-bold py-2 px-4 rounded">Back</a>
            </div>
        </div>
    </form>
</div>
