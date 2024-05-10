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
            $table->timestamps();
        });
        Schema::create('employee_loans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained('employees', 'id');
            $table->foreignId('loan_id')->constrained('loans', 'id');

            $table->double('amount');
            $table->json('ranges');
            $table->double('deduction')->nullable();
            $table->double('duration')->nullable();
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
            $table->string('salary_grade_step')->nullable();
            $table->double('sick_leave_points')->nullable();
            $table->double('holding_tax')->nullable();
            $table->double('cos_monthly_salary')->nullable();
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
            $table->enum('type', ['vacation', 'sick', 'force']);
            $table->enum('status', ['accepted', 'pending', 'rejected']);
            $table->timestamps();
        });
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained('employees', 'id');
            $table->dateTime('time_in')->nullable();
            $table->string('time_in_status')->nullable();
            $table->string('time_in_image')->nullable();
            $table->double('time_in_deduction')->nullable();
            $table->dateTime('time_out')->nullable();
            $table->string('time_out_status')->nullable();
            $table->string('time_out_image')->nullable();
            $table->double('time_out_deduction')->nullable();
            $table->double('salary')->nullable();
            $table->bigInteger('hours')->nullable();
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
        Schema::dropIfExists('seminar_attendances');
        Schema::dropIfExists('employee_leave_requests');
        Schema::dropIfExists('attendances');
    }
};
