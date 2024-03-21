<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 gap-6 mb-6 w-full xl:grid-cols-2 2xl:grid-cols-4">
                <div class="bg-white shadow-lg shadow-gray-200 rounded-2xl p-4 ">
                    <div class="flex flex-col items-center justify-center">
                        <h1 class="text-lg">Employees Per Department</h1>
                        <div class="h-1/6">
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
                        <h3>Total Employees: {{ $totalEmployees }} </h3>
                    </div>
                </div>
                <div class="bg-white shadow-lg shadow-gray-200 rounded-2xl p-4 ">
                    <div class="flex flex-col items-center justify-center">
                        <h1 class="text-lg">Attendance Count Per {{ Str::ucfirst($filter) }}</h1>
                        <div class="h-1/6">
                            @if (count($attendanceCount) > 0)
                                <canvas id="attendanceCount"></canvas>
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
            <div class="grid grid-cols-1 gap-6 mb-6 w-full xl:grid-cols-4 2xl:grid-cols-6">
                <div class="bg-white shadow-lg shadow-gray-200 rounded-2xl p-4 ">
                    <div class="flex flex-col items-center justify-center">
                        <h1 class="text-lg">Salary Per {{ Str::ucfirst($filter) }}</h1>
                        <div class="h-1/5 w-full">
                            @if (count($totalSalary) > 0)
                                <canvas id="totalSalary"></canvas>
                            @else
                                {{-- Generate a badge --}}
                                <span
                                    class="inline-flex self-center items-center px-3 py-0.5 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                    No Data
                                </span>
                            @endif
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>

    {{-- <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> --}}
    <script src="{{ asset('assets/chart/chart.js') }}"></script>
    <script>
        const colors = ['#1f77b4', '#ff7f0e', '#2ca02c', '#d62728', '#9467bd', '#8c564b', '#e377c2', '#7f7f7f', '#bcbd22',
            '#17becf', '#1b9e77', '#d95f02', '#7570b3', '#e7298a'
        ];

        function generatePieChartForEmployee(selector, label, data) {
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
        function generatePieChart(selector, label, data) {
            const dataLength = data.length;
            const backgroundColors = colors.slice(0, dataLength);
            new Chart(document.querySelector(selector), {
                type: 'pie',
                data: {
                    labels: data.map(d => d.label),
                    datasets: [{
                        label: label,
                        data: data.map(d => d.count),
                        backgroundColor: backgroundColors,
                        hoverOffset: 4
                    }]
                }
            });
        }

        function generateBarChart(selector, label, data, filter) {
            const dataLength = data.length;
            const backgroundColors = colors.slice(0, dataLength);
            new Chart(document.querySelector(selector), {
                type: 'bar',
                data: {
                    labels: data.map(d => (filter == 'year' ? d.year : d.month)),
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
            generatePieChartForEmployee('#employee', 'Employees', {!! $totalEmployeesPerCategories !!});
            generatePieChart('#attendanceCount', 'Attendance Count', {!! $attendanceCount !!});

            generateBarChart('#totalSalary', 'Salary Per Year', {!! $totalSalary !!}, "{!! $filter !!}");
        });
    </script>

</x-app-layout>
