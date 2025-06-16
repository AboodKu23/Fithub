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
        Schema::create('trainees', function (Blueprint $table) {
            $table->id();
            $table->foreignId('trainee_id')->constrained('users')->onDelete('cascade');
            $table->decimal('height', 8, 2);
            $table->decimal('weight', 8, 2);
            $table->enum('activity_level',['Beginner','intermediate', 'Advanced'])->default('Beginner');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trainees');
    }
};
