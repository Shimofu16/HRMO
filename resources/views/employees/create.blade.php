<x-app-layout>

    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            Add Employee
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="mt-5 md:mt-0 md:col-span-2">
                <livewire:employee.create />
            </div>
        </div>
    </div>
    @push('scripts')
        <script src="{{ asset('assets/select2-4.1.0-rc.0/css/select2.min.css') }}"></script>
        <script>
            $(document).ready(function() {
                $('.ranges').select2();
            });
        </script>
    @endpush
</x-app-layout>
