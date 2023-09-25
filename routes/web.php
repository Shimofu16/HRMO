<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\PayrollController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DesignationController;
use App\Http\Controllers\SgradeController;
use App\Http\Controllers\AllowanceController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DeductionController;
use App\Http\Controllers\EmployeeAttendanceController;
use App\Http\Controllers\PayslipController;
use App\Http\Controllers\SalaryGradeStepController;
use App\Http\Controllers\ScheduleController;
use App\Models\Allowance;
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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard/{filter?}', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::resource('employees', EmployeeController::class)->names([
        'create' => 'employees.create',
        'store' => 'employees.store',
        'show' => 'employees.show',
        'edit' => 'employees.edit',
        'update' => 'employees.update',
        'destroy' => 'employees.destroy',
    ]);


    // Payrolls
    Route::prefix('payrolls')->controller(PayrollController::class)->name('payrolls.')->group(function () {
        Route::get('/{department_id?}',  'index')->name('index');
        Route::get('/show/{payroll}',  'show')->name('show');
        Route::get('/dtr/{id}/{payroll}',  'dtr')->name('dtr');
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

    Route::resource('sgrades', SgradeController::class)->names([
        'index' => 'sgrades.index',
        'create' => 'sgrades.create',
        'store' => 'sgrades.store',
        'show' => 'sgrades.show',
        'edit' => 'sgrades.edit',
        'update' => 'sgrades.update',
        'destroy' => 'sgrades.destroy',
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
        'show' => 'payslips.show',
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




    Route::get('/payrolls/{payroll}/slip', 'PayrollController@slip')->name('payrolls.slip');

    // Department List Routes
    Route::get('/departments-index/employees', [DepartmentController::class, 'index'])->name('departments-index.employees');

    // Category List Routes
    Route::get('/categories-index/employees', [CategoryController::class, 'index'])->name('categories-index.employees');

    // Designation List Routes
    Route::get('/designations-index/employees', [DesignationController::class, 'index'])->name('designations-index.employees');

    // Salary Grade List Routes
    Route::get('/sgrades-index/employees', [SgradeController::class, 'index'])->name('sgrades-index.employees');

    // Allowance List Routes
    Route::get('/allowances-index/employees', [AllowanceController::class, 'index'])->name('allowances-index.employees');

    // Deduction List Routes
    Route::get('/deductions-index/employees', [DeductionController::class, 'index'])->name('deductions-index.employees');

    // Schedule Grade List Routes
    Route::get('/schedules-index/employees', [ScheduleController::class, 'index'])->name('schedules-index.employees');

    // Payslip List Routes
    Route::get('/payslips', [PayslipController::class, 'index'])->name('payslips-index.index');
    Route::get('/payslips/{department_id}/{filter}', [PayslipController::class, 'show'])->name('payslips.show');

    // Attendance
    Route::get('attendances/{filter_by?}/{filter_id?}', [AttendanceController::class, 'index'])->name('attendances.index');

    // Attendance History
    Route::get('/attendances-history', [AttendanceController::class, 'history'])->name('attendances-history.index');
    Route::get('/attendances-history/{date}', [AttendanceController::class, 'historyShow'])->name('attendances-history.show');


    // employee
    Route::get('/employees/{filter_by?}/{filter_id?}', [EmployeeController::class, 'index'])->name('employees.index');

    // Salary Grade Steps
    Route::prefix('salary-grade/steps')->name('salary.grade.')->controller(SalaryGradeStepController::class)->group(function () {
        Route::get('/{salary_grade_id}', 'show')->name('show');
        Route::post('/store/{salary_grade_id}', 'store')->name('store');
        Route::put('/update/{salary_grade_id}', 'update')->name('update');
        Route::delete('/destroy/{salary_grade_id}', 'destroy')->name('destroy');
    });
});

Route::prefix('employee/attendance')->name('employee.attendance.')->controller(EmployeeAttendanceController::class)->group(function () {
    Route::get('',  'index')->name('index');
    Route::post('/store',  'store')->name('store');
});

Route::get('/getAllowances', function (Request $request) {
    $category_id = $request->input('category_id');
    $allowances = Allowance::where('category_id', $category_id)->get();

    return response()->json($allowances);
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
