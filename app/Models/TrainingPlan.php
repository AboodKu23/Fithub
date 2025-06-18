<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TrainingPlan extends Model
{
    use HasFactory;

    protected $fillable = [
        'trainer_id',
        'title',
        'goal',
        'notes'
    ];

    public function trainer(): BelongsTo
    {
        return $this->belongsTo(Trainer::class, 'trainer_id');
    }

    public function trainingPlanExercises(): HasMany
    {
        return $this->hasMany(TrainingPlanExercise::class, 'training_plan_id');
    }

    public function exercises(): BelongsToMany
    {
        return $this->belongsToMany(Exercise::class, 'training_plan_exercises')
            ->withPivot(['dayOfWeek', 'setNumber', 'reps', 'weightKg', 'duration', 'reset_duration', 'notes', 'orderInDay'])
            ->withTimestamps();
    }

    public function subscriptions(): BelongsToMany
    {
        return $this->belongsToMany(Subscription::class, 'subscription_training_plan')
            ->withTimestamps();
    }

}
