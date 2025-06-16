<?php

namespace App\Repositories;

use App\Models\SubscriptionRequests;
use App\Models\Trainee;
use App\Models\Trainer;
use Carbon\Month;
use Illuminate\Support\Collection;

class SubscriptionRequestRepository

{
    public function create(array $data)
    {
        return SubscriptionRequests::create($data);
    }

    public function update(SubscriptionRequests $subscriptionRequests, array $data) : bool
    {
        return $subscriptionRequests->update($data);
    }

    public function delete(SubscriptionRequests $subscriptionRequests): bool
    {
        return $subscriptionRequests->delete();
    }

    public function getThisMonthActiveRequests(Trainee $trainee, $month) : Collection
    {
        return $trainee->subscriptionRequests()
            ->whereRaw("DATE_FORMAT(request_date, '%Y-%m') = ?", [$month])
            ->whereIn('request_status',['Pending' , 'Approved'])
            ->get();
    }

    public function getAllTraineeRequests(Trainee $trainee) : Collection
    {
        return $trainee->subscriptionRequests()->get();
    }

    public function getActiveTraineeRequests(Trainee $trainee) : Collection
    {
        return $trainee->subscriptionRequests()
            ->where('request_status', 'Pending')
            ->orderBy('request_date', 'desc')
            ->get();
    }

    public function getCancelledTraineeRequests(Trainee $trainee) : Collection
    {
        return $trainee->subscriptionRequests()
            ->where('request_status', 'Cancelled')
            ->orderBy('request_date', 'desc')
            ->get();
    }

    public function getApprovedTraineeRequests(Trainee $trainee) : Collection
    {
        return $trainee->subscriptionRequests()
            ->where('request_status', 'Approved')
            ->orderBy('request_date', 'desc')
            ->get();
    }

    public function getRejectedTraineeRequests(Trainee $trainee) : Collection
    {
        return $trainee->subscriptionRequests()
            ->where('request_status', 'Rejected')
            ->orderBy('request_date', 'desc')
            ->get();
    }

    public function cancelRequests(SubscriptionRequests $subscriptionRequests) : bool
    {
        return $subscriptionRequests->update(['request_status' => 'Cancelled']);
    }


    public  function acceptRequests(SubscriptionRequests $subscriptionRequests) : bool
    {
        return $subscriptionRequests->update(['request_status' => 'Approved']);
    }

    public function rejectRequests(SubscriptionRequests $subscriptionRequests) : bool
    {
        return $subscriptionRequests->update(['request_status' => 'Rejected']);
    }

    public function getActiveTrainerRequests(Trainer $trainer) : Collection
    {
        return $trainer->subscriptionRequests()
            ->whereIn('request_status', ['Pending'])
            ->orderBy('request_date', 'desc')
            ->get();
    }

    public function getApprovedTrainerRequests(Trainer $trainer) : Collection
    {
        return $trainer->subscriptionRequests()
            ->whereIn('request_status', ['Approved'])
            ->orderBy('request_date', 'desc')
            ->get();
    }

    public function getRejectedTrainerRequests(Trainer $trainer) : Collection
    {
        return $trainer->subscriptionRequests()
            ->whereIn('request_status', ['Rejected'])
            ->orderBy('request_date', 'desc')
            ->get();
    }
}
