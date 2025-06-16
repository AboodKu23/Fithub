<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterStepOneRequest;
use App\Services\Auth\RegisterService;
use Illuminate\Http\JsonResponse;

class RegisterStepOneController extends Controller
{
    protected RegisterService $registerService;
    public function __construct(RegisterService $registerService)
    {
        $this->registerService = $registerService;
    }

    public function firstStepRegister(RegisterStepOneRequest $request) :JsonResponse
    {
        $tempUser = $this->registerService->handleStepOne($request->validated());
        return response()->json([
            'status' => 'success',
            'message' => 'First step registration completed',
            'temp_token' => $tempUser->temp_token,
            'data' => $tempUser
        ]);
    }
}
