<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Employee: {{ $employee->full_name }}
        </h2>
    </x-slot>


    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="mt-5 md:mt-0 md:col-span-2">
                {{-- <livewire:employee.edit :employee="$employee" /> --}}
                @livewire('employee.edit', ['employee' => $employee])
            </div>
        </div>
    </div>

</x-app-layout>
