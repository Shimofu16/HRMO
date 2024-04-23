<?php

namespace App\Http\Controllers;

use App\Models\Allowance;
use App\Models\Attendance;
use App\Models\Category;
use App\Models\Department;
use App\Models\Employee;
use App\Models\EmployeeAllowance;
use App\Models\EmployeeDeduction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // public function index(string $filter = "year", ?int $value = null)
    // {
    //     $value = now()->format('Y');
    //     $totalEmployeesPerCategories = Category::with('employees')->get()->map(function ($category) {
    //         return [
    //             'category' => $category->category_name,
    //             'total' => $category->employees->count(),
    //         ];
    //     });
    //     $totalEmployees = Employee::all()->count();
    //     // $attendanceCount = countAttendanceBy($filter, $value);//uncomment this
    //     // $totalSalary = getTotalSalaryBy($filter); //uncomment this

    //     $attendanceCount = countAttendancesTest($filter, $value); // for test purposes
    //     $totalSalary = getTotalSalaryTest($filter); // for test purposes

    //     // dd($attendanceCount , $totalSalary);

    //     return view(
    //         'dashboard',
    //         compact(
    //             'totalEmployeesPerCategories',
    //             'totalEmployees',
    //             'totalSalary',
    //             'attendanceCount',
    //             'filter',
    //         )
    //     );
    // }
    public function index(string $filter = "year", ?int $value = null)
    {


        $totalEmployeeCount = Employee::count();

        $recentAttendances = $this->getAttendanceBy('recent');
        $attendanceCountPerWeek = $this->getAttendanceBy('weekly');
        $averageSalaryPerDepartment = $this->getAttendanceBy('averageSalaryPerDepartment');
        $employeesPerDepartment = $this->getAttendanceBy('employeesPerDepartment');
        $employeesPerCategory = $this->getAttendanceBy('employeesPerCategory');
        $payrollHistory = $this->getAttendanceBy('payrollHistory');


        // dd(
        //     $this->getAttendanceBy('recent'),
        //      $this->getAttendanceBy('weekly'),
        //      $this->getAttendanceBy('averageSalaryPerDepartment'),
        //       $this->getAttendanceBy('employeesPerDepartment'),
        //       $this->getAttendanceBy('employeesPerCategory'),
        //       $this->getAttendanceBy('payrollHistory'),
        //       );
        return view(
            'dashboard',
            compact(
                'recentAttendances',
                'attendanceCountPerWeek',
                'averageSalaryPerDepartment',
                'employeesPerDepartment',
                'employeesPerCategory',
                'payrollHistory',
                'totalEmployeeCount'
            )
        );
    }
    private function getAttendanceBy($filter)
    {
        switch ($filter) {
            case 'recent':
                $currentTime = Carbon::now();
                return Attendance::whereDate('time_in', $currentTime)
                    ->limit(5)
                    ->orderBy('id', 'DESC')
                    ->get();
            case 'weekly':

                $startOfWeek = Carbon::now()->startOfWeek();
                $endOfWeek = Carbon::now()->endOfWeek();

                for ($day = $startOfWeek; $day->lte($endOfWeek); $day = $day->addDay()) {
                    $dayName = date('l', $day->timestamp);
                    $attendanceByDayOfWeek[] = [
                        'label' => $dayName,
                        'count' => Attendance::whereBetween('time_in', [$startOfWeek, $endOfWeek])
                            ->whereDay('time_in', $day->format('d'))
                            ->count(),
                    ];
                }

                return $attendanceByDayOfWeek;
            case 'averageSalaryPerDepartment':
                $averageSalaryPerDepartment = [];
                // annually
                $departments = Department::with('employees')->get();
                foreach ($departments as $key => $department) {
                    $averageSalaryPerDepartment[] =
                        [
                            'label' => $department->dep_name,
                            'count' => getTotalSalaryDepartment($department->employees, 'year', now()->format('Y'))
                        ];
                }
                // dd($averageSalaryPerDepartment);
                return $averageSalaryPerDepartment;
            case 'payrollHistory':
                $payrollHistory = [];
                // // annually
                $departments = Department::with('employees')->get();
                foreach ($departments as $key => $department) {
                    $payrollHistory[] =
                        [
                            'label' => $department->dep_name,
                            'count' => getTotalSalaryDepartment($department->employees, 'month', now()->format('m'))
                        ];
                }
                    //   dd($payrollHistory);
                return $payrollHistory;
            case 'employeesPerDepartment':
                $employeesPerDepartment = [];
                // annually
                $departments = Department::withCount('employees')->get();
                foreach ($departments as $key => $department) {
                    $employeesPerDepartment[] =
                        [
                            'label' => $department->dep_name,
                            'count' => $department->employees_count
                        ];
                }
                return $employeesPerDepartment;
            case 'employeesPerCategory':
                $employeesPerCategory = [];
                // annually
                $categories = Category::withCount('employees')->get();
                foreach ($categories as $key => $category) {
                    $employeesPerCategory[] =
                        [
                            'label' => $category->category_name,
                            'count' => $category->employees_count
                        ];
                }
                return $employeesPerCategory;
            default:
                // Handle other cases or throw an exception if needed
                break;
        }
    }
    private function testGetAttendanceBy($filter)
    {
        switch ($filter) {
            case 'weekly':
                return [
                    [
                        'label' => 'Monday',
                        'count' => 3
                    ],
                    [
                        'label' => 'Tuesday',
                        'count' => 10
                    ],
                    [
                        'label' => 'Wednesday',
                        'count' => 10
                    ],
                    [
                        'label' => 'Thursday',
                        'count' => 13
                    ],
                    [
                        'label' => 'Friday',
                        'count' => 11
                    ],
                ];

            default:
                // Handle other cases or throw an exception if needed
                break;
        }
    }



    private function getTotalAllowancePer($isPerMonth)
    {
        $employeeAllowances = EmployeeAllowance::with('employee')->get();
        $totalAllowance = [];
        if ($isPerMonth) {
            $months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December',];
            foreach ($months as $monthKey => $month) {
                $total = 0;
                foreach ($employeeAllowances as $key => $employeeAllowance) {
                    if ($employeeAllowance->created_at->format('F') == $month) {
                        $total += $employeeAllowance->allowance->allowance_amount;
                    }
                    // if there is same month in array, add the total
                    if (isset($totalAllowance[$monthKey])) {
                        $totalAllowance[$monthKey]['total'] += $total;
                    } else {
                        $totalAllowance[$monthKey] = [
                            'month' => $month,
                            'total' => $total,
                        ];
                    }
                }
            }
        } else {
            // get all year in attendance
            $years = EmployeeAllowance::selectRaw('YEAR(created_at) year')->distinct()->get()->pluck('year');
            // to array
            $years = $years->toArray();

            foreach ($years as $yearKey => $year) {
                $total = 0;
                foreach ($employeeAllowances as $key => $employeeAllowance) {
                    if ($employeeAllowance->created_at->format('Y') == $year) {
                        $total += $employeeAllowance->allowance->allowance_amount;
                    }
                    // if there is same month in array, add the total
                    if (isset($totalAllowance[$yearKey])) {
                        $totalAllowance[$yearKey]['total'] += $total;
                    } else {
                        $totalAllowance[$yearKey] = [
                            'year' => $year,
                            'total' => $total,
                        ];
                    }
                }
            }
        }
        $totalAllowance = collect($totalAllowance);
        return $totalAllowance->sum('total');
    }
    private function getTotalDeductionPer($isPerMonth)
    {
        $employeeDeductions = EmployeeDeduction::with('employee')->get();
        $totalDeduction = [];
        if ($isPerMonth) {
            $months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December',];
            foreach ($months as $monthKey => $month) {
                $total = 0;
                foreach ($employeeDeductions as $key => $employeeDeduction) {
                    if ($employeeDeduction->created_at->format('F') == $month) {
                        $total += $employeeDeduction->deduction->deduction_amount;
                    }
                    // if there is same month in array, add the total
                    if (isset($totalDeduction[$monthKey])) {
                        $totalDeduction[$monthKey]['total'] += $total;
                    } else {
                        $totalDeduction[$monthKey] = [
                            'month' => $month,
                            'total' => $total,
                        ];
                    }
                }
            }
        } else {
            // get all year in attendance
            $years = EmployeeDeduction::selectRaw('YEAR(created_at) year')->distinct()->get()->pluck('year');
            // to array
            $years = $years->toArray();

            foreach ($years as $yearKey => $year) {
                foreach ($employeeDeductions as $key => $employeeDeduction) {
                    $total = 0;
                    if ($employeeDeduction->created_at->format('Y') == $year) {
                        $total += $employeeDeduction->deduction->deduction_amount;
                    }
                    // if there is same month in array, add the total
                    if (isset($totalDeduction[$yearKey])) {
                        $totalDeduction[$yearKey]['total'] += $total;
                    } else {
                        $totalDeduction[$yearKey] = [
                            'year' => $year,
                            'total' => $total,
                        ];
                    }
                }
            }
        }
        $totalDeduction = collect($totalDeduction);
        return $totalDeduction->sum('total');
    }
    private function getTotalNetPayPer($totalSalary, $totalAllowance, $totalDeduction)
    {
        $totalNetPay = 0;
        // $sumOfTotalSalary = $totalSalary->sum('total');
        // $sumOfTotalAllowance = $totalAllowance->sum('total');
        // $sumOfTotalDeduction = $totalDeduction->sum('total');
        // $totalNetPay = $sumOfTotalSalary + $sumOfTotalAllowance - $sumOfTotalDeduction;


        return $totalSalary + $totalAllowance - $totalDeduction;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
