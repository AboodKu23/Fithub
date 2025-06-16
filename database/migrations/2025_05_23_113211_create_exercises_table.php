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
        Schema::create('exercises', function (Blueprint $table) {
            $table->id();
            $table->string('exerciseName');
            $table->text('description')->nullable();
            $table->string('primaryMuscleGroup')->nullable();
            $table->string('equipment')->nullable();
            $table->string('videoUrl')->nullable();
            $table->string('imageUrl')->nullable();
            $table->string('3dModelUrl')->nullable();
            $table->boolean('isCustom')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exercises');
    }
};
