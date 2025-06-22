<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TrainingPlanExercise extends Model
{
    use HasFactory;

    protected $fillable = [
        'training_plan_id',
        'exercise_id',
        'dayNumber',
        'setNumber',
        'reps',
        'weightKg',
        'duration',
        'reset_duration',
        'notes',
        'orderInDay',
    ];

    public function trainingPlan() : BelongsTo
    {
        return $this->belongsTo(TrainingPlan::class, 'training_plan_id');
    }

    public function exercise() : BelongsTo
    {
        return $this->belongsTo(Exercise::class, 'exercise_id');
    }
}
