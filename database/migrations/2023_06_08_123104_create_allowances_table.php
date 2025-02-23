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
        Schema::create('allowances', function (Blueprint $table) {
            $table->id();
            $table->string('allowance_code');
            $table->string('allowance_name');
            $table->json('allowance_ranges');
            $table->double('allowance_amount');
            $table->timestamps();
        });
        Schema::create('ratas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('department_id')->nullable()->constrained('departments');
            $table->string('type')->nullable();
            $table->double('amount')->nullable();
            $table->json('ranges')->nullable();
            $table->timestamps();
        });
        Schema::create('hazards', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained('categories');
            $table->foreignId('department_id')->constrained('departments');
            $table->string('name');
            $table->double('amount');
            $table->enum('amount_type',['percentage', 'fixed_amount']);
            $table->json('ranges');
            $table->timestamps();
        });
        Schema::create('hazard_salary_grades', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hazard_id')->constrained('hazards');
            $table->foreignId('salary_grade_id')->constrained('salary_grades');
            $table->timestamps();
        });
        Schema::create('allowance_categories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('allowance_id')->constrained('allowances');
            $table->foreignId('category_id')->nullable()->constrained('categories');
            $table->foreignId('department_id')->nullable()->constrained('departments');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('allowances');
    }
};
