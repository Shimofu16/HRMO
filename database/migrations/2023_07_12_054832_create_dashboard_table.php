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
        Schema::create('dashboard', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('total_salary');
            $table->unsignedBigInteger('total_allowance');
            $table->unsignedBigInteger('total_deduction');
            $table->unsignedBigInteger('total_netpay');
            $table->unsignedInteger('total_employees');
            $table->unsignedInteger('casual');
            $table->unsignedInteger('contract_of_service');
            $table->unsignedInteger('coterminous');
            $table->unsignedInteger('elective');
            $table->unsignedInteger('job_orders');
            $table->unsignedInteger('permanent');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dashboard');
    }
};
