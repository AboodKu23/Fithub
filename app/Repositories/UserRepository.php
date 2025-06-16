<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository
{
    public function create(array $data)
    {
        return User::create($data);
    }

    public function getByVerificationCode(string $code): ?User
    {
        return User::where('verification_code', $code)->first();
    }

    public function generateVerificationCode(User $user) : string
    {
        $code = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        $codeList = User::where('verification_code', $code)->get();
        if (count($codeList) > 0) {
            return $this->generateVerificationCode($user);
        }
        $user->update(['verification_code' => $code,
            'email_verification_sent_at' => now(),
            'code_expires_at' => now()->addMinutes(10)
            ]);

        return $code;
    }

    public function verifyEmail(User $user) : bool
    {
        return $user->markEmailAsVerified();
    }

    public function canResendVerificationEmail(User $user) : bool
    {
        if (!$user->email_verification_sent_at) {
            return true;
        }

        return $user->email_verification_sent_at->addMinutes(1)->isPast();
    }
}
