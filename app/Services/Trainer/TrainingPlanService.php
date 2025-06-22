<?php

namespace App\Services\Trainer;

use App\Models\TrainingPlan;
use App\Models\TrainingPlanExercise;
use App\Repositories\ExerciseRepository;
use App\Repositories\TrainingPlanExerciseRepository;
use App\Repositories\TrainingPlanRepository;
use Illuminate\Support\Collection;

class TrainingPlanService
{
    protected  TrainingPlanExerciseRepository $trainingPlanExerciseRepository;
    protected  TrainingPlanRepository $trainingPlanRepository;
    protected ExerciseRepository $exerciseRepository;

    public function __construct(TrainingPlanExerciseRepository $trainingPlanExerciseRepository, TrainingPlanRepository $trainingPlanRepository, ExerciseRepository $exerciseRepository)
    {
        $this->trainingPlanExerciseRepository = $trainingPlanExerciseRepository;
        $this->trainingPlanRepository = $trainingPlanRepository;
        $this->exerciseRepository = $exerciseRepository;
    }

    public function createNewPlan(array $data): TrainingPlan
    {
        return $this->trainingPlanRepository->create($data);
    }

    public function saveSelectedExerciseInDay(int $trainingPlanId ,array $data): void
    {
         $this->trainingPlanExerciseRepository->saveDayExercise(
            $trainingPlanId,
            $data['exercise_id'],
            $data['dayNumber'],
        );
    }

    public function getPlanExercise(int $trainingPlanId): Collection
    {
        return $this->trainingPlanExerciseRepository->getAllExercisesForPlan($trainingPlanId);
    }

    public function getPlanExerciseById(int $trainingPlanId): TrainingPlanExercise
    {
        return $this->trainingPlanExerciseRepository->getPlanExerciseById($trainingPlanId);
    }

    public function addSelectedExerciseDetails(int $planExerciseId, array $data): bool
    {
        return $this->trainingPlanExerciseRepository->addExerciseDetailsInTheTrainingPlan($planExerciseId, $data);
    }

    public function getExerciseByDay(int $planExerciseId, int $dayNumber): Collection
    {
        return $this->trainingPlanExerciseRepository->getExerciseByDayNumber($planExerciseId, $dayNumber);
    }
}
