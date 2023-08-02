<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    {{-- Summary of Payroll Information --}}
    <h1 class="mt-5 ml-5 text-2xl font-bold"> <b>Summary of Payroll Information</b> </h1>
    <hr>
    <div class="grid grid-cols-1 gap-5 mt-5 mb-5 md:grid-cols-2 xl:grid-cols-3">
        <div class="overflow-hidden bg-white rounded-lg shadow">
            <div class="px-4 py-5 sm:p-6">
                <dl>
                    <dt class="text-sm font-medium text-gray-500 truncate">
                        Total Employees
                    </dt>
                    <dd class="mt-1 text-3xl font-semibold text-gray-900">
                        {{-- {{ $dashboardData->total_salary }} --}}
                    </dd>
                </dl>
            </div>
        </div>

        <div class="overflow-hidden bg-white rounded-lg shadow">
            <div class="px-4 py-5 sm:p-6">
                <dl>
                    <dt class="text-sm font-medium text-gray-500 truncate">
                        Regular Employees
                    </dt>
                    <dd class="mt-1 text-3xl font-semibold text-gray-900">
                        {{-- {{ $regularEmployees }} --}}
                        {{ _('67') }}
                    </dd>
                </dl>
            </div>
        </div>

        <div class="overflow-hidden bg-white rounded-lg shadow">
            <div class="px-4 py-5 sm:p-6">
                <dl>
                    <dt class="text-sm font-medium text-gray-500 truncate">
                        Job Order Employees
                    </dt>
                    <dd class="mt-1 text-3xl font-semibold text-gray-900">
                        {{-- {{ $jobOrderEmployees }} --}}
                        {{ _('31') }}
                    </dd>
                </dl>
            </div>
        </div>

        <div class="overflow-hidden bg-white rounded-lg shadow">
            <div class="px-4 py-5 sm:p-6">
                <dl>
                    <dt class="text-sm font-medium text-gray-500 truncate">
                        Total Salary
                    </dt>
                    <dd class="mt-1 text-3xl font-semibold text-gray-900">
                        {{-- {{ $totalSalary }} --}}
                        {{ _('123456000') }}
                    </dd>
                </dl>
            </div>
        </div>

        <div class="overflow-hidden bg-white rounded-lg shadow">
            <div class="px-4 py-5 sm:p-6">
                <dl>
                    <dt class="text-sm font-medium text-gray-500 truncate">
                        Total Deduction
                    </dt>
                    <dd class="mt-1 text-3xl font-semibold text-gray-900">
                        {{-- {{ $totalDeduction }} --}}
                        {{ _('1234.00') }}
                    </dd>
                </dl>
            </div>
        </div>

        <div class="overflow-hidden bg-white rounded-lg shadow">
            <div class="px-4 py-5 sm:p-6">
                <dl>
                    <dt class="text-sm font-medium text-gray-500 truncate">
                        Total Net Pay
                    </dt>
                    <dd class="mt-1 text-3xl font-semibold text-gray-900">
                        {{-- {{ $totalNetPay }} --}}
                        {{ _('237.75') }}
                    </dd>
                </dl>
            </div>
        </div>
    </div> <hr>

    {{-- Employee Statistics --}}

    <h1 class="mt-10 ml-5 text-2xl font-bold"> <b>Employee Statistics</b> </h1>
    <hr>
    <div class="grid grid-cols-1 gap-5 mt-5 mb-5 md:grid-cols-2 xl:grid-cols-3">
        <div class="overflow-hidden bg-white rounded-lg shadow">
            <div class="px-4 py-5 sm:p-6">
                <dl>
                    <dt class="text-sm font-medium text-gray-500 truncate">
                        Total Employees:
                    </dt>
                    <dd class="mt-1 text-3xl font-semibold text-gray-900">
                        {{-- {{ $totalEmployees }} --}}
                        {{ _('307') }}
                    </dd>
                </dl>
            </div>
        </div>

        <div class="overflow-hidden bg-white rounded-lg shadow">
            <div class="px-4 py-5 sm:p-6">
                <dl>
                    <dt class="text-sm font-medium text-gray-500 truncate">
                        Male Employees:
                    </dt>
                    <dd class="mt-1 text-3xl font-semibold text-gray-900">
                        {{-- {{ $regularEmployees }} --}}
                        {{ _('209') }}
                    </dd>
                </dl>
            </div>
        </div>

        <div class="overflow-hidden bg-white rounded-lg shadow">
            <div class="px-4 py-5 sm:p-6">
                <dl>
                    <dt class="text-sm font-medium text-gray-500 truncate">
                        Female Employees:
                    </dt>
                    <dd class="mt-1 text-3xl font-semibold text-gray-900">
                        {{-- {{ $jobOrderEmployees }} --}}
                        {{ _('98') }}
                    </dd>
                </dl>
            </div>
        </div>

        <div class="overflow-hidden bg-white rounded-lg shadow">
            <div class="px-4 py-5 sm:p-6">
                <dl>
                    <dt class="text-sm font-medium text-gray-500 truncate">
                        Regular Employees:
                    </dt>
                    <dd class="mt-1 text-3xl font-semibold text-gray-900">
                        {{-- {{ $totalSalary }} --}}
                        {{ _('256') }}
                    </dd>
                </dl>
            </div>
        </div>

        <div class="overflow-hidden bg-white rounded-lg shadow">
            <div class="px-4 py-5 sm:p-6">
                <dl>
                    <dt class="text-sm font-medium text-gray-500 truncate">
                        Job Order Employees:
                    </dt>
                    <dd class="mt-1 text-3xl font-semibold text-gray-900">
                        {{-- {{ $totalDeduction }} --}}
                        {{ _('51') }}
                    </dd>
                </dl>
            </div>
        </div>
    </div> <hr>
</x-app-layout>
