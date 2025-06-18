<?php

namespace App\Services\Trainer;

use App\Models\Subscription;
use App\Models\Trainee;
use App\Models\Trainer;
use App\Repositories\SubscriptionRepository;
use App\Repositories\TraineeRepository;
use Illuminate\Support\Collection;

class SubscriptionService
{
    protected SubscriptionRepository $subscriptionRepository;
    protected TraineeRepository $traineeRepository;

    public function __construct(SubscriptionRepository $subscriptionRepository, TraineeRepository $traineeRepository)
    {
        $this->subscriptionRepository = $subscriptionRepository;
        $this->traineeRepository = $traineeRepository;
    }

    public function getActiveSubscriptions(int $trainerId): Collection
    {
        $trainer = Trainer::where('id', $trainerId)->firstOrFail();
        return $this->subscriptionRepository->getActiveSubscriptionsForTrainer($trainer);
    }

    public function getSubscriptionsById(int $subscriptionId): Subscription
    {
        return $this->subscriptionRepository->getSubscriptionForTrainerById($subscriptionId);
    }

}
