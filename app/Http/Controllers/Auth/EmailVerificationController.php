<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\ResendVerificationRequest;
use App\Http\Requests\VerificationCodeRequest;
use App\Services\Auth\EmailVerificationService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Js;
use Throwable;

class EmailVerificationController extends Controller
{
    protected EmailVerificationService $emailVerificationService;

    public function __construct(EmailVerificationService $emailVerificationService)
    {
        $this->emailVerificationService = $emailVerificationService;
    }

    public function verify(VerificationCodeRequest $request): JsonResponse
    {
        try {
            $response = $this->emailVerificationService->verifyEmail($request['code']);
            return response()->json($response, $response['status']? 200 : 422);
        } catch (Throwable $e) {
            Log::error('Failed to verify email' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Failed to verify email.',
            ]);
        }
    }

    public function resend(ResendVerificationRequest $request): JsonResponse
    {
        try {
            $response = $this->emailVerificationService->resendVerificationEmail($request);
            return response()->json($response, $response['status'] ? 200 : 422);
        } catch (Throwable $e) {
            Log::error('Failed to resend verification email' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to resend verification email.',
            ]);
        }
    }
}
