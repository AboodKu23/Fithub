<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
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

    public function trainingPlanExercises() : HasMany
    {
        return $this->hasMany(TrainingPlanExercise::class, 'exercise_id', 'id');
    }

}
