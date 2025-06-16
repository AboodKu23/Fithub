<?php

namespace App\Services\Auth;

use App\Http\Requests\ResendVerificationRequest;
use App\Notifications\VerificationCodeNotification;
use App\Repositories\UserRepository;
use App\Mail\VerificationEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;


class EmailVerificationService
{
    protected UserRepository $userRepository;
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function verifyEmail(string $code) : array
    {
        $user = $this->userRepository->getByVerificationCode($code);
        if (!$user) {
            return [
                'status' => false,
                'message' => 'Invalid code'
            ];
        }

        if ($user->hasVerifiedEmail()){
            return [
                'status' => false,
                'message' => 'Email already verified'
            ];
        }

        $this->userRepository->verifyEmail($user);
        return [
            'status' => true,
            'message' => 'Email verified'
        ];
    }

    public function resendVerificationEmail(ResendVerificationRequest $request) : array
    {
        $user = $request->user();
        if ($user->hasVerifiedEmail()){
            return [
                'status' => false,
                'message' => 'Email already verified'
            ];
        }

        if(!$this->userRepository->canResendVerificationEmail($user)){
            return [
                'status' => false,
                'message' => 'Please wait before requesting another verification email.'
            ];
        }

        $code = $this->userRepository->generateVerificationCode($user);
        $user->notify(new VerificationCodeNotification($code));

        return [
            'status' => true,
            'message' => 'Verification email sent'
        ];
    }
}
