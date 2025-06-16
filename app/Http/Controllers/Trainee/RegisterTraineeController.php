<?php

namespace App\Http\Controllers\Trainee;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterTraineeRequest;
use App\Services\Trainee\TraineeRegisterService;
use Exception;
use Illuminate\Http\JsonResponse;

class RegisterTraineeController extends Controller
{
    protected TraineeRegisterService $traineeRegisterService;
    public function __construct(TraineeRegisterService $traineeRegisterService)
    {
        $this->traineeRegisterService = $traineeRegisterService;
    }

    public function register(RegisterTraineeRequest $request) :JsonResponse
    {
        try{
            $result = $this->traineeRegisterService->completeTraineeRegistration($request->validated());

            return response()->json([
                'status' => 'success',
                'message' => 'Registration completed successfully',
                'user_id' => $result['user']->id,
                'trainee_id' => $result['trainee']->id,
            ], 201);
        }
        catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Registration failed',
                'error' => config('app.debug') ? $e->getMessage() : 'Internal Server Error'
            ], 500);
        }
    }
}
