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
        Schema::create('employee_fingerprints', function (Blueprint $table) {
            $table->id();
            $table->text('username');
            $table->text('fullname');
            $table->text('indexfinger');
            $table->text('middlefinger');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employee_fingerprints');
    }
};
