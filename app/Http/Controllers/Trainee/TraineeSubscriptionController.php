<?php

namespace App\Http\Controllers\Trainee;

use App\Http\Controllers\Controller;
use App\Models\Trainer;
use App\Services\Trainee\TraineeSubscriptionServices;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Throwable;

class TraineeSubscriptionController extends Controller
{
    protected TraineeSubscriptionServices $service;

    public function __construct(TraineeSubscriptionServices $service)
    {
        $this->service = $service;
    }

    public function sendSubscriptionRequest($traineeId) : JsonResponse
    {
        try {
            $trainee = Auth::user();
            $trainer = Trainer::find($traineeId);

            $request = $this->service->sendSubscriptionRequest($trainee, $trainer);
            return response()->json([
                'success' => true,
                'requests' => $request,
                'message' => 'Subscription requests retrieved successfully.',
            ]);
        }
        catch (Throwable $e) {
            Log::error('Failed to get subscription requests: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Failed to get subscription requests.',
            ]);
        }
    }
}
