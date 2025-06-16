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
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('trainer_id')->constrained('trainers')->onDelete('cascade');
            $table->foreignId('trainee_id')->constrained('trainees')->onDelete('cascade');
            $table->date('subscription_date');
            $table->date('expire_date');
            $table->enum('status', ['Active', 'Expired','Cancelled'])->default('Active');
            $table->enum('trainee_rating',[0,1,2,3,4,5])->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subscriptions');
    }
};
