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
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('employee_id');
            $table->unsignedBigInteger('seminar_id')->nullable();
            $table->dateTime('time_in')->nullable();
            $table->string('time_in_status');
            $table->string('time_in_image')->nullable();
            $table->dateTime('time_out')->nullable();
            $table->string('time_out_status')->nullable();
            $table->string('time_out_image')->nullable();
            $table->double('salary')->nullable();
            $table->double('deduction')->nullable();
            $table->bigInteger('hours')->nullable();
            $table->boolean('isPresent')->default(false);
            $table->foreign('employee_id')->references('id')->on('employees');
            $table->foreign('seminar_id')->references('id')->on('seminars');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};
