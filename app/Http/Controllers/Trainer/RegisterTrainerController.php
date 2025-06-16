<?php

namespace App\Http\Controllers\Trainer;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterTrainerRequest;
use App\Http\Requests\StoreTempCertificateRequest;
use App\Services\Trainee\TraineeRegisterService;
use App\Services\Trainer\TempCertificateService;
use App\Services\Trainer\TrainerRegisterService;
use Exception;
use Illuminate\Http\JsonResponse;

class RegisterTrainerController extends Controller
{
    protected TrainerRegisterService $trainerRegisterService;
    protected TempCertificateService $tempCertificateService;

    public function __construct(TrainerRegisterService $trainerRegisterService, TempCertificateService $tempCertificateService)
    {
        $this->trainerRegisterService = $trainerRegisterService;
        $this->tempCertificateService = $tempCertificateService;
    }

    public function addCertificate(StoreTempCertificateRequest $request) : JsonResponse
    {
        try {
            $result = $this->tempCertificateService->addCertificate($request->validated());
            return response()->json([
                'result' => $result,
                'status' => 'success',
                'message' => 'Certificate added successfully!'
            ]);
        }
        catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Adding Certificate failed!',
               'error' => config('app.debug') ? $e->getMessage() : 'Internal Server Error'
            ], 500);
        }
    }

    public function register(RegisterTrainerRequest $request) :JsonResponse
    {
        try {
            $result = $this->trainerRegisterService->completeTrainerRegistration($request->validated());
            return response()->json([
                'status' => 'success',
                'message' => 'Registration completed successfully',
                'result' => $result
            ]);
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
