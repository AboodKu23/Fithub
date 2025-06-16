<?php

namespace App\Http\Controllers\Trainee;

use App\Http\Controllers\Controller;
use App\Services\Trainee\TrainersIntegrationService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TrainersIntegrationController extends Controller
{
    protected TrainersIntegrationService $trainersIntegrationService;

    public function __construct(TrainersIntegrationService $trainersIntegrationService)
    {
        $this->trainersIntegrationService = $trainersIntegrationService;
    }

    public function getTrainers() :JsonResponse
    {
        try {
            $result = $this->trainersIntegrationService->getTrainers();
            return response()->json([
                'status' => 'success',
                'message' => 'Trainers retrieved successfully',
                'data' => $result
            ]);
        }
        catch (Exception $exception)
        {
            Log::error("Error retrieving trainers" . $exception->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'An unexpected error occurred while fetching the trainer.'
            ], 500);
        }
    }

    public function getTrainer(int $trainerId) :JsonResponse
    {
        try {

            $result = $this->trainersIntegrationService->getTrainer($trainerId);
            return response()->json([
                'status' => 'success',
                'message' => 'Trainer retrieved successfully',
                'data' => $result
            ]);
        }
        catch (Exception $exception)
        {
            Log::error("Error retrieving trainer with ID {$trainerId}: " . $exception->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'An unexpected error occurred while fetching the trainer.'
            ], 500);
        }
    }
}
