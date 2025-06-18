<?php

namespace App\Repositories;

use App\Models\SubscriptionTrainingPlan;

class SubscriptionPlanRepository
{
    public function create(array $data): SubscriptionTrainingPlan
    {
        return SubscriptionTrainingPlan::create($data);
    }

    public function update(array $data, SubscriptionTrainingPlan $subscriptionPlan): bool
    {
        return $subscriptionPlan->update($data);
    }

    public function delete(SubscriptionTrainingPlan $subscriptionPlan): bool
    {
        return $subscriptionPlan->delete();
    }
}
