<?php

namespace App\Services\Trainer;

use App\Models\Trainee;
use App\Repositories\TraineeRepository;

class TraineeIntegrationServices
{
    protected TraineeRepository $traineeRepository;

    public function __construct(TraineeRepository $traineeRepository)
    {
        $this->traineeRepository = $traineeRepository;
    }

    public function getTraineeProfile(int $traineeId, int $trainerId) : Trainee
    {
        return $this->traineeRepository->getTraineeProfile($traineeId, $trainerId);
    }
}
