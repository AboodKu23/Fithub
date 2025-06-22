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
        Schema::create('training_plan_exercises', function (Blueprint $table) {
            $table->id();
            $table->foreignId('training_plan_id')->constrained('training_plans')->onDelete('cascade');
            $table->foreignId('exercise_id')->constrained('exercises')->onDelete('cascade');
            $table->enum('dayOfWeek',['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday']);
            $table->integer('setNumber')->nullable();
            $table->integer('reps')->nullable();
            $table->decimal('weightKg')->nullable();
            $table->integer('duration')->nullable();
            $table->integer('reset_duration')->nullable();
            $table->text('notes')->nullable();
            $table->integer('orderInDay')->default(0)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('training_plan_exercises');
    }
};
