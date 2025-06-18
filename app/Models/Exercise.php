<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Exercise extends Model
{
    use HasFactory;
    protected $fillable = [
        'exerciseName',
        'description',
        'primaryMuscleGroup',
        'equipment',
        'videoUrl',
        'imageUrl',
        '3dModelUrl',
        'isCustom',
    ];

    protected $casts = [
        'isCustom' => 'boolean',
    ];

    public function trainingPlanExercises(): HasMany
    {
        return $this->hasMany(TrainingPlanExercise::class, 'exercise_id');
    }

    public function trainingPlans(): BelongsToMany
    {
        return $this->belongsToMany(TrainingPlan::class, 'training_plan_exercises')
            ->withPivot(['dayOfWeek', 'setNumber', 'reps', 'weightKg', 'duration', 'reset_duration', 'notes', 'orderInDay'])
            ->withTimestamps();
    }

}
