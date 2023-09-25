<?php

namespace App\Http\Controllers;

use App\Models\Allowance;
use App\Models\Attendance;
use App\Models\Category;
use App\Models\Employee;
use App\Models\EmployeeAllowance;
use App\Models\EmployeeDeduction;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($filter = "month")
    {
        $totalEmployeesPerCategories = Category::with('employees')->get()->map(function ($category) {
            return [
                'category' => $category->category_name,
                'total' => $category->employees->count(),
            ];
        });
        $totalEmployees = Employee::all()->count();

        $isPerMonth = ($filter == "month") ? true : false;
        // get total salary, allowance, deduction, net salary
        $totalSalary = $this->getTotalSalaryPer($isPerMonth);
        $totalAllowance = $this->getTotalAllowancePer($isPerMonth);
        $totalDeduction = $this->getTotalDeductionPer($isPerMonth);
        $totalNetPay = $this->getTotalNetPayPer($totalSalary, $totalAllowance, $totalDeduction);





        // dd($totalEmployeesPerCategories,$totalSalaryPerMonth, $totalAllowancePerMonth, $totalDeductionPerMonth,$totalSalaryPerYear);
        return view('dashboard', compact('totalEmployeesPerCategories', 'totalEmployees', 'totalSalary', 'totalAllowance', 'totalDeduction', 'totalNetPay'));
    }
    private function getTotalSalaryPer($isPerMonth)
    {
        $total = 0;
        $attendances =      Attendance::with('employee')->get();
        $totalSalary = [];
        if ($isPerMonth) {
            $months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December',];
            foreach ($months as $monthKey => $month) {
                foreach ($attendances as $key => $attendance) {
                    $total = 0;
                    if ($attendance->created_at->format('F') == $month) {
                        $total += $attendance->salary;
                    }
                    // if there is same month in array, add the total
                    // if (isset($totalSalary[$monthKey])) {
                    //     $totalSalary[$monthKey]['total'] += $total;
                    // } else {
                    //     $totalSalary[$monthKey] = [
                    //         'month' => $month,
                    //         'total' => $total,
                    //     ];
                    // }
                }
            }
        } else {
            // get all year in attendance
            $years = Attendance::selectRaw('YEAR(created_at) year')->distinct()->get()->pluck('year');
            // to array
            $years = $years->toArray();

            foreach ($years as $yearKey => $year) {
                foreach ($attendances as $key => $attendance) {
                    $total = 0;
                    if ($attendance->created_at->format('Y') == $year) {
                        $total += $attendance->salary;
                    }
                    // if there is same month in array, add the total
                    if (isset($totalSalary[$yearKey])) {
                        $totalSalary[$yearKey]['total'] += $total;
                    } else {
                        $totalSalary[$yearKey] = [
                            'year' => $year,
                            'total' => $total,
                        ];
                    }
                }
            }
        }
        // to collection
        $totalSalary = collect($totalSalary);
        return $total;
    }
    private function getTotalAllowancePer($isPerMonth)
    {
        $total = 0;
        $employeeAllowances = EmployeeAllowance::with('employee')->get();
        $totalAllowance = [];
        if ($isPerMonth) {
            $months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December',];
            foreach ($months as $monthKey => $month) {
                foreach ($employeeAllowances as $key => $employeeAllowance) {
                    $total = 0;
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
                foreach ($employeeAllowances as $key => $employeeAllowance) {
                    $total = 0;
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
        return $total;
    }
    private function getTotalDeductionPer($isPerMonth)
    {
        $total = 0;
        $employeeDeductions = EmployeeDeduction::with('employee')->get();
        $totalDeduction = [];
        if ($isPerMonth) {
            $months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December',];
            foreach ($months as $monthKey => $month) {
                foreach ($employeeDeductions as $key => $employeeDeduction) {
                    $total = 0;
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
        return $total;
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
