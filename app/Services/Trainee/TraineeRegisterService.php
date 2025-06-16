<?php

namespace App\Services\Trainee;

use App\Notifications\VerificationCodeNotification;
use App\Repositories\TempUserRepository;
use App\Repositories\TraineeRepository;
use App\Repositories\UserRepository;
use Exception;
use Illuminate\Auth\Events\Registered;
use App\Mail\VerificationEmail;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class TraineeRegisterService
{
    protected TempUserRepository $tempUserRepo;
    protected UserRepository $userRepo;
    protected TraineeRepository $traineeRepo;

    public function __construct(TempUserRepository $tempUserRepo, UserRepository $userRepo, TraineeRepository $traineeRepo)
    {
        $this->tempUserRepo = $tempUserRepo;
        $this->userRepo = $userRepo;
        $this->traineeRepo = $traineeRepo;
    }

    public function completeTraineeRegistration(array $traineeData) : array
    {
        $tempUser = $this->tempUserRepo->getByToken($traineeData['temp_token']);
        if(!$tempUser)
        {
            return [
                'success' => false,
                'message' => 'Invalid Token'
            ];
        }
        $user = $this->userRepo->create([
            'first_name' => $tempUser->first_name,
            'last_name' => $tempUser->last_name,
            'user_type' => 'Trainee',
            'gender' => $tempUser->gender,
            'phone_number' => $tempUser->phone_number,
            'country' => $tempUser->country,
            'city' => $tempUser->city,
            'region' => $tempUser->region,
            'email' => $tempUser->email,
            'password' => $tempUser->password,
        ]);

        $trainee = $this->traineeRepo->create([
            'trainee_id' => $user->id,
            'height' => $traineeData['height'],
            'weight' => $traineeData['weight'],
            'activity_level' => $traineeData['activity_level'],
        ]);
        $this->tempUserRepo->delete($tempUser);
        $code = $this->userRepo->generateVerificationCode($user);
        $user->notify(new VerificationCodeNotification($code));
        return [
            'user' => $user,
            'trainee' => $trainee,
            'verify-token' => $code
        ];
    }
}
