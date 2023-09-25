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
                        {{ $totalEmployees }}
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
                        {{ $totalSalary }}
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
                        {{ $totalDeduction }}
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
                        {{ $totalNetPay }}
                    </dd>
                </dl>
            </div>
        </div>
    </div>
    <hr>
    <h1 class="mt-10 text-2xl font-bold"> <b>Employee Statistics</b> </h1>
    <hr>
    <div class="grid grid-cols-1 gap-5 mt-5 mb-5 md:grid-cols-2 xl:grid-cols-3">

        <div class="px-4 py-5 sm:p-4 bg-white rounded-lg shadow">
            <div class="flex flex-col items-center justify-center">

                <div class="w-full" style="height: 500px">
                    @if (count($totalEmployeesPerCategories) > 0)
                        <canvas id="employee"></canvas>
                    @else
                        {{-- Generate a badge --}}
                        <span
                            class="inline-flex items-center px-3 py-0.5 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                            No Data
                        </span>
                    @endif
                </div>
            </div>
        </div>
    </div>

    </div>

    <hr>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const colors = ['#1f77b4', '#ff7f0e', '#2ca02c', '#d62728', '#9467bd', '#8c564b', '#e377c2', '#7f7f7f', '#bcbd22',
            '#17becf', '#1b9e77', '#d95f02', '#7570b3', '#e7298a'
        ];

        function generateCharts(selector, label, data) {
            const dataLength = data.length;
            const backgroundColors = colors.slice(0, dataLength);
            new Chart(document.querySelector(selector), {
                type: 'pie',
                data: {
                    labels: data.map(d => d.category),
                    datasets: [{
                        label: label,
                        data: data.map(d => d.total),
                        backgroundColor: backgroundColors,
                        hoverOffset: 4
                    }]
                }
            });
        }

        function generateBarChart(selector, label, data, isMonthly) {
            const dataLength = data.length;
            const backgroundColors = colors.slice(0, dataLength);
            new Chart(document.querySelector(selector), {
                type: 'bar',
                data: {
                    labels: data.map(d => (isMonthly ? d.month : d.year)),
                    datasets: [{
                        label: label,
                        data: data.map(d => d.total),
                        backgroundColor: '#7E23CE',
                        hoverOffset: 4
                    }]
                }
            });
        }

        document.addEventListener("DOMContentLoaded", () => {
            generateCharts('#employee', 'Employees', {!! $totalEmployeesPerCategories !!});
        });
    </script>

</x-app-layout>
