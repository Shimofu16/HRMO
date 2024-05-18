<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                {{ $employee->full_name }} - {{ $employee->data->category->category_name }}
            </h2>
            
        </div>
    </x-slot>
    @livewire('employee.dtr.create', ['employee' => $employee])
</x-app-layout>

