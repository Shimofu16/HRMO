<?php

use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\PayrollController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DesignationController;
use App\Http\Controllers\SalaryGradeController;
use App\Http\Controllers\AllowanceController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\BackupController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DeductionController;
use App\Http\Controllers\EmployeeAttendanceController;
use App\Http\Controllers\EmployeeLoansController;
use App\Http\Controllers\HolidayController;
use App\Http\Controllers\LeaveController;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\PasswordController;
use App\Http\Controllers\PayslipController;
use App\Http\Controllers\SalaryGradeStepController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\SeminarController;
use App\Http\Controllers\WithHoldingTaxController;
use App\Models\Allowance;
use App\Models\Attendance;
use App\Models\Employee;
use App\Models\FingerClock;
use App\Models\Loan;
use App\Models\SalaryGrade;
use App\Models\SalaryGradeStep;
use Carbon\Carbon;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

require __DIR__ . '/auth.php';

Route::get('/', function () {
    return view('welcome');
});


Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/dashboard/{filter?}', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('employees', EmployeeController::class)->names([
        'create' => 'employees.create',
        'store' => 'employees.store',
        'show' => 'employees.show',
        'edit' => 'employees.edit',
        'update' => 'employees.update',
        'destroy' => 'employees.destroy',
    ]);

    Route::prefix('levels')->name('levels.')->controller(LevelController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/', 'store')->name('store');
        Route::get('edit/{level}', 'edit')->name('edit');
        Route::put('/{level}', 'update')->name('update');
        Route::delete('/{level}', 'destroy')->name('destroy');
    });
    Route::prefix('holidays')->name('holidays.')->controller(HolidayController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::post('/', 'store')->name('store');
        Route::get('edit/{holiday}', 'edit')->name('edit');
        Route::put('/{holiday}', 'update')->name('update');
        Route::delete('/{holiday}', 'destroy')->name('destroy');
    });

    // Payrolls
    Route::prefix('payrolls')->controller(PayrollController::class)->name('payrolls.')->group(function () {
        Route::get('/{department_id?}',  'index')->name('index');
        Route::get('/show/{payroll}',  'show')->name('show');
        Route::get('/general-payslip/{payroll}',  'generalPayslip')->name('general-payslip');
    });
    // Route::resource('payrolls', PayrollController::class)->names([
    //     'create' => 'payrolls.create',
    //     'store' => 'payrolls.store',
    //     'edit' => 'payrolls.edit',
    //     'update' => 'payrolls.update',
    //     'destroy' => 'payrolls.destroy',
    //     'generateSlip' => 'payrolls.generateSlip',
    // ]);




    Route::resource('departments', DepartmentController::class)->names([
        'index' => 'departments.index',
        'create' => 'departments.create',
        'store' => 'departments.store',
        'show' => 'departments.show',
        'edit' => 'departments.edit',
        'update' => 'departments.update',
        'destroy' => 'departments.destroy',
    ]);

    Route::resource('categories', CategoryController::class)->names([
        'index' => 'categories.index',
        'create' => 'categories.create',
        'store' => 'categories.store',
        'show' => 'categories.show',
        'edit' => 'categories.edit',
        'update' => 'categories.update',
        'destroy' => 'categories.destroy',
    ]);

    Route::resource('designations', DesignationController::class)->names([
        'index' => 'designations.index',
        'create' => 'designations.create',
        'store' => 'designations.store',
        'show' => 'designations.show',
        'edit' => 'designations.edit',
        'update' => 'designations.update',
        'destroy' => 'designations.destroy',
    ]);

    Route::resource('salary-grades', SalaryGradeController::class)->only([
        'index', 'create', 'store', 'edit', 'update',
    ]);


    Route::resource('allowances', AllowanceController::class)->names([
        'index' => 'allowances.index',
        'create' => 'allowances.create',
        'store' => 'allowances.store',
        'show' => 'allowances.show',
        'edit' => 'allowances.edit',
        'update' => 'allowances.update',
        'destroy' => 'allowances.destroy',
    ]);


    Route::resource('deductions', DeductionController::class)->names([
        'index' => 'deductions.index',
        'create' => 'deductions.create',
        'store' => 'deductions.store',
        'show' => 'deductions.show',
        'edit' => 'deductions.edit',
        'update' => 'deductions.update',
        'destroy' => 'deductions.destroy',
    ]);

    Route::resource('schedules', ScheduleController::class)->names([
        'index' => 'schedules.index',
        'create' => 'schedules.create',
        'store' => 'schedules.store',
        'show' => 'schedules.show',
        'edit' => 'schedules.edit',
        'update' => 'schedules.update',
        'destroy' => 'schedules.destroy',
    ]);

    Route::resource('payslips', PayslipController::class)->names([
        'index' => 'payslips.index',
        'create' => 'payslips.create',
        'store' => 'payslips.store',
        'edit' => 'payslips.edit',
        'update' => 'payslips.update',
        'destroy' => 'payslips.destroy',
    ]);

    Route::resource('attendances', AttendanceController::class)->names([

        'create' => 'attendances.create',
        'store' => 'attendances.store',
        'history' => 'attendances.history',
        'show' => 'attendances.show',
        'edit' => 'attendances.edit',
        'update' => 'attendances.update',
        'destroy' => 'attendances.destroy',
    ]);



    Route::resource('loans', EmployeeLoansController::class)->names([
        'index' => 'loans.index',
        'create' => 'loans.create',
        'store' => 'loans.store',
        'show' => 'loans.show',
        'edit' => 'loans.edit',
        'update' => 'loans.update',
        'destroy' => 'loans.destroy',
    ]);

    Route::get('/payrolls/{payroll}/slip', 'PayrollController@slip')->name('payrolls.slip');
    Route::prefix('backups')->name('backup.')->controller(BackupController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::get('/download/{file_name}', 'download')->name('download');
        Route::delete('/delete/{file_name}', 'delete')->name('delete');
    });

    // Department List Routes
    Route::get('/departments-index/employees', [DepartmentController::class, 'index'])->name('departments-index.employees');

    // Category List Routes
    Route::get('/categories-index/employees', [CategoryController::class, 'index'])->name('categories-index.employees');

    // Designation List Routes
    Route::get('/designations-index/employees', [DesignationController::class, 'index'])->name('designations-index.employees');

    // Salary Grade List Routes
    Route::get('/sgrades-index/employees', [SalaryGradeController::class, 'index'])->name('sgrades-index.employees');

    // Allowance List Routes
    Route::get('/allowances-index/employees', [AllowanceController::class, 'index'])->name('allowances-index.employees');

    // Deduction List Routes
    Route::get('/deductions-index/employees', [DeductionController::class, 'index'])->name('deductions-index.employees');

    // Schedule Grade List Routes
    Route::get('/schedules-index/employees', [ScheduleController::class, 'index'])->name('schedules-index.employees');

    // Payslip List Routes
    Route::get('/payslips', [PayslipController::class, 'index'])->name('payslips-index.index');
    Route::get('/payslips/{department_id}/{payroll}', [PayslipController::class, 'show'])->name('payslips.show');

    // Attendance
    Route::get('attendances/{filter_by?}/{filter_id?}', [AttendanceController::class, 'index'])->name('attendances.index');

    // Attendance History
    Route::get('/attendances-history', [AttendanceController::class, 'history'])->name('attendances-history.index');
    Route::get('/attendances-history/{date}', [AttendanceController::class, 'historyShow'])->name('attendances-history.show');

    Route::get('/with-holding-taxes', [WithHoldingTaxController::class, 'index'])->name('with-holding-taxes.index');

    // employee
    Route::group(['prefix' => 'employees'], function () {
        // ... other routes
        Route::get('', [EmployeeController::class, 'index'])->name('employees.index');
        Route::get('/{employee}', [EmployeeController::class, 'show'])->name('employees.show');
        Route::get('/dtr/{employee}', [EmployeeController::class, 'dtr'])->name('employees.dtr');
        Route::get('/payslip/{employee}', [EmployeeController::class, 'payslip'])->name('employees.payslip');
        Route::get('/general-payslip/{employee}', [EmployeeController::class, 'payslip'])->name('employees.general-payslip');
        Route::get('/edit/{employee}', [EmployeeController::class, 'edit'])->name('employees.edit');
        Route::get('/export/excel', [EmployeeController::class, 'excel'])->name('employees.excel');
    });

    //with holding taxes

    // Seminar
    Route::prefix('seminars')->name('seminars.')->controller(SeminarController::class)->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/payslip/{employee_id}', 'payslip')->name('payslip');
        Route::get('/{seminar_id}', 'show')->name('show');
        Route::post('/store', 'store')->name('store');
        Route::post('/{seminar_id}/attendance', 'attendance')->name('attendance');
    });

    // Activity Log
    Route::get('/activity-logs', [ActivityLogController::class, 'index'])->name('activity-logs.index');

    Route::get('password-code', [PasswordController::class, 'index'])->name('password-code.index');
    Route::put('password-code/update', [PasswordController::class, 'update'])->name('password-code.update');

    Route::resource('leave-requests', LeaveController::class)->only([
        'create', 'store', 'edit', 'update',
    ]);

    Route::get('{status}', [LeaveController::class, 'index'])->name('leave-requests.index');
});
Route::prefix('employee/attendance')->name('employee.attendance.')->middleware('guest')->controller(EmployeeAttendanceController::class)->group(function () {
    Route::get('',  'index')->name('index');
    Route::post('/store',  'store')->name('store');
});


Route::get('/update/attendances/bio', function () {
    try {
        $current_date = Carbon::now();
        $employees = Employee::all();
        foreach ($employees as $key => $employee) {
            $temp_attendances = FingerClock::where('namee', $employee->employee_number)
                ->latest()
                ->get();
            // dd($temp_attendances);
            if (count($temp_attendances) > 0) {
                $attendances = collect();
                foreach ($temp_attendances as $key => $temp_attendance) {
                    // dd($temp_attendance->date == $current_date->format('Y-m-d'), $temp_attendance->date, $current_date->format('Y-m-d'));
                    if ($temp_attendance->date == $current_date->format('Y-m-d')) {
                        $attendances[] = $temp_attendance;
                    }
                }
                $time_in = '';
                $time_out = '';
                foreach ($attendances as $key => $attendance) {
                    $formatted_attendance_time_in = Carbon::parse($attendance->time)->format('H:i:s');
                    if ($formatted_attendance_time_in < '12:00:00') {
                        $time_in = $attendance->time;
                    } else {
                        $time_out = $attendance->time;
                    }
                }
                // Check if the employee has already timed in for the day
                $existingTimeIn = $employee->attendances()
                    ->whereDate('time_in', $current_date)
                    ->first();
                if (!$existingTimeIn) {
                    $now_time_in = Carbon::parse($time_in);
                    // dd($existingTimeIn,$time_in, $attendances);
                    $current_time_time_in = $now_time_in->format('H:i:s');
                    $timeIn = '08:00:00';
                    $defaultTimeIn = Carbon::parse('08:00:00'); // 8am
                    $tenAMThreshold = '10:00:00'; // 10:00am
                    $timeOut = '17:00:00'; // 5pm
                    $time_in_deduction =  0;
                    $time_out_deduction =  0;

                    // Check if employee is on time, half-day or late
                    if ($current_time_time_in < $timeIn || $current_time_time_in <= $timeIn) {
                        $status = 'On-time';
                    } elseif ($current_time_time_in >= $tenAMThreshold) {
                        $status = 'Half-Day';
                        $minute_late = $defaultTimeIn->diffInMinutes(Carbon::parse($current_time_time_in));
                        $time_in_deduction = getLateByMinutes($minute_late);
                    } elseif ($current_time_time_in > $timeIn) {
                        $status = 'Late';
                        $minute_late = $defaultTimeIn->diffInMinutes(Carbon::parse($current_time_time_in));
                        $time_in_deduction = getLateByMinutes($minute_late);
                    }
                    if ($employee->data->category->category_code == "JO" || $employee->data->sick_leave_points == 0) {
                        $time_in_deduction = 0;
                    }

                    // Create attendance record for time in
                    $attendance =    Attendance::create([
                        'employee_id' => $employee->id,
                        'time_in_status' => $status,
                        'time_in' => $now_time_in,
                        'time_in_deduction' => $time_in_deduction,
                    ]);
                    $now_time_out = Carbon::parse($time_out);
                    $current_time_time_out = $now_time_out->format('H:i:s');
                    $salary_grade = $employee->data->monthly_salary;
                    $results = calculateSalary($salary_grade, $employee, $attendance, $timeIn, $timeOut, $current_time_time_out, $employee->data->category->category_code == "JO");

                    $status = $results['status'];
                    $total_salary_for_today = $results['salary'];
                    $hours = $results['hour_worked'];
                    $time_out_deduction = $results['deduction'];

                    // Update the attendance record
                    $attendance->update([
                        'time_out_status' => $status,
                        'time_out' => $now_time_out,
                        'hours' => $hours,
                        'salary' => $total_salary_for_today,
                        'time_out_deduction' => $time_out_deduction,
                        'isPresent' => 1,
                    ]);
                }
            }
            // dd($time_in, $time_out);
        }
        return back()->with('success', 'Successfully updated attendance');
    } catch (\Throwable $th) {
        return back()->with('error', $th->getMessage());
    }
})
    ->name('update.attendances.bio');



Route::get('/getAllowances', function (Request $request) {
    return response()->json(Allowance::where('category_id', $request->input('category_id'))->get());
});
Route::get('/getSteps', function (Request $request) {
    return response()->json(SalaryGrade::find($request->input('salary_grade_id'))->steps);
});
Route::get('/getLoan', function (Request $request) {
    return response()->json(Loan::whereIn('id', $request->input('loan_id'))->get());
});



Route::get('/test', function () {
    return view('attendances.employees.test');
});
