<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>


    {{-- <div class="grid grid-cols-1 gap-6 mb-6 w-full xl:grid-cols-2 2xl:grid-cols-4">
                <div class="bg-white shadow-lg shadow-gray-200 rounded-2xl p-4 ">
                    <div class="flex flex-col items-center justify-center">
                        <h1 class="text-lg">Employees Per Department</h1>
                        <div class="h-1/6">
                            @if (count($totalEmployeesPerCategories) > 0)
                                <canvas id="employee"></canvas>
                            @else
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
                                <span
                                    class="inline-flex self-center items-center px-3 py-0.5 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                    No Data
                                </span>
                            @endif
                        </div>
                    </div>
                </div>

            </div> --}}
    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="grid w-full grid-cols-1 gap-6 mb-6 xl:grid-cols-2 2xl:grid-cols-4">
                <div class="p-4 bg-white shadow-lg shadow-gray-200 rounded-2xl ">
                    <div class="flex items-center">
                        <div
                            class="inline-flex items-center justify-center flex-shrink-0 w-12 h-12 text-black rounded-lg shadow-md bg-gradient-to-br from-white-500 to-voilet-500 shadow-gray-300">

                            <i class="text-lg fa-solid fa-users"></i>
                        </div>
                        <div class="flex-shrink-0 ml-3">
                            <span class="text-2xl font-bold leading-none text-gray-900">{{ $totalEmployeeCount }}</span>
                            <h3 class="text-base font-normal text-gray-500">Total Employees</h3>
                        </div>
                    </div>
                </div>
                {{-- <div class="p-4 bg-white shadow-lg shadow-gray-200 rounded-2xl ">
                                <div class="flex items-center">
                                    <div
                                        class="inline-flex items-center justify-center flex-shrink-0 w-12 h-12 text-black rounded-lg shadow-md bg-gradient-to-br from-white-500 to-voilet-500 shadow-gray-300">
                                        <i class="text-lg fa-solid fa-graduation-cap"></i>
                                    </div>
                                    <div class="flex-shrink-0 ml-3">
                                        <span class="text-2xl font-bold leading-none text-gray-900">{{ $enrolleeCount }}</span>
                                        <h3 class="text-base font-normal text-gray-500">Enrollee Students</h3>
                                    </div>
                                </div>
                            </div> --}}
            </div>
            <div class="flex flex-wrap mt-6 -mx-3">
                <div class="w-full max-w-full mt-0 mb-6 lg:mb-0 lg:w-7/12">
                    <div
                        class="relative flex flex-col min-w-0 p-3 pt-0 break-words bg-white border-0 border-solid shadow-xl dark:bg-slate-850 dark:shadow-dark-xl dark:bg-gray-950 border-black-125 rounded-2xl bg-clip-border">
                        <div class="p-4 pb-0 mb-0 rounded-t-4">
                            <div class="flex justify-between">
                                <h6 class="mb-2 dark:text-white">
                                    <strong>Attendance monitoring</strong>
                                </h6>
                            </div>
                        </div>
                        <div class="ps" style="height: 20rem;">
                            @if (count($attendanceCountPerWeek) > 0)
                                <canvas id="attendanceCountPerWeek"></canvas>
                            @else
                                <div class="flex justify-center items-center h-full">
                                    <span
                                        class="inline-flex items-center px-3 py-0.5 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                        No Data
                                    </span>

                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="w-full max-w-full px-3 mt-0 lg:w-5/12">
                    <div
                        class="border-black/12.5 shadow-xl dark:bg-slate-850 dark:shadow-dark-xl relative flex min-w-0 flex-col break-words rounded-2xl border-0 border-solid bg-white bg-clip-border">
                        <div class="p-4 pb-0 rounded-t-4">
                            <h6 class="mb-0 dark:text-white">
                                <strong>Recent Attendance</strong>
                            </h6>
                        </div>
                        <div class="flex-auto p-4 pb-1">
                            <ul class="flex flex-col pl-0 mb-0 rounded-lg">
                                @forelse ($recentAttendances as $recentAttendance)
                                    <li class="relative flex justify-between py-2 pr-4 mb-2 border-0 rounded-t-lg rounded-xl text-inherit"
                                        wire:key='{{ $recentAttendance->id }}'>
                                        <div class="flex items-center">

                                            <div class="flex flex-col">
                                                <h6 class="mb-1 text-sm leading-normal text-slate-700 dark:text-white">
                                                    <strong>Name:</strong>
                                                    {{ $recentAttendance->employee->full_name }}
                                                </h6>
                                                <span class="text-xs leading-tight dark:text-white/80">
                                                    <strong>Department:</strong>
                                                    {{ $recentAttendance->employee->data->department->dep_name }}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="flex">
                                            <span
                                                class="text-xs leading-tight dark:text-white/80">{{ $recentAttendance->created_at->diffForHumans() }}</span>
                                        </div>
                                    </li>

                                @empty
                                    <li
                                        class="relative flex justify-between py-2 pr-4 mb-2 border-0 rounded-t-lg rounded-xl text-inherit">
                                        <div class="flex items-center justify-center">

                                            <div class="flex flex-col">
                                                <h6 class="mb-1 text-sm leading-normal text-slate-700 dark:text-white">
                                                    <strong>No Recent Attendance</strong>
                                                </h6>
                                                {{-- <span class="text-xs leading-tight dark:text-white/80">
                                            <strong>Department:</strong>
                                            {{ $recentAttendance->employee->department->dep_name }}
                                        </span> --}}
                                            </div>
                                        </div>
                                        {{-- <div class="flex">
                                    <span
                                        class="text-xs leading-tight dark:text-white/80">{{ $recentEnrollee->created_at->diffForHumans() }}</span>
                                </div> --}}
                                    </li>
                                @endforelse

                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex flex-wrap mt-6 -mx-3">
                <div class="w-full max-w-full mt-0 mb-6 lg:mb-0 lg:w-7/12">
                    <div
                        class="relative flex flex-col min-w-0 p-3 pt-0 break-words bg-white border-0 border-solid shadow-xl dark:bg-slate-850 dark:shadow-dark-xl dark:bg-gray-950 border-black-125 rounded-2xl bg-clip-border">
                        <div class="p-4 pb-0 mb-0 rounded-t-4">
                            <div class="flex justify-between">
                                <h6 class="mb-2 dark:text-white">
                                    <strong>Average Salary per Department(anually)</strong>
                                </h6>
                            </div>
                        </div>
                        <div class="ps" style="height: 20rem;">

                            @if (count($averageSalaryPerDepartment) > 0)
                                <canvas id="averageSalaryPerDepartment"></canvas>
                            @else
                                <div class="flex justify-center items-center h-full">
                                    <span
                                        class="inline-flex items-center px-3 py-0.5 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                        No Data
                                    </span>

                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="w-full max-w-full px-3 mt-0 lg:w-5/12">
                    <div
                        class="border-black/12.5 shadow-xl dark:bg-slate-850 dark:shadow-dark-xl relative flex min-w-0 flex-col break-words rounded-2xl border-0 border-solid bg-white bg-clip-border">
                        <div class="p-4 pb-5 rounded-t-4">
                            <h6 class="mb-0 dark:text-white">
                                <strong>Employees per Deprtments</strong>
                            </h6>
                        </div>
                        <div class="flex-auto p-4 overflow-y-auto" style="height: 20rem; width: 100%;">
                            @if (count($employeesPerDepartment) > 0)
                                <canvas id="employeesPerDepartment"></canvas>
                            @else
                                <div class="flex justify-center items-center h-full">
                                    <span
                                        class="inline-flex items-center px-3 py-0.5 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                        No Data
                                    </span>

                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex flex-wrap mt-6 -mx-3">
                <div class="w-full max-w-full mt-0 mb-6 lg:mb-0 lg:w-7/12">
                    <div
                        class="relative flex flex-col min-w-0 p-3 pt-0 break-words bg-white border-0 border-solid shadow-xl dark:bg-slate-850 dark:shadow-dark-xl dark:bg-gray-950 border-black-125 rounded-2xl bg-clip-border">
                        <div class="p-4 pb-0 mb-0 rounded-t-4">
                            <div class="flex justify-between">
                                <h6 class="mb-2 dark:text-white">
                                    <strong>Payroll History(Monthly)</strong>
                                </h6>
                            </div>
                        </div>
                        <div class="ps" style="height: 20rem;">

                            @if (count($payrollHistory) > 0)
                                <canvas id="payrollHistory"></canvas>
                            @else
                                <div class="flex justify-center items-center h-full">
                                    <span
                                        class="inline-flex items-center px-3 py-0.5 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                        No Data
                                    </span>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="w-full max-w-full px-3 mt-0 lg:w-5/12">
                    <div
                        class="border-black/12.5 shadow-xl dark:bg-slate-850 dark:shadow-dark-xl relative flex min-w-0 flex-col break-words rounded-2xl border-0 border-solid bg-white bg-clip-border">
                        <div class="p-4 pb-5 rounded-t-4">
                            <h6 class="mb-0 dark:text-white">
                                <strong>Employees per Categories</strong>
                            </h6>
                        </div>
                        <div class="flex-auto p-4 overflow-y-auto" style="height: 20rem; width: 100%;">
                            @if (count($employeesPerCategory) > 0)
                                <canvas id="employeesPerCategory"></canvas>
                            @else
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
    </div>


    {{-- <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> --}}
    <script src="{{ asset('assets/chart/chart.js') }}"></script>
    <script>
        const colors = ['#1f77b4', '#ff7f0e', '#2ca02c', '#d62728', '#9467bd', '#8c564b', '#e377c2', '#7f7f7f', '#bcbd22',
            '#17becf', '#1b9e77', '#d95f02', '#7570b3', '#e7298a'
        ];

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
                },
                options: {
                    plugins: {
                        legend: {
                            position: 'right' // Position the legend to the right
                        }
                    },
                    responsive: true, // Make the chart responsive
                    maintainAspectRatio: false, // Don't maintain aspect ratio
                    width: '100%', // Set width of the chart
                    height: '100%' // Set height of the chart
                }
            });
        }



        function generateBarChart(selector, label, data) {
            const dataLength = data.length;
            const backgroundColors = colors.slice(0, dataLength);
            new Chart(document.querySelector(selector), {
                type: 'bar',
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

        document.addEventListener("DOMContentLoaded", () => {

            const attendanceCountPerWeek = {!! json_encode($attendanceCountPerWeek) !!};
            console.log(attendanceCountPerWeek.map(d => d.label))
            const averageSalaryPerDepartment = {!! json_encode($averageSalaryPerDepartment) !!};
            generateBarChart('#attendanceCountPerWeek', 'Weekly Attendance', attendanceCountPerWeek);
            generateBarChart('#averageSalaryPerDepartment', 'Average Salary', averageSalaryPerDepartment);


            const employeesPerDepartment = {!! json_encode($employeesPerDepartment) !!};
            const employeesPerCategory = {!! json_encode($employeesPerCategory) !!};

            generatePieChart('#employeesPerDepartment', 'Employees per Department', employeesPerDepartment);
            generatePieChart('#employeesPerCategory', 'Employees per Department', employeesPerCategory);
        });
    </script>

</x-app-layout>
