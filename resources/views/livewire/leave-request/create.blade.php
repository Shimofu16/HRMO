<div>
    <form wire:submit.prevent="save" method="POST">
        @csrf
        <div class="overflow-hidden shadow sm:rounded-md">

            <div class="px-4 py-5 bg-white sm:p-6">
                <div class="mb-3">
                    @if (session()->has('error'))
                    <div class="p-2 text-white bg-red-600 rounded">
                        Error : {{ session('error') }}
                    </div>
                    @endif
                </div>
                <div class="grid grid-cols-12 gap-6 mb-3">
                    <div class="col-span-6 sm:col-span-6">
                        <h4 class="text-md">Employee Data</h4>
                        <h6>Name: {{ $name }}</h6>
                        <h6>Department: {{ $department }}</h6>
                        <h6>Leave Points: {{ number_format($points, 2) }}</h6>
                        <h6>Number of days can leave: {{ $days }}</h6>
                        @if ($isAnyOfTheSelectedCategories)
                            <h6>Number of Force Leave Points: {{ $fl_points }}</h6>
                            <h6>Number of Special Leave Points: {{ $sl_points }}</h6>
                        @endif
                    </div>
                </div>
                <div class="grid grid-cols-12 gap-6 mb-3">
                    <div class="col-span-6 sm:col-span-6">
                        <label for="start" class="block font-medium text-gray-700">Start Date</label>
                        <input type="date" name="start" id="start" wire:model='start' class="block w-full mt-1 rounded"
                            required>
                    </div>
                    <div class="col-span-6 sm:col-span-6">
                        <label for="end" class="block font-medium text-gray-700">End Date</label>
                        <input type="date" name="end" id="end" wire:model.live='end' class="block w-full mt-1 rounded"
                            required>
                    </div>
                </div>
                <div class="grid grid-cols-12 gap-6 mb-3">
                    <div class="col-span-6 sm:col-span-6">
                        <label for="type" class="block font-medium text-gray-700">Type</label>
                        <select name="type" id="type" wire:model='type' class="block w-full mt-1 rounded form-select">
                            <option value="" selected>--Please select here--</option>
                            @foreach ($types as $type)
                            <option value="{{ $type }}" wire:key='{{ $type }}'>
                                {{ Str::ucfirst(Str::replaceFirst('_', ' ', $type)) }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    @if ($isAnyOfTheSelectedCategories)
                    <div class="col-span-6 sm:col-span-6">
                        <label for="letter"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Letter</label>
                        <input type="file" name="letter" id="letter" wire:model='letter'
                            class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"
                            required>
                    </div>
                    @endif
                </div>
            </div>
            <div class="px-4 py-3 text-right bg-gray-50 sm:px-6">
                <button type="submit"
                    class="inline-flex items-center px-4 py-2 text-xs font-semibold tracking-widest text-white uppercase transition duration-150 ease-in-out bg-blue-500 border border-transparent rounded-md hover:bg-blue-600 active:bg-blue-700 focus:outline-none focus:border-blue-700 focus:shadow-outline-blue disabled:opacity-25">
                    Create
                </button>
                <a href="{{ route('leave-requests.index', ['status' => 'pending']) }}"
                    class="px-4 py-2 font-bold text-gray-500 rounded hover:text-gray-700">Back</a>
            </div>
        </div>
    </form>
</div>
