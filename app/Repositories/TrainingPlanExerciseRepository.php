<?php

namespace App\Repositories;

use App\Models\TrainingPlanExercise;
use Illuminate\Support\Collection;

class TrainingPlanExerciseRepository
{
    public function create(array $data)
    {
        return TrainingPlanExercise::create($data);
    }

    public function saveDayExercise(int $planId, int $dayNumber, array $data): void
    {
        TrainingPlanExercise::where('training_plan_id', $planId)
            ->where('dayNumber', $dayNumber)
            ->delete();

        foreach ($data as $exercise) {
            if (!$this->existsInDay($planId, $dayNumber, $exercise['exercise_id'])) {
                $this->create([
                    'training_plan_id' => $planId,
                    'exercise_id' => $exercise['exercise_id'],
                    'dayNumber' => $dayNumber,
                ]);
            }
        }
    }

    public function addExerciseDetailsInTheTrainingPlan(int $trainingPlanExerciseId, array $data): bool
    {
        $PlanExercise = TrainingPlanExercise::where('id', $trainingPlanExerciseId)->first();
        return $this->update($PlanExercise, ['setNumber' => $data['setNumber'] ?? null,
        'reps' => $data['reps'] ?? null,
        'weightKg' => $data['weightKg'] ?? null,
        'duration' => $data['duration'] ?? null,
        'reset_duration' => $data['reset_duration'] ?? null,
        'notes' => $data['notes'] ?? null,
        'orderInDay' => $data['orderInDay'] ?? null
            ]
        );

    }

    public function update(TrainingPlanExercise $trainingPlanExercise, array $data): bool
    {
        return $trainingPlanExercise->update($data);
    }

    public function getAllExercisesForPlan(int $planId): Collection
    {
        return TrainingPlanExercise::where('training_plan_id', $planId)
            ->with('exercise')
            ->orderBy('dayNumber')
            ->orderBy('orderInDay')
            ->get();
    }

    public function getPlanExerciseById(int $trainingPlanExerciseId): TrainingPlanExercise
    {
        return TrainingPlanExercise::where('id', $trainingPlanExerciseId)->findOrFail();
    }

    public function getExerciseByDayNumber(int $planExerciseId ,int $dayNumber): Collection
    {
        return TrainingPlanExercise::where('id', $planExerciseId)
            ->where('dayNumber', $dayNumber)
            ->with('exercise')
            ->get();
    }

    public function existsInDay(int $planId, int $dayNumber, int $exerciseId): bool
    {
        return TrainingPlanExercise::where('training_plan_id', $planId)
            ->where('dayNumber', $dayNumber)
            ->where('exercise_id', $exerciseId)
            ->exists();
    }
}
