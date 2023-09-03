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
            $table->string('emp_no');
            $table->string('oinumber');
            $table->string('name');
            $table->double('sick_leave')->default(1.25);
            $table->timestamps();

            $table->foreignId('sgrade_id')->nullable()->constrained('sgrades')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('department_id')->nullable()->constrained('departments')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('designation_id')->nullable()->constrained('designations')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('category_id')->nullable()->constrained('categories')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('schedule_id')->nullable()->constrained('schedules')->onDelete('cascade')->onUpdate('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
