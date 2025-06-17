<?php

namespace App\Repositories;

use App\Models\Subscription;

class SubscriptionRepository
{
    public function create(array $data) : Subscription
    {
        return Subscription::create($data);
    }

    public function update(Subscription $subscription, array $data) : bool
    {
        return $subscription->update($data);
    }

    public function delete(Subscription $subscription) : bool
    {
        return $subscription->delete();
    }

}
