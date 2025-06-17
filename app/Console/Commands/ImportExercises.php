<?php

namespace App\Console\Commands;

use App\Models\Exercise;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class ImportExercises extends Command
{
    protected $signature = 'app:import-exercises';

    protected $description = 'Import exercises from ExerciseDB API and store them in database';

    public function handle() :int
    {
        $this->info('Starting import exercises...');

        $imported = 0;
        $limit = 1300;
        $offset = 0;

        $response = Http::withHeaders([
            'X-RapidAPI-Key' => config('services.exercisedb.key'),
            'X-RapidAPI-Host' => config('services.exercisedb.host'),
        ])->withOptions([
            'verify' => true,
            'timeout' => 120,
        ])->get('https://exercisedb.p.rapidapi.com/exercises/',[
            'limit' => $limit,
            'offset' => $offset,
        ]);

        if (!$response->successful()) {
            $this->error('Failed to import exercises.');
            $this->error('Status code: ' . $response->status());
            $this->error('Response body: ' . $response->body());
            return Command::FAILURE;
        }

        $exercises = $response->json();

        foreach ($exercises as $data) {
            if(Exercise::where('exerciseName', $data['name'])->exists()) {
                continue;
            }

            Exercise::create([
                'exerciseName' => $data['name'] ?? '',
                'description' => $data['instructions'][0] ?? '',
                'primaryMuscleGroup' => $data['bodyPart'] ?? '',
                'equipment' => $data['equipment'] ?? '',
                'videoUrl' => $data['videoUrl'] ?? null,
                'imageUrl' => $data['gifUrl'] ?? null,
                '3dModelUrl' => null,
                'isCustom' => false,
            ]);

            $imported++;
        }

        $this->info('Exercises imported: ' . $imported);
        return Command::SUCCESS;
    }
}
