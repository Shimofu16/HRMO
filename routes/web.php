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
use App\Http\Controllers\PayslipController;
use App\Http\Controllers\ScheduleController;

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

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::resource('employees', EmployeeController::class)->names([
        'index' => 'employees.index',
        'create' => 'employees.create',
        'store' => 'employees.store',
        'show' => 'employees.show',
        'edit' => 'employees.edit',
        'update' => 'employees.update',
        'destroy' => 'employees.destroy',
    ]);

    Route::resource('payrolls', PayrollController::class)->names([
        'index' => 'payrolls.index',
        'create' => 'payrolls.create',
        'store' => 'payrolls.store',
        'show' => 'payrolls.show',
        'edit' => 'payrolls.edit',
        'update' => 'payrolls.update',
        'destroy' => 'payrolls.destroy',
        'generateSlip' => 'payrolls.generateSlip',
    ]);

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
        'index' => 'attendances.index',
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
    Route::get('/payslips-index', [PayslipController::class, 'index'])->name('payslips-index.index');


});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';