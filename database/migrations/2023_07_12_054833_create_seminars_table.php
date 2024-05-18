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
        Schema::create('seminars', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('type',['seminar', 'travel_order']);
            $table->date('date');
            $table->json('departments');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seminars');
    }
};
