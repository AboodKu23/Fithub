<?php

namespace App\Services\Trainer;

use App\Models\Trainer;
use App\Repositories\SubscriptionRepository;
use App\Repositories\SubscriptionRequestRepository;
use Illuminate\Support\Collection;

class TrainerSubscriptionServices
{
    protected SubscriptionRequestRepository $subscriptionRequestRepository;
    protected SubscriptionRepository $subscriptionRepository;

    public function __construct(SubscriptionRequestRepository $subscriptionRequestRepository, SubscriptionRepository $subscriptionRepository)
    {
        $this->subscriptionRequestRepository = $subscriptionRequestRepository;
        $this->subscriptionRepository = $subscriptionRepository;
    }

    public function getActiveRequests(int $trainerId) : Collection
    {
        $trainer = Trainer::where('id', $trainerId)->firstOrFail();
        $activeRequest = $this->subscriptionRequestRepository->getActiveTrainerRequests($trainer);

        return $activeRequest;
    }

    public function acceptRequest(int $subscriptionId, int $trainerId) : array
    {
        $request = $this->subscriptionRequestRepository->findSubscriptionRequestById($subscriptionId);
        $trainee = $request->trainee()->first();

        if (!$request || !$trainee) {
            return [
                'success' => false,
                'message' => 'Request not found'
            ];
        }

        if ($request->request_status === 'Rejected') {
            return [
                'success' => false,
                'message' => 'Request already rejected, if you want to accept it send a request to admin.'
            ];
        }
        $this->subscriptionRequestRepository->acceptRequests($request);
        $newSubscription = $this->subscriptionRepository->create([
            'trainee_id' => $trainee->id,
            'trainer_id' => $trainerId,
            'subscription_date' => now(),
            'expire_date' => now()->addDays(30),
        ]);

//        $trainee->user->notify(new AcceptSubscriptionRequest($request));

        return [
            'success' => true,
            'message' => 'Request accepted',
            'data' => $newSubscription
        ];
    }

    public function rejectRequest(int $subscriptionId) : array
    {
        $request = $this->subscriptionRequestRepository->findSubscriptionRequestById($subscriptionId);
        $trainee = $request->trainee()->first();

        if (!$request || !$trainee) {
            return [
                'success' => false,
                'message' => 'Request not found'
            ];
        }

        if ($request->request_status === 'Approved') {
            return [
                'success' => false,
                'message' => 'Request already accepted, if you want to reject send request to admin'
            ];
        }

        $this->subscriptionRequestRepository->rejectRequests($request);
//        $trainee->user->notify(new RejectSubscriptionRequest($request));

        return [
            'success' => true,
            'message' => 'Request rejected',
            'data' => $request
        ];
    }

    public function getAcceptedRequests(int $trainerId) : Collection
    {
        $trainer = Trainer::where('id', $trainerId)->firstOrFail();
        $acceptRequest = $this->subscriptionRequestRepository->getApprovedTraineeRequests($trainer);

        return $acceptRequest;
    }

    public function getRejectedRequests(int $trainerId) : Collection
    {
        $trainer = Trainer::where('id', $trainerId)->firstOrFail();
        $rejectRequest = $this->subscriptionRequestRepository->getRejectedTraineeRequests($trainer);

        return $rejectRequest;
    }
}
