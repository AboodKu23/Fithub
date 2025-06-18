<?php

namespace App\Repositories;

use App\Models\Trainee;
use App\Models\Trainer;
use App\Models\TrainingPlan;
use Illuminate\Support\Collection;

class TrainingPlanRepository
{
    public function create(array $data): TrainingPlan
    {
        return TrainingPlan::create($data);
    }

    public function update(array $data, TrainingPlan $trainingPlan): bool
    {
        return $trainingPlan->update($data);
    }

    public function delete(TrainingPlan $trainingPlan): bool
    {
        return $trainingPlan->delete();
    }

    public function getAllTrainerTrainingPlans(Trainer $trainer): Collection
    {
        return $trainer->trainingPlans()->get();
    }

    public function getTrainerTrainingPlanById(int $trainingPlanId): TrainingPlan
    {
        return TrainingPlan::where('id', $trainingPlanId)->firstOrFail();
    }
}
