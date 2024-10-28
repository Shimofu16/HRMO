<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('employee_number')->unique();
            $table->string('employee_photo')->nullable();
            $table->string('ordinance_number')->unique();
            $table->string('first_name');
            $table->string('middle_name');
            $table->string('last_name');
            $table->timestamps();
        });
        Schema::create('employee_deductions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained('employees', 'id');
            $table->foreignId('deduction_id')->constrained('deductions', 'id');
            $table->double('amount')->nullable();
            $table->timestamps();
        });
        Schema::create('employee_allowances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained('employees', 'id');
            $table->foreignId('allowance_id')->constrained('allowances', 'id');
            $table->double('amount')->nullable();
            $table->timestamps();
        });
        Schema::create('employee_loans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained('employees', 'id');
            $table->foreignId('loan_id')->constrained('loans', 'id');
            $table->double('amount');
            $table->json('ranges');
            $table->double('deduction')->nullable();
            $table->bigInteger('duration');
            $table->date('start_date');
            $table->date('end_date');
            $table->timestamps();
        });
        Schema::create('employee_data', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained('employees', 'id');
            $table->foreignId('department_id')->constrained('departments', 'id');
            $table->foreignId('designation_id')->constrained('designations', 'id');
            $table->foreignId('category_id')->constrained('categories', 'id');
            $table->foreignId('salary_grade_id')->nullable()->constrained('salary_grades', 'id');
            $table->foreignId('level_id')->nullable()->constrained('levels', 'id');
            $table->string('type')->nullable();
            $table->string('salary_grade_step')->nullable();
            $table->string('pds')->nullable();
            $table->double('sick_leave_points')->nullable();
            $table->boolean('has_holding_tax')->default(false);
            $table->double('cos_monthly_salary')->nullable();
            $table->string('payroll_type');
            $table->timestamps();
        });

        Schema::create('employee_promotions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained('employees', 'id');
            $table->foreignId('old_category_id')->constrained('categories', 'id');
            $table->foreignId('new_category_id')->constrained('categories', 'id');
            $table->timestamps();
        });
        Schema::create('seminar_attendances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained('employees', 'id');
            $table->foreignId('seminar_id')->constrained('seminars', 'id');
            $table->double('salary');
            $table->timestamps();
        });
        Schema::create('employee_leave_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained('employees', 'id');
            $table->date('start');
            $table->date('end');
            $table->integer('days');
            $table->double('points');
            $table->double('deducted_points');
            $table->text('letter')->nullable();
            $table->enum('type', [
                'maternity_leave', 'vacation_leave', 'sick_leave', 'force_leave', 'special_leave'
            ]);
            $table->enum('status', ['accepted', 'pending', 'rejected']);
            $table->timestamps();
        });
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained('employees', 'id');
            $table->dateTime('time_in')->nullable();
            $table->string('time_in_status')->nullable();
            $table->double('time_in_deduction')->nullable();
            $table->dateTime('time_out')->nullable();
            $table->string('time_out_status')->nullable();
            $table->double('time_out_deduction')->nullable();
            $table->double('salary')->nullable();
            $table->bigInteger('hours')->nullable();
            $table->enum('type', [
                'attendance','maternity_leave', 'vacation_leave', 'sick_leave', 'force_leave', 'special_leave','seminar'
            ])->default('attendance');
            $table->dateTime('absent_at')->nullable();
            $table->boolean('isPresent')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
        Schema::dropIfExists('employee_deductions');
        Schema::dropIfExists('employee_allowances');
        Schema::dropIfExists('employee_loans');
        Schema::dropIfExists('employee_data');
        Schema::dropIfExists('employee_promotions');
        Schema::dropIfExists('seminar_attendances');
        Schema::dropIfExists('employee_leave_requests');
        Schema::dropIfExists('attendances');
    }
};