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
        Schema::create('salary_grade_steps', function (Blueprint $table) {
            $table->id();
            $table->foreignId('salary_grade_id')->constrained('sgrades')->cascadeOnDelete();
            $table->string('step');
            $table->decimal('amount',);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('salary_grade_steps');
    }
};
