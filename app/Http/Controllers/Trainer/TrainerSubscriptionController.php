<?php

namespace App\Http\Controllers\Trainer;

use App\Http\Controllers\Controller;
use App\Services\Trainer\TrainerSubscriptionServices;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Throwable;
use function PHPUnit\Framework\isEmpty;

class TrainerSubscriptionController extends Controller
{
    protected TrainerSubscriptionServices $trainersSubscriptionServices;

    public function __construct(TrainerSubscriptionServices $trainersSubscriptionServices)
    {
        $this->trainersSubscriptionServices = $trainersSubscriptionServices;
    }

    public function getActiveRequest() :JsonResponse
    {
        try {
            $user = Auth::user();
            $trainer = $user->trainer()->first();

            $requests = $this->trainersSubscriptionServices->getActiveRequests($trainer->id);
            if (!$requests) {
                return response()->json([
                    'success' => false,
                    'message' => 'No active requests found',
                ]);
            }

            return response()->json([
                'success' => true,
                'data' => $requests,
                'message' => 'Requests found',
            ]);
        }
        catch (Throwable $e) {
            Log::error('Failed to accept subscription requests: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to get subscription requests.',
            ]);
        }
    }

    public function acceptRequest(int $requestId) :JsonResponse
    {
        try {
            $user = Auth::user();
            $trainer = $user->trainer()->first();

            $newSubscription = $this->trainersSubscriptionServices->acceptRequest($requestId, $trainer->id);

            return response()->json([
                'success' => true,
                'message' => 'Request accepted',
                'data' => $newSubscription
            ]);
        }
        catch (Throwable $e) {
            Log::error('Failed to accept subscription requests: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to accept subscription requests.',
                'error' => $e->getMessage(),
            ]);
        }
    }

    public function rejectRequest(int $requestId) :JsonResponse
    {
        try {
            $response = $this->trainersSubscriptionServices->rejectRequest($requestId);
            return response()->json([
                'success' => true,
                'message' => 'Request rejected',
                'data' => $response
            ]);
        }
        catch (Throwable $e) {
            Log::error('Failed to reject subscription requests: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to reject subscription requests.',
                'error' => $e->getMessage(),
            ]);
        }
    }

    public function getApprovedRequests() :JsonResponse
    {
        try {
            $user = Auth::user();
            $trainer = $user->trainer()->first();

            $response = $this->trainersSubscriptionServices->getAcceptedRequests($trainer->id);
            return response()->json([
                'success' => true,
                'message' => 'Requests found',
                'data' => $response
            ]);
        }
        catch (Throwable $e) {
            Log::error('Failed to accept subscription requests: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to get approved requests.',
                'error' => $e->getMessage(),
            ]);
        }
    }

    public function getRejectedRequests() :JsonResponse
    {
        try {
            $user = Auth::user();
            $trainer = $user->trainer()->first();

            $response = $this->trainersSubscriptionServices->getRejectedRequests($trainer->id);
            return response()->json([
                'success' => true,
                'message' => 'Requests found',
                'data' => $response
            ]);
        }
        catch (Throwable $e) {
            Log::error('Failed to get requests: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to get requests.',
                'error' => $e->getMessage(),
            ]);
        }
    }

}
