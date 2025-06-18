<?php

namespace App\Repositories;

use App\Models\Exercise;
use Illuminate\Pagination\LengthAwarePaginator;

class ExerciseRepository
{
    public function create(array $data): Exercise
    {
        return Exercise::create($data);
    }

    public function update(Exercise $exercise, array $data): bool
    {
        return $exercise->update($data);
    }

    public function delete(Exercise $exercise): bool
    {
        return $exercise->delete();
    }

    public function getAllExercises(int $perPage): LengthAwarePaginator
    {
        return Exercise::select(
            'id',
            'exerciseName',
            'description',
            'primaryMuscleGroup',
            'equipment',
            'videoUrl',
            'imageUrl',
            '3dModelUrl',
            'isCustom'
        )->paginate($perPage);
    }

    public function getExerciseById(int $ExerciseId): Exercise
    {
        return Exercise::where('id', $ExerciseId)->firstOrFail();
    }
}
