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
            $table->timestamps();
        });
        Schema::create('allowance_categories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('allowance_id')->constrained('allowances');
            $table->foreignId('category_id')->nullable()->constrained('categories');
            $table->foreignId('department_id')->nullable()->constrained('departments');
            $table->foreignId('rata_id')->nullable()->constrained('ratas');
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
