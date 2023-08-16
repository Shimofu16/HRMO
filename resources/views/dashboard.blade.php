<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
    <h1 class="mt-10 ml-5 text-2xl font-bold"> <b>Employee Statistics</b> </h1>
    <hr>
    <div class="grid grid-cols-1 gap-5 mt-5 mb-5 md:grid-cols-2 xl:grid-cols-3">
        <div class="overflow-hidden bg-white rounded-lg shadow">
            <div class="px-4 py-5 sm:p-6">
                <div class="flex flex-col items-center justify-center">

                    <div class="w-full" style="height: 500px">
                        <canvas id="employee"></canvas>
                    </div>
                </div>
            </div>
        </div>

    </div>
    {{-- Summary of Payroll Information --}}
    <h1 class="mt-5 ml-5 text-2xl font-bold"> <b>Summary of Payroll Information Per Month</b> </h1>
    <hr>
    <div class="grid grid-cols-1 gap-5 mt-5 mb-5 md:grid-cols-2 xl:grid-cols-3">
        <div class="overflow-hidden bg-white rounded-lg shadow">
            <div class="px-4 py-5 sm:p-6">
                <div class="flex flex-col items-center justify-center">
                    <div class="w-full" style="height: 300px">
                        <canvas id="salaryPerMonth"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="overflow-hidden bg-white rounded-lg shadow">
            <div class="px-4 py-5 sm:p-6">
                <div class="flex flex-col items-center justify-center">
                    <div class="w-full" style="height: 300px">
                        <canvas id="allowancePerMonth"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="overflow-hidden bg-white rounded-lg shadow">
            <div class="px-4 py-5 sm:p-6">
                <div class="flex flex-col items-center justify-center">
                    <div class="w-full" style="height: 300px">
                        <canvas id="deductionPerMonth"></canvas>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <h1 class="mt-5 ml-5 text-2xl font-bold"> <b>Summary of Payroll Information Per Year</b> </h1>
    <hr>
    <div class="grid grid-cols-1 gap-5 mt-5 mb-5 md:grid-cols-2 xl:grid-cols-3">
        <div class="overflow-hidden bg-white rounded-lg shadow">
            <div class="px-4 py-5 sm:p-6">
                <div class="flex flex-col items-center justify-center">
                    <div class="w-full" style="height: 300px">
                        <canvas id="salaryPerYear"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="overflow-hidden bg-white rounded-lg shadow">
            <div class="px-4 py-5 sm:p-6">
                <div class="flex flex-col items-center justify-center">
                    <div class="w-full" style="height: 300px">
                        <canvas id="allowancePerYear"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="overflow-hidden bg-white rounded-lg shadow">
            <div class="px-4 py-5 sm:p-6">
                <div class="flex flex-col items-center justify-center">
                    <div class="w-full" style="height: 300px">
                        <canvas id="deductionPerYear"></canvas>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <hr>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const colors = ['#1f77b4', '#ff7f0e', '#2ca02c', '#d62728', '#9467bd', '#8c564b', '#e377c2', '#7f7f7f', '#bcbd22',
        '#17becf', '#1b9e77', '#d95f02', '#7570b3', '#e7298a'];
    
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
                        backgroundColor: '#1f77b4',
                        hoverOffset: 4
                    }]
                }
            });
        }
    
        document.addEventListener("DOMContentLoaded", () => {
            generateCharts('#employee', 'Employees', {!! $totalEmployeesPerCategories !!});
            generateBarChart('#salaryPerMonth', 'Salary Per Month', {!! $totalSalaryPerMonth !!}, 1);
            generateBarChart('#allowancePerMonth', 'Allowance Per Month', {!! $totalAllowancePerMonth !!}, 1);
            generateBarChart('#deductionPerMonth', 'Deduction Per Month', {!! $totalDeductionPerMonth !!}, 1);
    
            generateBarChart('#salaryPerYear', 'Salary Per Year', {!! $totalSalaryPerYear !!}, 0);
            generateBarChart('#allowancePerYear', 'Allowance Per Year', {!! $totalAllowancePerYear !!}, 0);
            generateBarChart('#deductionPerYear', 'Deduction Per Year', {!! $totalDeductionPerYear !!}, 0);
        });
    </script>
    
</x-app-layout>

