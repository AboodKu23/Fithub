<?php

namespace App\Services\Trainer;

use App\Models\Trainee;
use App\Repositories\SubscriptionRepository;
use App\Repositories\TraineeRepository;
use Illuminate\Http\JsonResponse;

class TraineeIntegrationService
{
    protected TraineeRepository $traineeRepository;
    protected SubscriptionRepository $subscriptionRepository;

    public function __construct(TraineeRepository $traineeRepository, SubscriptionRepository $subscriptionRepository)
    {
        $this->traineeRepository = $traineeRepository;
        $this->subscriptionRepository = $subscriptionRepository;
    }

    public function getTraineeInfo(int $trainerId, int $traineeId): Trainee
    {
        if (!$this->subscriptionRepository->ifHasActiveSubscription($traineeId,$trainerId)) {
            return $this->traineeRepository->getTraineeProfileIfNotSubscription($traineeId);
        }
        else
            return $this->traineeRepository->getTraineeProfileIfSubscription($trainerId, $traineeId);
    }
}
