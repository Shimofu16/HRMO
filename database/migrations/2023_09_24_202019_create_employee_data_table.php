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
        Schema::create('employee_data', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained('employees','id');
            $table->foreignId('department_id')->constrained('departments','id');
            $table->foreignId('designation_id')->constrained('designations','id');
            $table->foreignId('category_id')->constrained('categories','id');
            $table->foreignId('salary_grade_id')->constrained('salary_grades','id');
            $table->string('salary_grade_step');
            $table->double('sick_leave_points');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employee_data');
    }
};
