<?php

namespace App\Repositories;

use App\Models\Trainee;

class TraineeRepository
{
    public function create(array $data) : Trainee
    {
        return Trainee::create($data);
    }
}
