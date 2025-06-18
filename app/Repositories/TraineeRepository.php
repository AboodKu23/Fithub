<?php

namespace App\Repositories;

use App\Models\Subscription;
use App\Models\Trainee;
use Illuminate\Support\Carbon;

class TraineeRepository
{
    public function create(array $data) : Trainee
    {
        return Trainee::create($data);
    }

    public function getTraineeProfileIfSubscription(int $trainerId, int $traineeId) : Trainee
    {
        $now = Carbon::now();

        return Subscription::with(['trainee.user', 'trainee.diseases'])
            ->where('trainee_id', $traineeId)
            ->where('trainee_id', $trainerId)
            ->where(function ($query) use ($now) {
                $query->where('end_date', '>=', $now)
                    ->orWhere('end_date', '>=', $now->copy()->subDays(2));
            })
            ->latest('end_date')
            ->first();
    }

    public function getTraineeProfileIfNotSubscription(int $traineeId) : Trainee
    {
        return Trainee::where('trainee_id', $traineeId)
            ->with(['user:id,id,first_name,last_name,email,gender'])
            ->first();
    }
}
